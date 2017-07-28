<?php

namespace RecurrentPayments\ApiClient\Factory;

/**
 * Class ApiClient
 */
class ApiClientFactory
{
	/**
	 * Create api client
	 *
	 * @param string $paymentStrategyName Payment strategy name
	 *
	 * @return \RecurrentPayments\ApiClient\ApiClientInterface
	 *
	 * @throws \Exception
	 */
	public static function createApiClient($paymentStrategyName)
	{
		$paymentStrategyName = '\RecurrentPayments\Strategy\Payments\\'.$paymentStrategyName;
		if (!class_exists($paymentStrategyName)) {
			throw new \Exception("Invalid payment strategy");
		}

		$paymentStrategy = new $paymentStrategyName(new \RecurrentPayments\Strategy\Transport\Curl());

		$apiClient = new \RecurrentPayments\ApiClient\ApiClient($paymentStrategy);

		return $apiClient;
	}
}