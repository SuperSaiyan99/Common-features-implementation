<?php


        #SMS message name
        $send_data['sender_id'] = "PhilSMS";

        #number nila
        $send_data['recipient'] = "+639095254373";

        #message content here
        $send_data['message'] = "Hi, Regards kong joana hehe.";

        #token sa philsms [API Token] naa sa developers tab
        $token = "1245|jxRfR6wSVjqAzXDWslrnr3kx1kDU3o7a7y0n9wUZ ";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://app.philsms.com/api/v3/sms/send');
            $headers = array();
            $headers[] =  "Content-Type: application/json";
            $headers[] = "Authorization: Bearer ". $token;
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($send_data));
            $get_sms_status = curl_exec($ch);
            curl_close($ch);

            var_dump($get_sms_status);


?>
                
