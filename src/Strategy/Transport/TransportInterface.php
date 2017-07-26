<?php

namespace RecurrentPayments\Strategy\Transport;

/**
 * Interface TransportInterface
 */
interface TransportInterface
{
	/**
	 * Request to API
	 *
	 * @param string $url     Url
	 * @param string $method  Method name
	 * @param array  $params  POST/GET params [paramName => paramValue]
	 * @param array  $headers Headers array [headerName => headerValue]
	 *
	 * @return array
	 */
	public function request($url, $method = 'GET', array $params = [], array $headers = []);
}