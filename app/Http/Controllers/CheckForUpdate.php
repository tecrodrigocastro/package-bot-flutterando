<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Services\HttpClientService;
use Illuminate\Http\Request;

class CheckForUpdate extends Controller
{
    public $http_cliente;
    public $package_list = [
        'asp',
        'flutter_modular',
        'uno',
        'flutter_triple',
        'dio',
        'flutter_bloc',
        'shared_preferences',
        'go_router',
        'full_coverage',
        'intl',
        'mocktail',
        'mockito',
        'routefly',
        'http',
        'url_launcher',
        'path_provider',
        'cached_network_image',
    ];
    public function __construct(HttpClientService $http_cliente)
    {
        $this->http_cliente = $http_cliente;
    }
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        foreach ($this->package_list as $package) {
            $data = $this->http_cliente->getVersionPackage($package);

            Package::updateOrCreate(
                ['name' => $package], // condições para encontrar o registro existente
                [ // valores para atualizar
                    'latest_version' => $data['latest']['version'],
                    'description' => $data['latest']['pubspec']['description'],
                    'url' => $data['latest']['archive_url'],
                ]
            );
        }

        /*       collect($response)->map(function ($item, $key) {
            dd($item);
            return [
                'name' => $key,
                'latest_version' => $item['latest']['version'],
                'description' => $item['latest']['pubspec']['description'],
                'url' => $item['latest']['pubspec']['archive_url'],
            ];
        })->toArray();
 */
        /*         Package::upsert(
            collect($response)->map(function ($item, $key) {
                return [
                    'name' => $key,
                    'latest_version' => $item['latest']['version'],
                    'description' => $item['latest']['pubspec']['description'],
                    'url' => $item['latest']['archive_url'],
                ];
            })->toArray(),
            ['name'],
            ['latest_version', 'description', 'url']
        ); */

        return response()->json(Package::all());
    }
}
