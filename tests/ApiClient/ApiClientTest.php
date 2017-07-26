<?php
namespace Tests\ApiClient;

class ApiClientTest extends \Codeception\Test\Unit
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
    public function testInit()
    {
    	$params = [
    		'Paymaster' => [
    			'action' => 'getTemporaryToken',
    			'redirectUri' => 'redirectUri',
				'secretKey' => 'secretKey',
				'merchantId' => 'merchantId',
				'scope' => 'BankCard'
			]
		];
		$curlTransport = new \RecurrentPayments\Strategy\Transport\Curl();
		$paymasterPaymentStrategy = new \RecurrentPayments\Strategy\Payments\Paymaster($curlTransport);
		$clientApi = new \RecurrentPayments\ApiClient\ApiClient($paymasterPaymentStrategy);
		$payload = $clientApi->authUserInPaymentSystem($params);
		$this->assertTrue(strpos($payload, ".") != -1);
    }
}