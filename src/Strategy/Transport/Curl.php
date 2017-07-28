<?php

namespace RecurrentPayments\Strategy\Transport;

/**
 * Class Curl
 */
class Curl implements TransportInterface
{
	/**
	 * Default curl options
	 *
	 * @var array
	 */
	protected $defaultCurlOptions = [
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HEADER => true,
		CURLOPT_VERBOSE => false,
		CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
		CURLOPT_CONNECTTIMEOUT => 5
	];

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
	public function request($url, $method = 'GET', array $params = [], array $headers = [])
	{
		$method = strtoupper($method);
		if (!in_array($method, ['POST', 'PUT', 'GET', 'UPDATE', 'DELETE', 'PATCH'])) {
			return [
				'error' => [
					'code' => 911,
					'text' => "Method not allowed"
				]
			];
		}

		$requestUrl = $url;
		$getParams = '';
		$otherParams = [];

		if ($method == 'GET') {
			$tmpGetParams = [];
			foreach ($params as $paramName => $paramValue) {
				$tmpGetParams[] = $paramName."=".$paramValue;
			}
			if (count($tmpGetParams)) {
				$getParams = implode("&", $tmpGetParams);
			}
			if ($getParams) {
				$requestUrl .= '?'.$getParams;
			}
		} else {
			$headers = array_change_key_case($headers);
			if (!empty($headers['content-type']) && strpos(strtolower($headers['content-type']), "application/x-www-form-urlencoded") !== false) {
				$otherParams = $params;
			} else {
				$otherParams = json_encode($params);
			}
		}
		
		$curl = curl_init();
		curl_setopt_array($curl, $this->defaultCurlOptions);
		curl_setopt($curl, CURLOPT_URL, $requestUrl);
		if ($otherParams) {
			curl_setopt($curl, CURLOPT_POSTFIELDS, $otherParams);
		}
		if ($method != 'GET') {
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
		}

		if ($headers) {
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		}

		$response = curl_exec($curl);
		$curlInfo = curl_getinfo($curl);

		$errno = curl_errno($curl);
		$error = curl_error($curl);

		if ($errno) {
			return [
				'error' => 700,
				'text' => "Transfer protocol error ($errno): $error"
			];
		} else {
			return [
				'error' => 0,
				'headers' => substr($response, 0, $curlInfo['header_size']),
				'response' => substr($response, $curlInfo['header_size'])
			];
		}
	}
}