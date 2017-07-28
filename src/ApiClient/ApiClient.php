<?php

namespace RecurrentPayments\ApiClient;

/**
 * Class ApiClient
 */
class ApiClient implements ApiClientInterface
{
	/**
	 * Payment strategy
	 *
	 * @var \RecurrentPayments\Strategy\Payments\StrategyInterface
	 */
	protected $paymentStrategy;

	/**
	 * ApiClient constructor.
	 *
	 * @param \RecurrentPayments\Strategy\Payments\StrategyInterface $paymentStrategy Payment strategy
	 */
	public function __construct(\RecurrentPayments\Strategy\Payments\StrategyInterface $paymentStrategy)
	{
		$this->paymentStrategy = $paymentStrategy;
	}

	/**
	 * Auth user in payment system
	 *
	 * @param array $params Params
	 *
	 * @return mixed
	 */
	public function authUserInPaymentSystem(array $params)
	{
		return $this->paymentStrategy->authUserInPaymentSystem($params);
	}

	/**
	 * Init payment
	 *
	 * @param array $params Params
	 *
	 * @return mixed;
	 */
	public function InitPayment(array $params)
	{
		$this->paymentStrategy->initPayment($params);
		return 0;
	}

	/**
	 * Logout user from payment system
	 *
	 * @param array $params Params
	 *
	 * @return mixed
	 */
	public function logoutUserInPaymentSystem(array $params)
	{
		return $this->paymentStrategy->logoutUserInPaymentSystem($params);
	}
}