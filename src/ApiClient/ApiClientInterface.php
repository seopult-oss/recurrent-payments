<?php

namespace RecurrentPayments\ApiClient;

/**
 * Class ApiClient
 */
interface ApiClientInterface
{
	/**
	 * Auth user in payment system
	 *
	 * @param array $params Params
	 *
	 * @return mixed
	 */
	public function authUserInPaymentSystem(array $params);

	/**
	 * Init payment
	 *
	 * @param array $params Params
	 *
	 * @return mixed;
	 */
	public function InitPayment(array $params);

	/**
	 * Logout user from payment system
	 *
	 * @param array $params Params
	 *
	 * @return mixed
	 */
	public function logoutUserInPaymentSystem(array $params);
}