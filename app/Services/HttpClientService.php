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

    public function sendInfoDiscord()
    {

        $title = 'Seu título aqui';
        $description = 'Sua descrição aqui';
        $link = 'Seu link aqui';

        $body = [
            'embeds' => [
                [
                    'title' => $title,
                    'description' => $description,
                    'url' => $link,

                    'fields' => [
                        [
                            'name' => 'Package',
                            'value' => "[Link do package]($link)",
                            'inline' => true,
                        ],
                        [
                            'name' => 'Changelog',
                            'value' => "[Changlog]($link/changelog)",
                            'inline' => true,
                        ],
                    ]
                ]
            ]
        ];
        $response = $this->client->request(
            'POST',
            env('LOG_DISCORD_WEBHOOK_URL'),
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],

                'body' => json_encode($body)
            ]
        );

        return $response;
    }
}
