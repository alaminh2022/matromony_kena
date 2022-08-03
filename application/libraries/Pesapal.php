<?php 

class Pesapal{

    function __construct() {

        // initialization constructor.  Called when class is created.
        $CI=& get_instance();
        $CI->load->database();
        $type = $CI->db->get_where('business_settings',array('type'=>'pesapal_account_type'))->row()->value;
        if($type == 'sandbox') {
           $this->pesapal_url = 'https://cybqa.pesapal.com/pesapalv3';
        } else if($type == 'original') {
           $this->pesapal_url = 'https://pay.pesapal.com/v3';
        }
        $this->ipnurl = 'https://mfoundlove.com/ipn';
        $this->callback_url= 'https://mfoundlove.com/response';
        $this->consumer_key = $CI->db->get_where('business_settings',array('type'=>'pesapal_key'))->row()->value;
        $this->consumer_secret = $CI->db->get_where('business_settings',array('type'=>'pesapal_secret_key'))->row()->value;
  
  
     }

     function getAuthToken()
     {
        
        $peramUrl = '/api/Auth/RequestToken';
        $postData =array(
            "consumer_key"=>$this->consumer_key,
            "consumer_secret"=>$this->consumer_secret
        );
        $responseAuthData = $this->requestToPesapal($peramUrl, 'POST', $postData);
        $responseAuthDataParse = json_decode($responseAuthData);
        if($responseAuthDataParse->token){
            return array('status'=>true, 'token'=>$responseAuthDataParse->token);
        }else{
            return array('status'=>false, 'msg'=>$responseAuthData);
        }
     }
     function registerIPN($token)
     {
        $peramUrl = '/api/URLSetup/RegisterIPN';
        $postData =array(
            "url"=>$this->ipnurl,
            "ipn_notification_type"=>'GET'
        );
        $responseipnData = $this->requestToPesapal($peramUrl, 'POST', $postData, $token);
        $responseipnDataParse = json_decode($responseipnData);
        if($responseipnDataParse->ipn_id){
            return array('status'=>true, 'ipn_id'=>$responseipnDataParse->ipn_id);
        }else{
            return array('status'=>false, 'msg'=>$responseipnData);
        }
     }
     function SubmitOrderRequest($token, $ipnId, $registerInfo)
     {
        $peramUrl = '/api/Transactions/SubmitOrderRequest';
        
        $postData =array(
            "id"=>$this->gen_uuid(),
            "currency"=>'KES',
            "amount"=>'100.00',
            "description"=>"Preimum package purchase",
            "callback_url"=>$this->callback_url,
            "notification_id"=> $ipnId,
            "billing_address"=>array(
                "email_address"=>$registerInfo['member_email'],
                "phone_number"=>"",
                "country_code"=> "KE",
                "first_name"=> $registerInfo['member_name'],
                "middle_name"=> "",
                "last_name"=> "",
                "line_1"=> "",
                "line_2"=> "",
                "city"=> "",
                "state"=> "",
                "postal_code"=> "",
                "zip_code"=>""
            )

        );
        $responseRegisterData = $this->requestToPesapal($peramUrl, 'POST', $postData, $token);
        $responseRegisterDataParse = json_decode($responseRegisterData);
        if($responseRegisterDataParse->order_tracking_id){
            return array('status'=>true, 'data'=>$responseRegisterDataParse);
        }else{
            return array('status'=>false, 'msg'=>$responseRegisterData);
        }
        
     }
     function requestToPesapal($peramUrl, $method, $postData, $token=null)
     {
        try{
            $ch = curl_init();
            $customUrl = $this->pesapal_url.$peramUrl;
            curl_setopt($ch, CURLOPT_URL, $customUrl);
            curl_setopt($ch, CURLOPT_POST, 1);
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