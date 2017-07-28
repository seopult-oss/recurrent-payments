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
            'scope' => 'BankCard'
        ];
		$params = [
			'action' => 'getTemporaryToken',
			'redirectUri' => 'https://recurrent-payments.test.seopult.ru/billing.html',
			'scope' => 'BankCard',
			'secretKey' => '3d01d6683a2e9ac6799d97d1b9dafb557f6ea9d19ce3e89908d0a33879eb853d',
			'merchantId' => '7b596b14-b05a-4e35-8b61-cabbcc5d69cd'
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

		$params = [
			'action' => 'getPermanentToken',
			'redirectUri' => 'https://recurrent-payments.test.seopult.ru/billing.html',
			'temporaryToken' => 'bgfdhrfhrth',
			'secretKey' => '3d01d6683a2e9ac6799d97d1b9dafb557f6ea9d19ce3e89908d0a33879eb853d',
			'merchantId' => '7b596b14-b05a-4e35-8b61-cabbcc5d69cd'
		];

        $apiClient = \RecurrentPayments\ApiClient\Factory\ApiClientFactory::createApiClient('Paymaster');
        $response = $apiClient->authUserInPaymentSystem($params);

		$this->assertEquals(0, $response['error']);
    }
}