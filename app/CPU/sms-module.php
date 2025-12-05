<?php

namespace app\CPU;
use App\Models\Setting;

class SMS_module
{

    public static function msg_91($phone, $otpval)
    {
        $settings=Setting::get();
        $key = $settings[3]->key_value;
        $template_id = $settings[4]->key_value;
        
        $mobile = '91'.$phone;

        $curl = curl_init();
        curl_setopt_array($curl, [
          CURLOPT_URL => "https://api.msg91.com/api/v5/otp?template_id=$template_id&mobile=$mobile&authkey=$key&otp=$otpval&otp_expiry=5",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_POSTFIELDS => "{\"Value1\":\"Param1\",\"Value2\":\"Param2\",\"Value3\":\"Param3\"}",
          CURLOPT_HTTPHEADER => [
            "Content-Type: application/json"
          ],
        ]);
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if($err){
            $data=[false, $err];
            return $data;
        }else{
            $data=[true, $response];
            return $data;
        }
        


        // $curl = curl_init();
        // $data = array(
        //     'flow_id' => '62d10a5cf581ac180f152889',
        //     'sender' => 'MYDRVR',
        //     'mobiles' => '91' . $phone,
        //     'OTP' => $otpval,
        // );
        // $payload = json_encode($data);
        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => "https://api.msg91.com/api/v5/flow/",
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 30,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "POST",
        //     CURLOPT_POSTFIELDS => $payload,
        //     CURLOPT_HTTPHEADER => array(
        //         "authkey: 377725AyZHm7xv62961176P1",
        //         "content-type: application/JSON",
        //     ),
        // ));
        // $response = curl_exec($curl);
        // $err = curl_error($curl);
        // curl_close($curl);
        // if($err){
        //     $data=[false, $err];
        //     return $data;
        // }else{
        //     $data=[true, $response];
        //     return $data;
        // }
    }

}
