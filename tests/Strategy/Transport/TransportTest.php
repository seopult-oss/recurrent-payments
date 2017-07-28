<?php
namespace Tests\Strategy\Transport;


class TransportTest extends \Codeception\Test\Unit
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
    public function testTransport()
    {
		$transport = new \RecurrentPayments\Strategy\Transport\Curl();

		$response = $transport->request(
			'https://unexistinghost.com',
			'GET',
			['a' => 'b'],
			['Content-Type: application/json']
		);

		$this->assertEquals($response['error'], 700);
		$this->assertEquals($response['message'], "Transfer protocol error (6): Could not resolve host: unexistinghost.com");
    }

	public function testInvalidMethod()
	{
		$transport = new \RecurrentPayments\Strategy\Transport\Curl();

		$response = $transport->request(
			'https://unexistinghost.com',
			'GETS',
			['a' => 'b'],
			['Content-Type: application/json']
		);

		$this->assertEquals($response['error'], 911);
		$this->assertEquals($response['message'], "Method not allowed");
	}


	public function testJsonConvertMethod()
	{
		$transport = new \RecurrentPayments\Strategy\Transport\Curl();

		$response = $transport->request(
			'https://unexistinghost.com',
			'POST',
			['a' => 'b'],
			['Content-Type: application/json']
		);

		$this->assertEquals($response['error'], 700);
		$this->assertEquals($response['message'], "Transfer protocol error (6): Could not resolve host: unexistinghost.com");
	}
}