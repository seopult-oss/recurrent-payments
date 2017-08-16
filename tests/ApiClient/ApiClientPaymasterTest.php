<?php
namespace Tests\ApiClient;

class ApiClientPaymasterTest extends \Codeception\Test\Unit
{
    /**
     * @var \Tests\
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testGetTemporaryToken()
    {
    	$params = [
            'action' => 'getTemporaryToken',
            'redirectUri' => 'redirectUri',
            'secretKey' => 'secretKey',
            'merchantId' => 'merchantId',
            'scope' => 'BankCard',
			'spendLimit' => 3000
        ];

    	$apiClient = \RecurrentPayments\ApiClient\Factory\ApiClientFactory::createApiClient('Paymaster');
		$payload = $apiClient->authUserInPaymentSystem($params);

		$transport = new \RecurrentPayments\Strategy\Transport\Curl();

		$response = $transport->request(
			'https://paymaster.ru/direct/security/auth',
			'POST',
			['request' => $payload],
			['Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8']
		);

		$this->assertEquals(0, $response['error']);
		$this->assertTrue(strpos($response['headers'], "HTTP/1.1 200 OK") !== false);
		$this->assertTrue(strpos($response['response'], "Unknown merchant") !== false);
    }

    public function testGetPermanentToken()
    {
        $params = [
            'action' => 'getPermanentToken',
            'redirectUri' => 'redirectUri',
            'secretKey' => 'secretKey',
            'merchantId' => 'merchantId',
            'scope' => 'BankCard',
			'temporaryToken' => 'Unknown temporary token'
        ];

        $apiClient = \RecurrentPayments\ApiClient\Factory\ApiClientFactory::createApiClient('Paymaster');
        $response = $apiClient->authUserInPaymentSystem($params);

		$this->assertEquals(0, $response['error']);
		$this->assertTrue(strpos($response['headers'], "HTTP/1.1 100 Continue") !== false);
		$this->assertTrue(strpos($response['response'], "verification_failure") !== false);
    }

	public function testInitPayment()
	{
		$params = [
			'action' => 'initPayment',
			'secretKey' => 'secretKey',
			'merchantId' => 'merchantId',
			'accessToken' => 'Unknown access token',
			'merchantTransactionId' => 1,
			"amount" => 1,
			"currency" => 'RUB'
		];

		$apiClient = \RecurrentPayments\ApiClient\Factory\ApiClientFactory::createApiClient('Paymaster');
		$response = $apiClient->InitPayment($params);

		$this->assertEquals(0, $response['error']);

		$this->assertTrue(strpos($response['headers'], "HTTP/1.1 100 Continue") !== false);
		$this->assertTrue(strpos($response['response'], "verification_failure") !== false);

	}

	public function testConfirmPayment()
	{
		$params = [
			'action' => 'confirmPayment',
			'secretKey' => 'secretKey',
			'merchantId' => 'merchantId',
			'accessToken' => 'Unknown access token',
			'merchantTransactionId' => 1,
			'processorTransactionId' => 1
		];

		$apiClient = \RecurrentPayments\ApiClient\Factory\ApiClientFactory::createApiClient('Paymaster');
		$response = $apiClient->InitPayment($params);

		$this->assertEquals(0, $response['error']);
		$this->assertTrue(strpos($response['headers'], "HTTP/1.1 100 Continue") !== false);
		$this->assertTrue(strpos($response['response'], "verification_failure") !== false);
	}

	public function testRevokePaymentToken()
	{
		$params = [
			'secretKey' => 'secretKey',
			'merchantId' => 'merchantId',
			'accessToken' => 'Access temporary token'
		];

		$apiClient = \RecurrentPayments\ApiClient\Factory\ApiClientFactory::createApiClient('Paymaster');
		$response = $apiClient->logoutUserInPaymentSystem($params);

		$this->assertEquals(0, $response['error']);
		$this->assertTrue(strpos($response['headers'], "HTTP/1.1 100 Continue") !== false);
		$this->assertTrue(strpos($response['response'], "verification_failure") !== false);
	}
}