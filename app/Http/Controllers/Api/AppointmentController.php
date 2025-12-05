<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Contact;
use App\CPU\Payment;
use Validator;
use Log;

class AppointmentController extends Controller
{
    public function getDashboardStats()
    {
        try {
            Log::info('Fetching dashboard statistics');
            
            // Get payment statistics
            $onlinePayments = Appointment::where('payment_method', 'online')
                                        ->where('payment_status', 'completed')
                                        ->sum('amount');
            
            $offlinePayments = Appointment::where('payment_method', 'offline')
                                         ->where('payment_status', 'completed')
                                         ->sum('amount');
            
            $totalAppointments = Appointment::count();
            $pendingAppointments = Appointment::where('status', 'pending')->count();

            Log::info('Dashboard statistics fetched successfully', [
                'online_payments' => $onlinePayments,
                'offline_payments' => $offlinePayments,
                'total_appointments' => $totalAppointments,
                'pending_appointments' => $pendingAppointments
            ]);

            return response()->json([
                'totalAppointments' => $totalAppointments,
                'pendingAppointments' => $pendingAppointments,
                'onlinePayments' => (float)$onlinePayments,
                'offlinePayments' => (float)$offlinePayments
            ], 200);
        } catch (\Exception $e) {
            Log::error('Dashboard Stats Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong!'
            ], 500);
        }
    }

    public function getAppointments()
    {
        try {
            Log::info('Fetching all appointments');
            $appointments = Appointment::orderBy('created_at', 'desc')->get();
            
            Log::info('Appointments fetched successfully', [
                'count' => $appointments->count()
            ]);
            
            return response()->json($appointments, 200);
        } catch (\Exception $e) {
            Log::error('Get Appointments Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong!'
            ], 500);
        }
    }

    public function storeAppointment(Request $request)
    {
        try {
            Log::info('Appointment booking request received', [
                'request_data' => $request->all(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
            
            $validator = Validator::make($request->all(), [
                'fullname' => 'required|string|max:255',
                'mobile' => 'required|string|max:15',
                'email' => 'nullable|email|max:255',
                'selected_date' => 'required|date|after:today',
                'selected_time' => 'required',
                'reason' => 'required|string',
                'message' => 'nullable|string',
                'payment_method' => 'required|in:online,offline',
                'amount' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                Log::warning('Appointment validation failed', [
                    'errors' => $validator->errors(),
                    'request_data' => $request->all()
                ]);
                return response()->json([
                    'status' => 400,
                    'message' => $validator->errors()
                ], 400);
            }

            $appointmentData = [
                'fullname' => $request->fullname,
                'mobile' => $request->mobile,
                'email' => $request->email ?? 'usernotselected@gmail.com',
                'selected_date' => $request->selected_date,
                'selected_time' => $request->selected_time,
                'reason' => $request->reason,
                'message' => $request->message,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'amount' => $request->amount,
                'payment_status' => $request->payment_method === 'offline' ? 'pending' : 'unpaid'
            ];

            Log::info('Processing appointment with payment method: ' . $request->payment_method);
            
            // If online payment, we'll create a transaction ID
            if ($request->payment_method === 'online') {
                $appointmentData['transaction_id'] = uniqid('txn_');
                
                Log::info('Creating Razorpay order', [
                    'amount' => $request->amount
                ]);
                
                // Create Razorpay order
                $razorpayOrder = Payment::razorpay_order($request->amount);
                
                if (!$razorpayOrder) {
                    Log::error('Failed to create Razorpay order');
                    return response()->json([
                        'status' => 500,
                        'message' => 'Failed to create payment order'
                    ], 500);
                }
                
                Log::info('Razorpay order created successfully', [
                    'order_id' => $razorpayOrder['id']
                ]);
                
                $appointmentData['transaction_id'] = $razorpayOrder['id'];
            }

            Log::info('Creating appointment record', [
                'appointment_data' => $appointmentData
            ]);
            
            $appointment = Appointment::create($appointmentData);
            
            Log::info('Appointment created successfully', [
                'appointment_id' => $appointment->id
            ]);

            $responseData = [
                'status' => 200,
                'message' => 'Appointment booked successfully!',
                'appointment_id' => $appointment->id,
                'payment_method' => $request->payment_method,
                'transaction_id' => $appointment->transaction_id ?? null
            ];

            // If online payment, include Razorpay order details
            if ($request->payment_method === 'online' && isset($razorpayOrder)) {
                $responseData['razorpay_order_id'] = $razorpayOrder['id'];
                $responseData['razorpay_key_id'] = env('RAZORPAY_KEY_ID', 'rzp_test_T4AraVExlu3Idf');
                $responseData['amount'] = $razorpayOrder['amount'];
            }

            Log::info('Appointment booking completed successfully', [
                'response_data' => $responseData
            ]);

            return response()->json($responseData, 200);

        } catch (\Exception $e) {
            Log::error('Appointment Booking Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong!'
            ], 500);
        }
    }

    public function updatePaymentStatus(Request $request)
    {
        try {
            Log::info('Update payment status request received', [
                'request_data' => $request->all(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
            
            $validator = Validator::make($request->all(), [
                'appointment_id' => 'required|exists:appointments,id',
                'payment_status' => 'required|in:completed,failed,pending,unpaid',
                'transaction_id' => 'nullable|string',
                'razorpay_payment_id' => 'nullable|string',
                'razorpay_signature' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                Log::warning('Payment status validation failed', [
                    'errors' => $validator->errors(),
                    'request_data' => $request->all()
                ]);
                return response()->json([
                    'status' => 400,
                    'message' => $validator->errors()
                ], 400);
            }

            $appointment = Appointment::find($request->appointment_id);
            
            if (!$appointment) {
                Log::warning('Appointment not found', [
                    'appointment_id' => $request->appointment_id
                ]);
                return response()->json([
                    'status' => 404,
                    'message' => 'Appointment not found'
                ], 404);
            }

            Log::info('Processing payment for appointment', [
                'appointment_id' => $appointment->id,
                'current_payment_status' => $appointment->payment_status,
                'new_payment_status' => $request->payment_status,
                'has_razorpay_payment_id' => !empty($request->razorpay_payment_id),
                'has_razorpay_signature' => !empty($request->razorpay_signature)
            ]);

            // Verify Razorpay payment if it's an online payment
            if ($request->razorpay_payment_id && $request->razorpay_signature) {
                Log::info('Verifying Razorpay payment', [
                    'order_id' => $appointment->transaction_id,
                    'payment_id' => $request->razorpay_payment_id
                ]);
                
                $verified = Payment::verify_signature([
                    'razorpay_order_id' => $appointment->transaction_id,
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'razorpay_signature' => $request->razorpay_signature
                ]);
                
                if (!$verified) {
                    Log::error('Razorpay payment verification failed');
                    return response()->json([
                        'status' => 400,
                        'message' => 'Payment verification failed'
                    ], 400);
                }
                
                $request->payment_status = 'completed';
                Log::info('Razorpay payment verified successfully');
            }

            $appointment->payment_status = $request->payment_status;
            
            if ($request->transaction_id) {
                $appointment->transaction_id = $request->transaction_id;
            }
            
            $appointment->save();
            
            Log::info('Payment status updated successfully', [
                'appointment_id' => $appointment->id,
                'payment_status' => $request->payment_status,
                'transaction_id' => $appointment->transaction_id
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Payment status updated successfully!',
                'appointment' => $appointment
            ], 200);

        } catch (\Exception $e) {
            Log::error('Payment Status Update Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong!'
            ], 500);
        }
    }

    public function updateAppointmentStatus(Request $request, $id)
    {
        try {
            Log::info('Update appointment status request received', [
                'appointment_id' => $id,
                'request_data' => $request->all()
            ]);
            
            $validator = Validator::make($request->all(), [
                'status' => 'required|in:pending,confirmed,cancelled'
            ]);

            if ($validator->fails()) {
                Log::warning('Appointment status validation failed', [
                    'errors' => $validator->errors()
                ]);
                return response()->json([
                    'status' => 400,
                    'message' => $validator->errors()
                ], 400);
            }

            $appointment = Appointment::findOrFail($id);
            $appointment->status = $request->status;
            $appointment->save();
            
            Log::info('Appointment status updated successfully', [
                'appointment_id' => $appointment->id,
                'status' => $request->status
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Appointment status updated successfully!',
                'appointment' => $appointment
            ], 200);

        } catch (\Exception $e) {
            Log::error('Appointment Status Update Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'appointment_id' => $id,
                'request_data' => $request->all()
            ]);
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong!'
            ], 500);
        }
    }

    public function updatePaymentStatusById(Request $request, $id)
    {
        try {
            Log::info('Update payment status by ID request received', [
                'appointment_id' => $id,
                'request_data' => $request->all()
            ]);
            
            $validator = Validator::make($request->all(), [
                'payment_status' => 'required|in:pending,completed,failed,unpaid'
            ]);

            if ($validator->fails()) {
                Log::warning('Payment status validation failed', [
                    'errors' => $validator->errors()
                ]);
                return response()->json([
                    'status' => 400,
                    'message' => $validator->errors()
                ], 400);
            }

            $appointment = Appointment::findOrFail($id);
            $appointment->payment_status = $request->payment_status;
            $appointment->save();
            
            Log::info('Payment status updated successfully', [
                'appointment_id' => $appointment->id,
                'payment_status' => $request->payment_status
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Payment status updated successfully!',
                'appointment' => $appointment
            ], 200);

        } catch (\Exception $e) {
            Log::error('Payment Status Update Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'appointment_id' => $id,
                'request_data' => $request->all()
            ]);
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong!'
            ], 500);
        }
    }

    public function storeContact(Request $request)
    {
        try {
            Log::info('Contact form submission received', [
                'request_data' => $request->all()
            ]);
            
            $validator = Validator::make($request->all(), [
                'fullname' => 'required|string|max:255',
                'mobile' => 'required|string|max:15',
                'email' => 'nullable|email|max:255',
                'reason' => 'required|string',
                'message' => 'required|string'
            ]);

            if ($validator->fails()) {
                Log::warning('Contact form validation failed', [
                    'errors' => $validator->errors()
                ]);
                return response()->json([
                    'status' => 400,
                    'message' => $validator->errors()
                ], 400);
            }

            $contact = Contact::create([
                'fullname' => $request->fullname,
                'mobile' => $request->mobile,
                'email' => $request->email ?? 'usernotselected@gmail.com',
                'reason' => $request->reason,
                'message' => $request->message,
                'status' => 'unread'
            ]);
            
            Log::info('Contact form submitted successfully', [
                'contact_id' => $contact->id
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Message sent successfully!'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Contact Form Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong!'
            ], 500);
        }
    }
}