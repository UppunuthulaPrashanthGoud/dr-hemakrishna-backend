<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::orderBy('created_at', 'desc')->get();
        return view('pages.appointments.index', compact('appointments'));
    }

    public function show($id)
    {
        $appointment = Appointment::findOrFail($id);
        return view('pages.appointments.show', compact('appointment'));
    }

    public function updateStatus(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = $request->status;
        $appointment->save();

        return redirect()->back()->with('success', 'Appointment status updated successfully!');
    }

    public function updatePaymentStatus(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->payment_status = $request->payment_status;
        $appointment->save();

        return redirect()->back()->with('success', 'Payment status updated successfully!');
    }
}