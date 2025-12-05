<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Contact;
use App\CPU\Payment;
use Validator;

class AppointmentController extends Controller
{
    public function getDashboardStats()
    {
        try {
            // Get payment statistics
            $onlinePayments = Appointment::where('payment_method', 'online')
                                        ->where('payment_status', 'completed')
                                        ->sum('amount');
            
            $offlinePayments = Appointment::where('payment_method', 'offline')
                                         ->where('payment_status', 'completed')
                                         ->sum('amount');
            
            $totalAppointments = Appointment::count();
            $pendingAppointments = Appointment::where('status', 'pending')->count();

            return response()->json([
                'totalAppointments' => $totalAppointments,
                'pendingAppointments' => $pendingAppointments,
                'onlinePayments' => (float)$onlinePayments,
                'offlinePayments' => (float)$offlinePayments
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong!'
            ], 500);
        }
    }

    public function getAppointments()
    {
        try {
            $appointments = Appointment::orderBy('created_at', 'desc')->get();
            
            return response()->json($appointments, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong!'
            ], 500);
        }
    }

    public function storeAppointment(Request $request)
    {
        try {
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

            // If online payment, we'll create a transaction ID
            if ($request->payment_method === 'online') {
                $appointmentData['transaction_id'] = uniqid('txn_');
                
                // Create Razorpay order
                $razorpayOrder = Payment::razorpay_order($request->amount);
                
                if (!$razorpayOrder) {
                    return response()->json([
                        'status' => 500,
                        'message' => 'Failed to create payment order'
                    ], 500);
                }
                
                $appointmentData['transaction_id'] = $razorpayOrder['id'];
            }

            $appointment = Appointment::create($appointmentData);

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

            return response()->json($responseData, 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong!'
            ], 500);
        }
    }

    public function updatePaymentStatus(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'appointment_id' => 'required|exists:appointments,id',
                'payment_status' => 'required|in:completed,failed,pending,unpaid',
                'transaction_id' => 'nullable|string',
                'razorpay_payment_id' => 'nullable|string',
                'razorpay_signature' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => $validator->errors()
                ], 400);
            }

            $appointment = Appointment::find($request->appointment_id);
            
            if (!$appointment) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Appointment not found'
                ], 404);
            }

            // Verify Razorpay payment if it's an online payment
            if ($request->razorpay_payment_id && $request->razorpay_signature) {
                $verified = Payment::verify_signature([
                    'razorpay_order_id' => $appointment->transaction_id,
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'razorpay_signature' => $request->razorpay_signature
                ]);
                
                if (!$verified) {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Payment verification failed'
                    ], 400);
                }
                
                $request->payment_status = 'completed';
            }

            $appointment->payment_status = $request->payment_status;
            
            if ($request->transaction_id) {
                $appointment->transaction_id = $request->transaction_id;
            }
            
            $appointment->save();

            return response()->json([
                'status' => 200,
                'message' => 'Payment status updated successfully!',
                'appointment' => $appointment
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong!'
            ], 500);
        }
    }

    public function updateAppointmentStatus(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'status' => 'required|in:pending,confirmed,cancelled'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => $validator->errors()
                ], 400);
            }

            $appointment = Appointment::findOrFail($id);
            $appointment->status = $request->status;
            $appointment->save();

            return response()->json([
                'status' => 200,
                'message' => 'Appointment status updated successfully!',
                'appointment' => $appointment
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong!'
            ], 500);
        }
    }

    public function updatePaymentStatusById(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'payment_status' => 'required|in:pending,completed,failed,unpaid'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => $validator->errors()
                ], 400);
            }

            $appointment = Appointment::findOrFail($id);
            $appointment->payment_status = $request->payment_status;
            $appointment->save();

            return response()->json([
                'status' => 200,
                'message' => 'Payment status updated successfully!',
                'appointment' => $appointment
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong!'
            ], 500);
        }
    }

    public function storeContact(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'fullname' => 'required|string|max:255',
                'mobile' => 'required|string|max:15',
                'email' => 'nullable|email|max:255',
                'reason' => 'required|string',
                'message' => 'required|string'
            ]);

            if ($validator->fails()) {
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

            return response()->json([
                'status' => 200,
                'message' => 'Message sent successfully!'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong!'
            ], 500);
        }
    }
}