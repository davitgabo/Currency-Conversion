<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Exception;
class ConversionService
{
    public $authHeaderGeneratorService;
    public $macId;
    public $macSecret;

    public function __construct(AuthHeaderGeneratorService $authHeaderGeneratorService)
    {
        $this->authHeaderGeneratorService = $authHeaderGeneratorService;
        $this->macId = env('WALLET_PROJECT_ID');
        $this->macSecret = env('WALLET_PROJECT_PASSWORD');
    }

    public function rate($data)
    {
        try {
            $params = [
                'from_currency' => $data['from_currency'],
                'to_currency' => $data['to_currency'],
                'from_amount_decimal' => $data['from_amount'],
            ];
            $queryString = http_build_query($params);
            $url = 'https://wallet.paysera.com/rest/v1/currency-conversion?'.$queryString;
            $method = 'GET';
            $bodyJson = json_encode([]);

            $authHeader = $this->authHeaderGeneratorService->generate(
                $this->macId,
                $this->macSecret,
                time(),
                $bodyJson,
                $url,
                $method
            );

            $client = new Client();
            $response = $client->request(
                $method,
                $url,
                [
                    'headers' => [
                        'Authorization' => $authHeader,
                    ],
                    'body' => $bodyJson,
                ]
            );

            // Output the payment URL on a new line
            return json_decode($response->getBody()->getContents(), true);

        } catch (Exception $exception) {
            dd(get_class($exception) . ': ' . $exception->getMessage() . "\n");
        }
    }
}
