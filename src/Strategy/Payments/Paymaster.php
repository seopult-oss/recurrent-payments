<?php

namespace RecurrentPayments\Strategy\Payments;

/**
 * Class Paymaster
 */
class Paymaster implements StrategyInterface
{
	/**
	 * @var \RecurrentPayments\Strategy\Transport\TransportInterface
	 */
	protected $transport;

	/**
	 * Paymaster constructor.
	 * @param \RecurrentPayments\Strategy\Transport\TransportInterface $transport
	 */
	public function __construct($transport)
	{
		$this->transport = $transport;
	}

	/**
	 * @param array $params
	 *
	 * @return mixed
	 *
	 * @throws \Exception
	 */
	public function authUserInPaymentSystem(array $params)
	{
		if (empty($params['Paymaster']['merchantId'])) {
			throw new \Exception("Merchant id does not exist");
		}
		$merchantId = $params['Paymaster']['merchantId'];

		if (empty($params['Paymaster']['secretKey'])) {
			throw new \Exception("Secret key does not exist");
		}
		$secretKey = $params['Paymaster']['secretKey'];

		if (empty($params['Paymaster']['redirectUri'])) {
			throw new \Exception("Redirect uri does not exist");
		}
		$redirectUri = $params['Paymaster']['redirectUri'];

		if (empty($params['Paymaster']['scope'])) {
			throw new \Exception("Scope does not exist");
		}
		$scope = $params['Paymaster']['scope'];

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
	}
	/**
	 * @param array $params
	 * @return mixed;
	 */
	public function initPayment(array $params)
	{
		return 0;
	}

	public function approvePayment()
	{
		return 0;
	}

	public function getPermanentToken()
	{

	}

	public function revokePermanentToken()
	{

	}

	/**
	 * @param \RecurrentPayments\Strategy\Transport\TransportInterface $transport
	 * @return mixed
	 */
	public function setTransport($transport)
	{
		$this->transport = $transport;
		return $this;
	}

	/**
	 * @return \RecurrentPayments\Strategy\Transport\TransportInterface
	 */
	public function getTransport()
	{
		return $this->transport;
	}
}