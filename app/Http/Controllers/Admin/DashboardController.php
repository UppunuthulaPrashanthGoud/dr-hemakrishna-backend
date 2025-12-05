<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Appointment;
use Hash;

class DashboardController extends Controller
{
    public function index()
    {
        // Get payment statistics
        $onlinePayments = Appointment::where('payment_method', 'online')
                                    ->where('payment_status', 'completed')
                                    ->sum('amount');
        
        $offlinePayments = Appointment::where('payment_method', 'offline')
                                     ->where('payment_status', 'completed')
                                     ->sum('amount');
        
        $totalAppointments = Appointment::count();
        $pendingAppointments = Appointment::where('status', 'pending')->count();

        return view('pages.dashboard.index', compact('onlinePayments', 'offlinePayments', 'totalAppointments', 'pendingAppointments'));
    }

    
    public function profile(Request $request)
    {
        $user = User::where('id',$request->user()->id)->first();
        return view('pages.profile.index', compact('user'));
    }

    public function update_profile(Request $request)
    {
        $data = [];
        if ($request->username) {
            $data['name'] = $request->username;
        }if ($request->email) {
            $data['email'] = $request->email;
        }
        

        if ($request->oldPassword && $request->newPassword) {
            
            if(!$request->oldPassword || !$request->newPassword){
                return redirect()->back()->with('error', 'Old and New passwords required');
            }

            if (Hash::check($request->oldPassword, $request->user()->password)) {
                $data['password'] = Hash::make($request->newPassword);
                User::where('id', $request->user()->id)->update($data);
                $message = 'Password has been updated';
                return redirect()->back()->with('success', 'Password and details has been updated');
            }
            return redirect()->back()->with('error', 'Old password not matched');
        } else {
            User::where('id', $request->user()->id)->update($data);
        }
        return redirect()->back()->with('success', 'Details has been update');
    }
}