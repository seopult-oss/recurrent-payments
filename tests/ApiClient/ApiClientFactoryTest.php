<?php
namespace Tests\ApiClient;

class ApiClientFactoryTest extends \Codeception\Test\Unit
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
    public function testEmptyStrategyName()
    {
		$this->expectException(\Exception::class);
		$this->expectExceptionMessage('Invalid payment strategy');

		$apiClient = \RecurrentPayments\ApiClient\Factory\ApiClientFactory::createApiClient('');
	}
}