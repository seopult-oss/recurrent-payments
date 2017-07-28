<?php

namespace RecurrentPayments\Strategy\Payments;

/**
 * Interface StrategyInterface
 */
interface StrategyInterface
{
	/**
	 * Auth user in payment system
	 *
	 * @param array $params Array of params
	 *
	 * @return mixed
	 *
	 * @throws \Exception
	 */
	public function authUserInPaymentSystem(array $params);

	/**
	 * Init payment
	 *
	 * @param array $params Array of params
	 *
	 * @return mixed
	 *
	 * @throws \Exception
	 */
	public function initPayment(array $params);

	/**
	 * Logout user in payment system
	 *
	 * @param array $params Array of params
	 *
	 * @return mixed
	 *
	 * @throws \Exception
	 */
	public function logoutUserInPaymentSystem(array $params);
}