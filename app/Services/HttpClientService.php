<?php

namespace App\Services;


class HttpClientService
{
    public $client;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
    }

    public function getVersionPackage(string $package_name)
    {
        $response  = $this->client->request(
            'GET',
            config('app.pub_dev_url') . $package_name,
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept-Encoding' => 'gzip',
                ],
            ]
        );

        return json_decode($response->getBody()->getContents(), true);
    }
}
