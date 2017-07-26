<?php
namespace Tests\ApiClient;


use RecurrentPayments\ApiClient\ApiClient;
use RecurrentPayments\Strategy\Payments\Paymaster;
use RecurrentPayments\Strategy\Transport\Curl;

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
    			'redirectUri' => 'https://recurrent-payments.test.seopult.ru/billing.html'
			]
		];
		$curlTransport = new Curl();
		$paymasterPaymentStrategy = new Paymaster($curlTransport);
		$clientApi = new ApiClient($paymasterPaymentStrategy);
		$AuthUri = $clientApi->authUserInPaymentSystem($params);
		var_dump($AuthUri);
    }
}