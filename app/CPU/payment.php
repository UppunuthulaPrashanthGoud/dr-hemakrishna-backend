<?php

namespace App\CPU;

use Razorpay\Api\Api;
use Log;

class Payment
{

    // generation order
    public static function razorpay_order($amount)
    {
        try {
            Log::info('Creating Razorpay order', [
                'amount' => $amount,
                'razorpay_key_id_configured' => !empty(env('RAZORPAY_KEY_ID')),
                'razorpay_key_secret_configured' => !empty(env('RAZORPAY_KEY_SECRET'))
            ]);
            
            $razorpay_key_id = env('RAZORPAY_KEY_ID', 'rzp_test_T4AraVExlu3Idf');
            $razorpay_key_secret = env('RAZORPAY_KEY_SECRET', 'IbL6yVAfWAx4F1l7S1gZCVuT');

            Log::info('Razorpay credentials', [
                'key_id' => $razorpay_key_id,
                'key_secret_length' => strlen($razorpay_key_secret)
            ]);

            $api = new Api($razorpay_key_id, $razorpay_key_secret);
            
            $orderData = [
                'receipt'         => 'order_rcptid_' . rand(1000, 9999),
                'amount'          => $amount * 100, // Amount in paise
                'currency'        => 'INR',
                'payment_capture' => 1 // Auto capture
            ];

            Log::info('Sending order creation request to Razorpay', [
                'order_data' => $orderData
            ]);
            
            $razorpayOrder = $api->order->create($orderData);
            
            Log::info('Razorpay order created successfully', [
                'order_response' => $razorpayOrder->toArray()
            ]);

            return $razorpayOrder;
        } catch (\Exception $e) {
            Log::error('Razorpay Order Creation Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'amount' => $amount,
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return false;
        }
    }

    // after complete payment of booking verifying signature
    public static function verify_signature($attributes)
    {
        try {
            Log::info('Verifying Razorpay signature', [
                'attributes' => [
                    'razorpay_order_id' => $attributes['razorpay_order_id'] ?? null,
                    'razorpay_payment_id' => $attributes['razorpay_payment_id'] ?? null,
                    'signature_provided' => !empty($attributes['razorpay_signature'])
                ]
            ]);
            
            // Validate required attributes
            if (empty($attributes['razorpay_order_id']) || 
                empty($attributes['razorpay_payment_id']) || 
                empty($attributes['razorpay_signature'])) {
                Log::warning('Missing required attributes for signature verification', [
                    'provided_attributes' => array_keys($attributes)
                ]);
                return false;
            }
            
            $razorpay_key_id = env('RAZORPAY_KEY_ID', 'rzp_test_T4AraVExlu3Idf');
            $razorpay_key_secret = env('RAZORPAY_KEY_SECRET', 'IbL6yVAfWAx4F1l7S1gZCVuT');
            
            Log::info('Using Razorpay credentials for verification', [
                'key_id' => $razorpay_key_id
            ]);
            
            $api = new Api($razorpay_key_id, $razorpay_key_secret);
            
            $generated_signature = hash_hmac(
                'sha256',
                $attributes['razorpay_order_id'] . '|' . $attributes['razorpay_payment_id'],
                $razorpay_key_secret
            );
            
            $is_valid = hash_equals($generated_signature, $attributes['razorpay_signature']);
            
            Log::info('Razorpay signature verification result', [
                'is_valid' => $is_valid,
                'generated_signature_sample' => substr($generated_signature, 0, 10) . '...',
                'received_signature_sample' => substr($attributes['razorpay_signature'], 0, 10) . '...'
            ]);
            
            if ($is_valid) {
                Log::info('Razorpay signature verified successfully');
                return true;
            } else {
                Log::warning('Razorpay signature verification failed', [
                    'order_id' => $attributes['razorpay_order_id'],
                    'payment_id' => $attributes['razorpay_payment_id']
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Razorpay Signature Verification Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'attributes' => array_keys($attributes),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return false;
        }
    }
}