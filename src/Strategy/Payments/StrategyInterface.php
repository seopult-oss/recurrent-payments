<?php

namespace RecurrentPayments\Strategy\Payments;

/**
 * Interface StrategyInterface
 */
interface StrategyInterface
{
	/**
	 * @param array $params
	 * @return mixed
	 */
	public function authUserInPaymentSystem(array $params);
	/**
	 * @param array $params
	 * @return mixed
	 */
	public function initPayment(array $params);

	/**
	 * @param \RecurrentPayments\Strategy\Transport\TransportInterface $transport
	 * @return mixed
	 */
	public function setTransport($transport);

	/**
	 * @return \RecurrentPayments\Strategy\Transport\TransportInterface
	 */
	public function getTransport();
}