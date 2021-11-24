<?php
namespace App\PaymentProviders\PSP;

class Payment
{
    private $url = "https://fcp.shaparak.ir/nvcservice/Api/v2/";
    protected $apiKey;
    protected $username;
    protected $password;
    public $paymentUrl;
    public $errorCode;
    public $errorMessage;

    /**
     * Payment constructor.
     */
    public function __construct()
    {
        $this->apiKey = site_config('payment_api_key') ? site_config('payment_api_key') : 'test';
        $this->username = site_config('payment_username') ? site_config('payment_username') : 'test';
        $this->password = site_config('payment_password') ? site_config('payment_password') : 'test';
    }

    /**
     * @param $amount
     * @param null $mobile
     * @param null $factorNumber
     * @param null $description
     * @return mixed
     */
    public function send($amount, $factorNumber, $mobile = null, $description = null)
    {
		$Description 	= "Payment ID {$factorNumber}";
		$Email 			= "";
		$Mobile 		= "";
		$CallbackURL 	= route('pg-callback');

		$postField = [
		    "CARDACCEPTORCODE"=>$this->apiKey,
		    "USERNAME"=>$this->username,
		    "USERPASSWORD"=>$this->password,
		    "PAYMENTID"=>$factorNumber,
            "AMOUNT"=>$amount,
            "CALLBACKURL"=>($CallbackURL),
        ];

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $this->url.'PayRequest');
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type' => 'application/json'));
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postField));
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Accept: application/json"));

		$curl_exec = curl_exec($curl);

		curl_close($curl);

		$result = json_decode($curl_exec, true);

		if (isset($result['ActionCode']) && $result['ActionCode'] == 0)
		{
			$result['Status'] 	= 1;
			$result['status'] 	= 1;
			$result['token'] 	= "";
			$this->paymentUrl 	= $result['RedirectUrl'];
		} else {
			if (isset($result['ActionCode'])) {
				$this->errorCode = $result['Status'];
			}

			if (isset($result['Status'])) {
				$this->errorMessage = $result['Status'];
			}
		}

        return $result;
    }

    /**
     * @param $token
     * @return mixed
     */
    public function verify($RRN, $PayID)
    {

        $postField = [
            "CARDACCEPTORCODE"=>$this->apiKey,
            "USERNAME"=>$this->username,
            "USERPASSWORD"=>$this->password,
            "PAYMENTID"=>$PayID,
            "RRN"=>$RRN,
        ];

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $this->url."Confirm");
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postField));
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Accept: application/json"));
		$curl_exec = curl_exec($curl);
		curl_close($curl);

		$result = json_decode($curl_exec);

		return $result;
    }
}
