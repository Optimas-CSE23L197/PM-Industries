<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApiClient
{
    protected $baseUrl;
    protected $apiPass;

    public function __construct()
    {
        $this->baseUrl = config('services.pmIndustries.url');
        $this->apiPass = config('services.pmIndustries.pass');
    }

    public function get($endpoint, $params = []){
        $params['apipass'] = $this->apiPass;
        $params = array_map(function ($value) {
            return $value ?? '';
        }, $params);

        $url = $this->baseUrl . $endpoint . '?' . http_build_query($params);
        // dd($url);
        // echo $url.'<br>';

        $response = Http::timeout(20)
            ->retry(2, 200)
            ->get($url);

        $body = $response->body();

        // API failure detection
        if (str_starts_with($body, '0')) {
            return [
                'error' => true,
                'message' => substr($body, 1)
            ];
        }

        // SUCCESS MESSAGE (Add/Edit/Delete)
        if (str_starts_with($body, '1')) {
            return [
                'error' => false,
                'message' => substr($body, 1)
            ];
        }

        return [
            'error' => false,
            'data' => json_decode($body, true)
        ];
    }
}