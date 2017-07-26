<?php

namespace RecurrentPayments\Strategy\Payments;

/**
 * Class Paymaster
 */
class Qiwi implements StrategyInterface
{
	/**
	 * @var \RecurrentPayments\Strategy\Transport\TransportInterface
	 */
	protected $transport;

	/**
	 * Paymaster constructor.
	 * @param \RecurrentPayments\Strategy\Transport\TransportInterface $transport
	 */
	public function __construct($transport)
	{
		$this->transport = $transport;
	}

	/**
	 * @param array $params
	 *
	 * @return mixed
	 */
	public function authUserInPaymentSystem(array $params)
	{
		$request = '';
		return $request;
	}

	/**
	 * @param array $params
	 * @return mixed;
	 */
	public function initPayment(array $params)
	{
		return 0;
	}

	/**
	 * @param \RecurrentPayments\Strategy\Transport\TransportInterface $transport
	 * @return mixed
	 */
	public function setTransport($transport)
	{
		$this->transport = $transport;
		return $this;
	}

	/**
	 * @return \RecurrentPayments\Strategy\Transport\TransportInterface
	 */
	public function getTransport()
	{
		return $this->transport;
	}
}