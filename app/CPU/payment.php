<?php

namespace App\CPU;

use Razorpay\Api\Api;

class Payment
{

    // generation order
    public static function razorpay_order($amount)
    {
        try {
            $razorpay_key_id = env('RAZORPAY_KEY_ID', 'rzp_test_T4AraVExlu3Idf');
            $razorpay_key_secret = env('RAZORPAY_KEY_SECRET', 'IbL6yVAfWAx4F1l7S1gZCVuT');

            $api = new Api($razorpay_key_id, $razorpay_key_secret);
            
            $orderData = [
                'receipt'         => 'order_rcptid_' . rand(1000, 9999),
                'amount'          => $amount * 100, // Amount in paise
                'currency'        => 'INR',
                'payment_capture' => 1 // Auto capture
            ];

            $razorpayOrder = $api->order->create($orderData);

            return $razorpayOrder;
        } catch (\Exception $e) {
            \Log::error('Razorpay Order Creation Error: ' . $e->getMessage());
            return false;
        }
    }

    // after complete payment of booking verifying signature
    public static function verify_signature($attributes)
    {
        try {
            $razorpay_key_id = env('RAZORPAY_KEY_ID', 'rzp_test_T4AraVExlu3Idf');
            $razorpay_key_secret = env('RAZORPAY_KEY_SECRET', 'IbL6yVAfWAx4F1l7S1gZCVuT');
            
            $api = new Api($razorpay_key_id, $razorpay_key_secret);
            
            $generated_signature = hash_hmac(
                'sha256',
                $attributes['razorpay_order_id'] . '|' . $attributes['razorpay_payment_id'],
                $razorpay_key_secret
            );
            
            if (hash_equals($generated_signature, $attributes['razorpay_signature'])) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            \Log::error('Razorpay Signature Verification Error: ' . $e->getMessage());
            return false;
        }
    }
}