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

    public function sendInfoDiscord(mixed $package)
    {

        $body = [
            'embeds' => [
                [
                    'author' => [
                        'url' => $package->url,
                    ],
                    'title' => 'New version of ' . $package->name . ' is out! 🚀',
                    'description' => "@everyone" . "\n" . "The new version of "  . $package->name . " is " . $package->latest_version,
                    'url' =>  $package->url,
                    'color' => 15258703,
                    'fields' => [
                        [
                            'name' => 'Package',
                            'value' => '[' . $package->name . '](' . $package->url . ')',
                            'inline' => true,
                        ],
                        [
                            'name' => 'Latest Version',
                            'value' => $package->latest_version,
                            'inline' => true,
                        ],
                        [
                            'name' => 'Changelog',
                            'value' => '[Changelog](' . $package->url . '/changelog)',
                            'inline' => true,
                        ],
                    ],
                    'thumbnail' => [
                        'url' => 'https://raw.githubusercontent.com/born-ideas/rsa_identification/master/assets/project_badge.png',
                    ],
                    'footer' => [
                        'text' => 'Flutterando Bot',
                        'icon_url' => 'https://yt3.googleusercontent.com/KDE8sM5Y92ho_bW-E4n5xX4H6H-f5fI-9EgR1q6GdJamXp_ehUESSDUs2JcsY6eoEbfqk9jQ=s900-c-k-c0x00ffffff-no-rj',
                    ],
                ],
            ],
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
