<?php
/*P
 * Copyright (c) 2021 DPO Group
 *
 * Author: App Inlet (Pty) Ltd
 *
 * Released under the MIT License
 */

class Dpo
{
    protected static $test_api_url = 'https://secure1.sandbox.directpay.online/API/v6/';
    protected static $test_pay_url = 'https://secure1.sandbox.directpay.online/payv2.php';
    protected static $live_api_url = 'https://secure.3gdirectpay.com/API/v6/';
    protected static $live_pay_url = 'https://secure.3gdirectpay.com/payv2.php';
    protected $createResponses = [
        '000' => 'Transaction created',
        '801' => 'Request missing company token',
        '802' => 'Company token does not exist',
        '803' => 'No request or error in Request type name',
        '804' => 'Error in XML',
        '902' => 'Request missing transaction level mandatory fields - name of field',
        '904' => 'Currency not supported',
        '905' => 'The transaction amount has exceeded your allowed transaction limit, please contact: support@directpay.online',
        '906' => 'You exceeded your monthly transactions limit, please contact: support@directpay.online',
        '922' => 'Provider does not exist',
        '923' => 'Allocated money exceeds payment amount',
        '930' => 'Block payment code incorrect',
        '940' => 'CompanyREF already exists and paid',
        '950' => 'Request missing mandatory fields - name of field',
        '960' => 'Tag has been sent multiple times',
    ];
    protected $createResponseCodes;
    protected $verifyResponses = [
        '000' => 'Transaction Paid',
        '001' => 'Authorized',
        '002' => 'Transaction overpaid/underpaid',
        '801' => 'Request missing company token',
        '802' => 'Company token does not exist',
        '803' => 'No request or error in Request type name',
        '804' => 'Error in XML',
        '900' => 'Transaction not paid yet',
        '901' => 'Transaction declined',
        '902' => 'Data mismatch in one of the fields - field (explanation)',
        '903' => 'The transaction passed the Payment Time Limit',
        '904' => 'Transaction cancelled',
        '950' => 'Request missing transaction level mandatory fields – field (explanation)',
    ];
    protected $verifyResponseCodes;
    protected $company_token;
    protected $service_type;
    protected $api_url;
    protected $pay_url;

    public function __construct()
    {
        $this->createResponseCodes = array_flip($this->createResponses);
        $this->verifyResponseCodes = array_flip($this->verifyResponses);

        $CI=& get_instance();
        $CI->load->database();
        $this->db = $CI->db;
        $test_mode = $CI->db->get_where('business_settings',array('type'=>'dpo_account_type'))->row()->value;

        if ($test_mode=='sandbox') {
            $this->api_url = self::$test_api_url;
            $this->pay_url = self::$test_pay_url;
        } else {
            $this->api_url = self::$live_api_url;
            $this->pay_url = self::$live_pay_url;
        }
        $dpoCompanyToken = $CI->db->get_where('business_settings',array('type'=>'dpo_company_token'))->row()->value;
        $dpoServiceType = $CI->db->get_where('business_settings',array('type'=>'dpo_service_type'))->row()->value;
        

        $this->company_token = $dpoCompanyToken;
        $this->service_type  = $dpoServiceType;
        $this->redirectURL = base_url().'dpo-success';
        $this->backURL = base_url().'dpo-failed';
    }

    /**
     * Create a DPO token for payment processing
     *
     * @param $data
     *
     * @return array
     */
    public function createToken($data)
    {
        $data['companyToken'] = $this->company_token;
        $data['serviceType'] = $this->service_type;
        $data['redirectURL'] = $this->redirectURL;
        $data['backURL'] = $this->backURL;

        $service = '';


        $serviceDate = date('Y/m/d H:i');
        $serviceDesc = 'test';

        // Create each product service xml
        $service .= <<<POSTXML
            <Service>
                <ServiceType>{$data['serviceType']}</ServiceType>
                <ServiceDescription>$serviceDesc</ServiceDescription>
                <ServiceDate>$serviceDate</ServiceDate>
            </Service>
POSTXML;

        $customerPhone = preg_replace('/[^0-9]/', '', '');

        $postXml = <<<POSTXML
        <?xml version="1.0" encoding="utf-8"?> <API3G> <CompanyToken>{$data['companyToken']}</CompanyToken> <Request>createToken</Request> <Transaction> <PaymentAmount>{$data['paymentAmount']}</PaymentAmount> <PaymentCurrency>{$data['paymentCurrency']}</PaymentCurrency> <CompanyRef>{$data['companyRef']}</CompanyRef> <customerDialCode>{$data['customerDialCode']}</customerDialCode> <customerZip>{$data['customerZip']}</customerZip> <customerCountry>{$data['customerCountry']}</customerCountry> <customerFirstName></customerFirstName> <customerLastName></customerLastName> <customerAddress>{$data['customerAddress']}</customerAddress> <customerCity>{$data['customerCity']}</customerCity> <customerPhone>{$customerPhone}</customerPhone> <RedirectURL>{$data['redirectURL']}</RedirectURL> <BackURL>{$data['backURL']}</BackURL> <customerEmail>{$data['customerEmail']}</customerEmail> </Transaction> <Services>$service</Services> </API3G>
POSTXML;

        $created = false;
        $cnt     = 0;

        while ( ! $created && $cnt < 10) {
            try {
                $curl = curl_init();
                curl_setopt_array(
                    $curl,
                    array(
                        CURLOPT_URL            => $this->api_url,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING       => "",
                        CURLOPT_MAXREDIRS      => 10,
                        CURLOPT_TIMEOUT        => 30,
                        CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST  => "POST",
                        CURLOPT_POSTFIELDS     => $postXml,
                        CURLOPT_HTTPHEADER     => array(
                            "cache-control: no-cache",
                        ),
                    )
                );
                $response = curl_exec($curl);
                curl_close($curl);
            } catch (Exception $exception) {
                return "Curl error in createToken: " . $exception->getMessage();
                $cnt++;
            }

            $xml = new SimpleXMLElement($response);

            // Check if token creation response has been received
            if ( ! in_array($xml->xpath('Result')[0]->__toString(), array_keys($this->createResponses))) {
                return "Error in getting Transaction Token: Invalid response: " . $response;
                $cnt++;
            } elseif ($xml->xpath('Result')[0]->__toString() === '000') {
                $transToken        = $xml->xpath('TransToken')[0]->__toString();
                $result            = $xml->xpath('Result')[0]->__toString();
                $resultExplanation = $xml->xpath('ResultExplanation')[0]->__toString();
                $transRef          = $xml->xpath('TransRef')[0]->__toString();

                $created = true;

                return [
                    'success'           => true,
                    'result'            => $result,
                    'transToken'        => $transToken,
                    'resultExplanation' => $resultExplanation,
                    'transRef'          => $transRef,
                ];
            } else {
                $created = true;

                return [
                    'success'   => false,
                    'errorcode' => $xml->xpath('Result')[0]->__toString(),
                    'error'     => $xml->xpath('ResultExplanation')[0]->__toString(),
                ];
            }
        }
    }

    /**
     * Verify the DPO token created in first step of transaction
     *
     * @param $data
     *
     * @return bool|string
     */
    public function verifyToken($data)
    {
        $companyToken =$this->company_token;
        $transToken   = $data['transToken'];

        $verified = false;
        $cnt      = 0;

        while ( ! $verified && $cnt < 10) {
            try {
                $curl = curl_init();
                curl_setopt_array(
                    $curl,
                    array(
                        CURLOPT_URL            => $this->api_url,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING       => "",
                        CURLOPT_MAXREDIRS      => 10,
                        CURLOPT_TIMEOUT        => 30,
                        CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST  => "POST",
                        CURLOPT_POSTFIELDS     => "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n<API3G>\r\n  <CompanyToken>" . $companyToken . "</CompanyToken>\r\n  <Request>verifyToken</Request>\r\n  <TransactionToken>" . $transToken . "</TransactionToken>\r\n</API3G>",
                        CURLOPT_HTTPHEADER     => array(
                            "cache-control: no-cache",
                        ),
                    )
                );

                $response = curl_exec($curl);
                $err      = curl_error($curl);

                curl_close($curl);

                if (strlen($err) > 0) {
                    $cnt++;
                } else {
                    $verified = true;
                    if ($response !== false && substr($response, 0, 5) === '<?xml') {
                        // Convert the XML result into array
                        return new SimpleXMLElement($response);
                    }
            
                   
                }
            } catch (Exception $e) {
                print_r($e);
                $cnt++;
            }
        }
    }

    /**
     * Return description for given code
     *
     * @param $code
     *
     * @return
     */
    public function getCreateResponse($code)
    {
        return $this->createResponses[$code];
    }

    public function getVerifyResponse($code)
    {
        return $this->verifyResponses[$code];
    }

    /**
     * Return code for given description
     *
     * @param $description
     *
     * @return mixed
     */
    public function getCreateResponseCode($description)
    {
        return $this->createResponseCodes[$description];
    }

    public function getVerifyResponseCode($description)
    {
        return $this->verifyResponseCodes[$description];
    }

    /**
     * @return false|mixed|string|void
     */
    public function get_company_token()
    {
        return $this->company_token;
    }

    /**
     * @return false|mixed|string|void
     */
    public function get_service_type()
    {
        return $this->service_type;
    }

    /**
     * @return string
     */
    public function get_api_url(): string
    {
        return $this->api_url;
    }

    /**
     * @return string
     */
    public function get_pay_url(): string
    {
        return $this->pay_url;
    }

    /**
     * @return string
     */
    public function getOrderItems()
    {
        if (empty(get_option("dpo_standalone_item_details"))) {
            return "Test Item";
        }

        return get_option("dpo_standalone_item_details");
    }

    /**
     * @return string
     */
    public function dpo_standalone_customer_dial_code()
    {
        if (empty(get_option("dpo_standalone_customer_dial_code"))) {
            return 11;
        }

        return get_option("dpo_standalone_customer_dial_code");
    }

    /**
     * @return string
     */
    public function dpo_standalone_customer_zip()
    {
        if (empty(get_option("dpo_standalone_customer_zip"))) {
            return "01234";
        }

        return get_option("dpo_standalone_customer_zip");
    }

    /**
     * @return string
     */
    public function dpo_standalone_customer_address()
    {
        if (empty(get_option("dpo_standalone_customer_address"))) {
            return "My Address";
        }

        return get_option("dpo_standalone_customer_address");
    }

    /**
     * @return string
     */
    public function dpo_standalone_customer_city()
    {
        if (empty(get_option("dpo_standalone_customer_city"))) {
            return "My City";
        }

        return get_option("dpo_standalone_customer_city");
    }

    /**
     * @return string
     */
    public function dpo_standalone_customer_phone()
    {
        if (empty(get_option("dpo_standalone_customer_phone"))) {
            return "5556677";
        }

        return get_option("dpo_standalone_customer_phone");
    }
}


