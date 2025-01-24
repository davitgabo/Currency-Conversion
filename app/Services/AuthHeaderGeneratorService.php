<?php

namespace App\Services;

class AuthHeaderGeneratorService
{
    private const NONCE_LENGTH = 32;

    public function generate(
        string $macId,
        string $macSecret,
        int $timestamp,
        string $body,
        string $url,
        string $method
    ): string {
        list($host, $uri, $port) = $this->getUrlParts($url);

        $nonce = $this->generateNonce();
        $ext = $this->generateExt($body);

        $mac = $this->calculateMac(
            $timestamp,
            $nonce,
            $method,
            $uri,
            $host,
            $port,
            $ext,
            $macSecret
        );

        $params = [
            'id' => $macId,
            'ts' => $timestamp,
            'nonce' => $nonce,
            'mac' => $mac,
        ];
        if ($ext != '') {
            $params['ext'] = $ext;
        }
        $parts = [];
        foreach ($params as $name => $value) {
            $parts[] = $name . '="' . $value . '"';
        }

        return 'MAC ' . implode(', ', $parts);
    }

    private function generateNonce(): string
    {
        $nonce = '';
        for ($i = 0; $i < self::NONCE_LENGTH; $i++) {
            $rnd = mt_rand(0, 92);
            if ($rnd >= 2) {
                $rnd++;
            }
            if ($rnd >= 60) {
                $rnd++;
            }
            $nonce .= chr(32 + $rnd);
        }
        return $nonce;
    }

    private function generateExt(string $content): string
    {
        $extParts = [];
        if ($content != '') {
            $extParts['body_hash'] = base64_encode(hash('sha256', $content, true));
        }

        return http_build_query($extParts);
    }

    private function calculateMac(
        int $timestamp,
        string $nonce,
        string $method,
        string $uri,
        string $host,
        int $port,
        string $ext,
        string $secret
    ): string {

        $normalizedRequest = implode(
            "\n",
            [
                $timestamp,
                $nonce,
                $method,
                $uri,
                $host,
                $port,
                $ext,
                ''
            ]
        );

        return base64_encode(
            hash_hmac(
                'sha256',
                $normalizedRequest,
                $secret,
                true
            )
        );
    }

    private function getUrlParts(string $url): array
    {
        $pregPattern = '/(https?):\/\/(.*?)\/(.*)/';

        preg_match($pregPattern, $url, $matches);
        $host = $matches[2];
        $uri = '/'.$matches[3];
        $port = $matches[1] === 'https' ? 443 : 80;

        return [$host, $uri, $port];
    }
}
