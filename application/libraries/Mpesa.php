<?php 

class Mpesa{

    function __construct() {

        // initialization constructor.  Called when class is created.
        $CI=& get_instance();
        $CI->load->database();
        $this->db = $CI->db;
        $type = $CI->db->get_where('business_settings',array('type'=>'mpesa_account_type'))->row()->value;
        if($type == 'sandbox') {
           $this->pesapal_url = 'https://sandbox.safaricom.co.ke';
        } else if($type == 'original') {
           $this->pesapal_url = 'https://api.safaricom.co.ke';
        }
        
        $this->callback_url= base_url().'mpesa-callback-response';
        $this->consumer_key = $CI->db->get_where('business_settings',array('type'=>'mpesa_consumer_key'))->row()->value;
        $this->consumer_secret = $CI->db->get_where('business_settings',array('type'=>'mpesa_consumer_secret_key'))->row()->value;
        $this->business_short_code ='174379';
        $Passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
        $this->timestamp = date('YmdHis'); 
        $this->password = base64_encode($this->business_short_code.$Passkey.$this->timestamp);

  
     }

     function getAuthToken()
     {
        try{
            $headers = ['Content-Type:application/json; charset=utf8'];
            $peramUrl = '/oauth/v1/generate?grant_type=client_credentials';
            $access_token_url = $this->pesapal_url.$peramUrl;
            $curl = curl_init($access_token_url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl, CURLOPT_HEADER, FALSE);
            curl_setopt($curl, CURLOPT_USERPWD, $this->consumer_key.':'.$this->consumer_secret);
            $result = curl_exec($curl);
            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $result = json_decode($result);

            $access_token = $result->access_token;  
            curl_close($curl);
            ob_end_clean();
            return array('status'=>true, 'token'=>$access_token);
        }catch(Exception $e){
            return array('status'=>false, 'msg'=>'access token not found');
        }
        
        
     }
     function initiatePayment($token, $userInfos)
     {
        try{
            $initiate_url = $this->pesapal_url.'/mpesa/stkpush/v1/processrequest';
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $initiate_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "BusinessShortCode":"'.$this->business_short_code.'",
                "Password":"'.$this->password.'",
                "Timestamp":"'.$this->timestamp.'",
                "TransactionType":"CustomerPayBillOnline",
                "Amount":"'.$userInfos['amount'].'",
                "PartyA":"'.$userInfos['phone'].'",
                "PartyB":"'.$this->business_short_code.'",
                "PhoneNumber":"'.$userInfos['phone'].'",
                "CallBackURL":"'.$this->callback_url.'",
                "AccountReference":"CompanyXLsTD",
                "TransactionDesc":"Paymesnt of X"
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$token,
                'Content-Type: application/json',
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $dataResponse = json_decode($response);
            if(isset($dataResponse->CheckoutRequestID) && $dataResponse->CheckoutRequestID){

                $this->db->insert('package_payment', array(
                    'plan_id'=>$userInfos['plan_id'],
                    'member_id'=>$userInfos['member_id'],
                    'amount'=>$userInfos['amount'],
                    'payment_type'=>'mpesa',
                    'payment_status'=>'due',
                    'merchant_request_id'=>$dataResponse->MerchantRequestID,
                    'checkout_request_id'=>$dataResponse->CheckoutRequestID
                ));
                $paymentTempId= $this->db->insert_id();
                $dataResponse->paymentTempId = $paymentTempId;
                return array('status'=>true, 'data'=>$dataResponse);
            }else{
                return array('status'=>false, 'msg'=>$dataResponse);
            }
        
        }catch(Exception $e){
            return array('status'=>false, 'msg'=>'Something went wrong');
            
        }
        
        
        
     }
     
     function requestToPesapal($peramUrl, $method, $postData, $token=null)
     {
        try{
            $ch = curl_init();
            $customUrl = $this->pesapal_url.$peramUrl;
            curl_setopt($ch, CURLOPT_URL, $customUrl);
            if($method == 'POST'){
                curl_setopt($ch, CURLOPT_POST, 1);
            }
            $authToken =null;
            if($token){
                $authToken ='Authorization: Bearer '.$token;
            }
            
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Accept: application/json',
                $authToken
              ));
            if($method == 'POST'){
                 curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
            }
            // curl_setopt($ch, CURLOPT_POSTFIELDS,"postvar1=value1&postvar2=value2&postvar3=value3");

            // Receive server response ...
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);
            curl_close ($ch);
            return $server_output;
        }catch(Exception  $e){
            return $e;
        }
     }
     function gen_uuid() {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
    
            // 16 bits for "time_mid"
            mt_rand( 0, 0xffff ),
    
            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand( 0, 0x0fff ) | 0x4000,
    
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand( 0, 0x3fff ) | 0x8000,
    
            // 48 bits for "node"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }
}

?>