<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ApiAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Simple API key auth OR session-based
        $apiKey = $request->getHeaderLine('X-API-Key');

        // Accept session (internal) or API key
        if (session()->get('isLoggedIn')) {
            return; // Session user — allow
        }

        // Check API key header (define in .env: API_KEY=your_secret_key)
        $validKey = env('API_KEY', 'ta2_secret_api_key_2024');
        if ($apiKey && $apiKey === $validKey) {
            return; // Valid API key — allow
        }

        // Reject
        $response = service('response');
        $response->setStatusCode(401);
        $response->setContentType('application/json');
        $response->setBody(json_encode([
            'status'  => 'error',
            'message' => 'Unauthorized. Provide a valid X-API-Key header or be logged in.',
        ]));
        return $response;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $response->setHeader('Access-Control-Allow-Origin', '*');
        $response->setHeader('Access-Control-Allow-Methods', 'GET');
        $response->setHeader('Access-Control-Allow-Headers', 'Content-Type, X-API-Key');
    }
}
