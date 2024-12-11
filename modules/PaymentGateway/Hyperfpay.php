<?php

namespace Modules\PaymentGateway;

use Hyperf\Guzzle\ClientFactory;

class Hyperfpay implements PaymentGatewayInterface {

	public function __construct(
		private ClientFactory $clientFactory
	) {}

	public function authorizeTransaction(): bool {
		$client = $this->clientFactory->create();

		try {
			$response = $client->get('https://util.devi.tools/api/v2/authorize');
			$statusCode = $response->getStatusCode();

			if ($statusCode === 200) {
				$body = json_decode($response->getBody()->getContents(), true);
				return isset($body['data']['authorization']) && $body['data']['authorization'] === true;
			}
		} catch (\Throwable $e) {
			return false;
		}

		return false;
	}
}
