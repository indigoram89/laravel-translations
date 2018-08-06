<?php

namespace Indigoram89\Laravel\Translations\Drivers;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Indigoram89\Laravel\Translations\Contracts\Driver;

class Lokalise implements Driver
{
	protected $config;

	public function __construct(array $config)
	{
		$this->config = $config;
	}

	public function push(array $translations) : int
	{
		if (count($translations) === 0) return 0;

		$data = [];

		foreach ($translations as $key => $values) {
			$data[] = [
				'key' => $key,
				'translations' => $values,
				'platform_mask' => 4,
			];
		}

		$data = json_encode($data, JSON_UNESCAPED_UNICODE);
		
		$response = $this->call('post', 'string/set', compact('data'));
		
		return $response['result']['inserted'];
	}

	public function pull() : array
	{
		$response = $this->call('post', 'string/list');

		$translations = [];

		if (isset($response['strings'])) {
			foreach ($response['strings'] as $locale => $keys) {
				foreach ($keys as $attributes) {
					$translations[$attributes['key']][$locale] = $attributes['translation'];
				}
			}
		}

		return $translations;
	}

	protected function call(string $method, string $endpoint, array $params = [])
	{
		$response = $this->sendRequest($method, $endpoint, $params);

		return $this->getResponse($response);
	}

	protected function sendRequest(string $method, string $endpoint, array $params = [])
	{
		return $this->client()->send(
			$this->getRequest($method, $endpoint),
			$this->getParams($method, $params)
		);
	}

	protected function client()
	{
		return new Client;
	}

	protected function getRequest(string $method, string $endpoint)
	{
		return new Request($method, $this->getUrl($endpoint));
	}

	protected function getUrl(string $endpoint)
	{
		$endpoint = trim($endpoint, '/');

		return "https://api.lokalise.co/api/{$endpoint}";
	}

	protected function getParams(string $method, array $params = [])
	{
		$api_token = $this->getConfig('token');
		
		$id = $this->getConfig('project');

		$params = $params + compact('api_token', 'id');
		
		return (strtoupper($method) === 'GET')
			? ['query' => $params] : ['form_params' => $params];
	}

	protected function getResponse(Response $response)
	{
		$response = json_decode((string) $response->getBody(), true);

		if (strtoupper($response['response']['status']) === 'SUCCESS') {
			return $response;
		}

		throw new Exception($response['response']['message']);
	}

	public function getConfig(string $key)
	{
		return array_get($this->config, $key);
	}
}