<?php

namespace Modules\Payment\Services;

use App\Models\PaymentGatewaySetting;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class TabbyPaymentService
{
    protected Client $client;
    protected ?string $publicKey;
    protected ?string $secretKey;
    protected ?string $merchantCode;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.tabby.ai/api/v2/',
            'timeout'  => 15.0,
        ]);

        $this->publicKey    = PaymentGatewaySetting::getValue('tabby', 'public_key');
        $this->secretKey    = PaymentGatewaySetting::getValue('tabby', 'secret_key');
        $this->merchantCode = PaymentGatewaySetting::getValue('tabby', 'merchant_code');
    }

    /* ───────────────────────────────────────────────────
     *  Checkout session (create + retrieve)
     * ─────────────────────────────────────────────────── */

    /**
     * Create a Tabby checkout session.
     * Docs: https://docs.tabby.ai/pay-in-4-custom-integration/checkout-flow
     */
    public function createCheckoutSession(array $data): object
    {
        try {
            $response = $this->client->post('checkout', [
                'headers' => $this->authHeaders(),
                'json'    => $data,
            ]);

            return json_decode($response->getBody()->getContents());
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $responseBody = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : 'No response body';
            Log::error('Tabby: Error creating checkout session', [
                'error'         => $e->getMessage(),
                'status_code'   => $e->hasResponse() ? $e->getResponse()->getStatusCode() : 'N/A',
                'response_body' => $responseBody,
                'request_data'  => $data,
            ]);
            throw new \Exception('Tabby checkout error: ' . $responseBody);
        } catch (GuzzleException $e) {
            Log::error('Tabby: Error creating checkout session', ['error' => $e->getMessage()]);
            throw new \Exception('Error creating checkout session: ' . $e->getMessage());
        }
    }

    /* ───────────────────────────────────────────────────
     *  Payment operations
     * ─────────────────────────────────────────────────── */

    /**
     * Retrieve payment details by ID (server-to-server verification).
     * Docs: https://docs.tabby.ai/pay-in-4-custom-integration/payment-processing#payment-verification
     */
    public function retrievePayment(string $paymentId): array
    {
        Log::info('Tabby: Retrieving payment', ['payment_id' => $paymentId]);

        try {
            $response = $this->client->get("payments/{$paymentId}", [
                'headers' => $this->authHeaders(),
            ]);

            $payment = json_decode($response->getBody()->getContents(), true);
            Log::info('Tabby: Payment retrieved', ['status' => $payment['status'] ?? 'unknown']);

            return $payment;
        } catch (GuzzleException $e) {
            Log::error('Tabby: Error retrieving payment', ['error' => $e->getMessage()]);
            throw new \Exception('Error retrieving payment: ' . $e->getMessage());
        }
    }

    /**
     * Capture an authorized payment.
     * Docs: https://docs.tabby.ai/pay-in-4-custom-integration/payment-processing#payment-capture
     */
    public function capturePayment(string $paymentId, array $data): array
    {
        Log::info('Tabby: Capturing payment', ['payment_id' => $paymentId, 'data' => $data]);

        try {
            $response = $this->client->post("payments/{$paymentId}/captures", [
                'headers' => $this->authHeaders(),
                'json'    => $data,
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            Log::info('Tabby: Payment captured', ['result' => $result]);

            return $result;
        } catch (GuzzleException $e) {
            Log::error('Tabby: Error capturing payment', ['error' => $e->getMessage()]);
            throw new \Exception('Error capturing payment: ' . $e->getMessage());
        }
    }

    /**
     * Refund a captured payment.
     * Docs: https://docs.tabby.ai/pay-in-4-custom-integration/payment-processing#payment-refund
     */
    public function refundPayment(string $paymentId, array $data): array
    {
        Log::info('Tabby: Refunding payment', ['payment_id' => $paymentId, 'data' => $data]);

        try {
            $response = $this->client->post("payments/{$paymentId}/refunds", [
                'headers' => $this->authHeaders(),
                'json'    => $data,
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            Log::info('Tabby: Payment refunded', ['result' => $result]);

            return $result;
        } catch (GuzzleException $e) {
            Log::error('Tabby: Error refunding payment', ['error' => $e->getMessage()]);
            throw new \Exception('Error refunding payment: ' . $e->getMessage());
        }
    }

    /* ───────────────────────────────────────────────────
     *  Webhook registration
     * ─────────────────────────────────────────────────── */

    /**
     * Register webhook URL.
     * Docs: https://docs.tabby.ai/pay-in-4-custom-integration/webhooks
     */
    public function registerWebhook(string $url, bool $isTest = false, ?string $authHeader = null): array
    {
        try {
            $data = [
                'url'    => $url,
                'header' => [
                    'title' => 'TABBY_WEBHOOK_AUTH',
                    'value' => $authHeader ?? 'Basic ' . base64_encode('username:password'),
                ],
            ];

            $webhookClient = new Client([
                'base_uri' => 'https://api.tabby.ai/api/v1/',
                'timeout'  => 10.0,
            ]);

            $response = $webhookClient->post('webhooks', [
                'headers' => array_merge($this->authHeaders(), [
                    'X-Merchant-Code' => $this->merchantCode,
                ]),
                'json' => $data,
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error('Tabby: Error registering webhook', ['error' => $e->getMessage()]);
            throw new \Exception('Error registering webhook: ' . $e->getMessage());
        }
    }

    /* ───────────────────────────────────────────────────
     *  Helpers
     * ─────────────────────────────────────────────────── */

    protected function authHeaders(): array
    {
        return [
            'Authorization' => "Bearer {$this->secretKey}",
            'Content-Type'  => 'application/json',
        ];
    }

    public function getPublicKey(): ?string
    {
        return $this->publicKey;
    }

    public function getMerchantCode(): ?string
    {
        return $this->merchantCode;
    }
}
