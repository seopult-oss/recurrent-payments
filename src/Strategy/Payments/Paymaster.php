<?php

namespace RecurrentPayments\Strategy\Payments;

/**
 * Class Paymaster
 */
class Paymaster implements StrategyInterface
{
	/**
	 * Paymaster auth uri
	 *
	 * @var string
	 */
	protected $authUri = "https://paymaster.ru/direct/security/auth";

	/**
	 * Paymaster permanent get token uri
	 *
	 * @var string
	 */
	protected $getTokenUri = "https://paymaster.ru/direct/security/token";

	/**
	 * Paymaster revoke permanent token uri
	 *
	 * @var string
	 */
	protected $revokeTokenUri = "https://paymaster.ru/direct/Security/Revoke";

	/**
	 * Paymaster init payment uri
	 *
	 * @var string
	 */
	protected $initPaymentUri = "https://paymaster.ru/direct/payment/init";

	/**
	 * Paymaster complete payment uri
	 *
	 * @var string
	 */
	protected $approvePaymentUri = "https://paymaster.ru/direct/payment/complete";

	/**
	 * Transport
	 *
	 * @var \RecurrentPayments\Strategy\Transport\TransportInterface
	 */
	protected $transport;

	/**
	 * Paymaster constructor.
	 *
	 * @param \RecurrentPayments\Strategy\Transport\TransportInterface $transport Transport
	 */
	public function __construct(\RecurrentPayments\Strategy\Transport\TransportInterface $transport)
	{
		$this->transport = $transport;
	}

	/**
	 * Auth user in payment system
	 *
	 * @param array $params Array of params
	 *
	 * @return mixed
	 *
	 * @throws \Exception
	 */
	public function authUserInPaymentSystem(array $params)
	{
		if (empty($params['action'])) {
			throw new \Exception("action does not exist");
		}
		switch ($params['action']) {
			case 'getTemporaryToken':
				if (empty($params['merchantId'])) {
					throw new \Exception("Merchant id does not exist");
				}
				$merchantId = $params['merchantId'];

				if (empty($params['secretKey'])) {
					throw new \Exception("Secret key does not exist");
				}
				$secretKey = $params['secretKey'];

				if (empty($params['redirectUri'])) {
					throw new \Exception("Redirect uri does not exist");
				}
				$redirectUri = $params['redirectUri'];

				if (empty($params['scope'])) {
					throw new \Exception("Scope does not exist");
				}
				$scope = $params['scope'];

				$header = json_encode([
					"alg" => 'HS256',
					"iat" => time()
				]);
				$body = json_encode([
					"response_type" => 'code',
					"client_id" => $merchantId,
					"redirect_uri" => $redirectUri,
					"scope" => $scope
				]);

				$sign = hash("sha256", base64_encode($header).".".base64_encode($body).";".$secretKey, true);

				$payload = base64_encode($header).".".base64_encode($body).".".base64_encode($sign);

				return $payload;
				break;
			case 'getPermanentToken':
				if (empty($params['merchantId'])) {
					throw new \Exception("Merchant id does not exist");
				}
				$merchantId = $params['merchantId'];

				if (empty($params['temporaryToken'])) {
					throw new \Exception("Temporary token does not exist");
				}
				$temporaryToken = $params['temporaryToken'];

				if (empty($params['secretKey'])) {
					throw new \Exception("Secret key does not exist");
				}
				$secretKey = $params['secretKey'];

				if (empty($params['redirectUri'])) {
					throw new \Exception("Redirect uri does not exist");
				}
				$redirectUri = $params['redirectUri'];

				$header = json_encode([
					"alg" => 'HS256',
					"iat" => time()
				]);
				$body = json_encode([
					"grant_type" => 'authorization_code',
					"code" => $temporaryToken,
					"client_id" => $merchantId,
					"redirect_uri" => $redirectUri,
				]);

				$sign = hash("sha256", base64_encode($header).".".base64_encode($body).";".$secretKey, true);

				$payload = base64_encode($header).".".base64_encode($body).".".base64_encode($sign);

				$result = $this->transport->request(
					$this->getTokenUri,
					'POST',
					['request' => $payload],
					['Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8']
				);
				return $result;
				break;
		}
		return false;
	}

	/**
	 * Init payment
	 *
	 * @param array $params Array of params
	 *
	 * @return mixed
	 *
	 * @throws \Exception
	 */
	public function initPayment(array $params)
	{
		if (empty($params['action'])) {
			throw new \Exception("action id does not exist");
		}
		switch ($params['action']) {
			case 'initPayment':
				if (empty($params['secretKey'])) {
					throw new \Exception("Secret key does not exist");
				}
				$secretKey = $params['secretKey'];

				if (empty($params['merchantId'])) {
					throw new \Exception("Merchant id does not exist");
				}
				$merchantId = $params['merchantId'];

				if (empty($params['accessToken'])) {
					throw new \Exception("Access token token does not exist");
				}
				$accessToken = $params['accessToken'];

				if (empty($params['merchantTransactionId'])) {
					throw new \Exception("Merchant transaction id does not exist");
				}
				$merchantTransactionId = $params['merchantTransactionId'];

				if (empty($params['amount'])) {
					throw new \Exception("Amount does not exist");
				}
				$amount = $params['amount'];

				$header = json_encode([
					"alg" => 'HS256',
					"iat" => time()
				]);
				$body = json_encode([
					"access_token" => $accessToken,
					"merchant_id" => $merchantId,
					"merchant_transaction_id" => $merchantTransactionId,
					"amount" => $amount,
					"currency" => 'RUB'
				]);

				$sign = hash("sha256", base64_encode($header).".".base64_encode($body).";".$secretKey, true);

				$payload = base64_encode($header).".".base64_encode($body).".".base64_encode($sign);

				$result = $this->transport->request(
					$this->initPaymentUri,
					'POST',
					['request' => $payload],
					['Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8']
				);
				return $result;
				break;
			case 'completePayment':
				if (empty($params['secretKey'])) {
					throw new \Exception("Secret key does not exist");
				}
				$secretKey = $params['secretKey'];

				if (empty($params['merchantId'])) {
					throw new \Exception("Merchant id does not exist");
				}
				$merchantId = $params['merchantId'];

				if (empty($params['accessToken'])) {
					throw new \Exception("Access token token does not exist");
				}
				$accessToken = $params['accessToken'];

				if (empty($params['merchantTransactionId'])) {
					throw new \Exception("Merchant transaction id does not exist");
				}
				$merchantTransactionId = $params['merchantTransactionId'];

				if (empty($params['amount'])) {
					throw new \Exception("Amount does not exist");
				}
				$amount = $params['amount'];

				if (empty($params['processorTransactionId'])) {
					throw new \Exception("Processor transaction id does not exist");
				}
				$processorTransactionId = $params['processorTransactionId'];

				$header = json_encode([
					"alg" => 'HS256',
					"iat" => time()
				]);
				$body = json_encode([
					"access_token" => $accessToken,
					"merchant_id" => $merchantId,
					"merchant_transaction_id" => $merchantTransactionId,
					"processor_transaction_id" => $processorTransactionId,
					"amount" => $amount,
					"currency" => 'RUB'
				]);

				$sign = hash("sha256", base64_encode($header).".".base64_encode($body).";".$secretKey, true);

				$payload = base64_encode($header).".".base64_encode($body).".".base64_encode($sign);

				$result = $this->transport->request(
					$this->approvePaymentUri,
					'POST',
					['request' => $payload],
					['Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8']
				);
				return $result;
				break;
		}
		return false;
	}

	/**
	 * Logout user in payment system
	 *
	 * @param array $params Array of params
	 *
	 * @return mixed
	 *
	 * @throws \Exception
	 */
	public function logoutUserInPaymentSystem(array $params)
	{
		if (empty($params['merchantId'])) {
			throw new \Exception("Merchant id does not exist");
		}
		$merchantId = $params['merchantId'];

		if (empty($params['accessToken'])) {
			throw new \Exception("Access token token does not exist");
		}
		$accessToken = $params['accessToken'];

		if (empty($params['secretKey'])) {
			throw new \Exception("Secret key does not exist");
		}
		$secretKey = $params['secretKey'];

		$header = json_encode([
			"alg" => 'HS256',
			"iat" => time()
		]);
		$body = json_encode([
			"access_token" => $accessToken,
			"merchant_id" => $merchantId,
		]);

		$sign = hash("sha256", base64_encode($header).".".base64_encode($body).";".$secretKey, true);

		$payload = base64_encode($header).".".base64_encode($body).".".base64_encode($sign);

		$result = $this->transport->request(
			$this->revokeTokenUri,
			'POST',
			['request' => $payload],
			['Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8']
		);
		return $result;
	}
}