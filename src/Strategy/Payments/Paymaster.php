<?php

namespace RecurrentPayments\Strategy\Payments;
use PHPUnit\Framework\Exception;

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
	 * @var string
	 */
	protected $authUrl = "https://paymaster.ru/direct/security/auth";

	/**
	 * @var string
	 */
	protected $secretKey = "3d01d6683a2e9ac6799d97d1b9dafb557f6ea9d19ce3e89908d0a33879eb853d";

	/**
	 * @var string
	 */
	protected $merchantId = "7b596b14-b05a-4e35-8b61-cabbcc5d69cd";

	/**
	 * @param array $params
	 *
	 * @return mixed
	 *
	 * @throws \Exception
	 */
	public function authUserInPaymentSystem(array $params)
	{
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
			"client_id" => $this->merchantId,
			"redirect_uri" => $redirectUri,
			"scope" => $scope
		]);

		$sign = hash("sha256", base64_encode($header).".".base64_encode($body).";".$key, true);

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