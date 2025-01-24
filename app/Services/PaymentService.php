<?php

namespace App\Services;

use GuzzleHttp\Client;
use Exception;
class PaymentService
{
    public $authHeaderGeneratorService;
    private $macId;
    private $macSecret;

    public function __construct(AuthHeaderGeneratorService $authHeaderGeneratorService)
    {
        $this->authHeaderGeneratorService = $authHeaderGeneratorService;
        $this->macId = env('PAYMENT_PROJECT_ID');
        $this->macSecret = env('PAYMENT_PROJECT_PASSWORD');
    }
    public function generateLinkManually($order)
    {
        try {
            $url = 'https://bank.paysera.com/checkout/rest/v1/initialize';
            $method = 'POST';
            $bodyJson = json_encode(
                [
                    'projectid' => env('PAYMENT_PROJECT_ID'),
                    'orderid' => $order['order_id'],
                    'amount' => $order['from_amount']*100,
                    'currency' => $order['from_currency'],
                    'country' => 'GE',
                    'accepturl' => route('payment.accept'),
                    'cancelurl' => route('payment.cancel'),
                    'callbackurl' => route('payment.callback'),
                    'version' => '1.7',
                    'p_email' => $order['email'],
                    'payment' => 'ge_tbc',
                    'time_limit' => now()->setTimezone('Europe/Vilnius')->addMinutes(15)->toDateTimeString(),
                ]
            );

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

            $responseJson = json_decode($response->getBody()->getContents(), true);
            // Output the payment URL on a new line
            return $responseJson['url'];

        } catch (Exception $exception) {
            dd(get_class($exception) . ': ' . $exception->getMessage() . "\n");
        }
    }
}
