<?php

namespace RecurrentPayments\Strategy\Payments;

/**
 * Class Paymaster
 */
class Qiwi implements StrategyInterface
{
	/**
	 * Transport
	 *
	 * @var \RecurrentPayments\Strategy\Transport\TransportInterface
	 */
	protected $transport;

	/**
	 * Paymaster constructor.
	 *
	 * @param \RecurrentPayments\Strategy\Transport\TransportInterface $transport Transport
	 */
	public function __construct(\RecurrentPayments\Strategy\Transport\TransportInterface $transport)
	{
		$this->transport = $transport;
	}

	/**
	 * Auth user in payment system
	 *
	 * @param array $params Array of params
	 *
	 * @return mixed
	 *
	 * @throws \Exception
	 */
	public function authUserInPaymentSystem(array $params)
	{
		$request = '';
		return $request;
	}

	/**
	 * Init payment
	 *
	 * @param array $params Array of params
	 *
	 * @return mixed
	 *
	 * @throws \Exception
	 */
	public function initPayment(array $params)
	{
		return 0;
	}

	/**
	 * Logout user in payment system
	 *
	 * @param array $params Array of params
	 *
	 * @return mixed
	 *
	 * @throws \Exception
	 */
	public function logoutUserInPaymentSystem(array $params)
	{
		return 0;
	}
}