<?php

namespace RecurrentPayments\ApiClient;

class ApiClient
{
	/**
	 * @var \RecurrentPayments\Strategy\Payments\StrategyInterface
	 */
	protected $paymentStrategy;

	/**
	 * ApiClient constructor.
	 * @param \RecurrentPayments\Strategy\Payments\StrategyInterface $paymentStrategy
	 */
	public function __construct($paymentStrategy)
	{
		$this->paymentStrategy = $paymentStrategy;
	}

	/**
	 * @param array $params
	 *
	 * @return mixed
	 */
	public function authUserInPaymentSystem(array $params)
	{
		return $this->paymentStrategy->authUserInPaymentSystem($params);
	}

	/**
	 * @param array $params
	 * @return mixed;
	 */
	public function InitPayment(array $params)
	{
		$this->paymentStrategy->initPayment($params);
		return 0;
	}
}