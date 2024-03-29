<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\PackageName;
use App\Services\HttpClientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckForUpdate extends Controller
{
/*     public $http_cliente;
    public $package_list;
    public function __construct(HttpClientService $http_cliente)
    {
        $this->http_cliente = $http_cliente;
        $this->package_list = PackageName::all()->pluck('name')->toArray();
    } */
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        /*  foreach ($this->package_list as $package) {
            $data = $this->http_cliente->getVersionPackage($package);

            $teste =   Package::updateOrCreate(
                ['name' => $package], // condições para encontrar o registro existente
                [ // valores para atualizar
                    'latest_version' => $data['latest']['version'],
                    'description' => $data['latest']['pubspec']['description'],
                    'url' => $data['latest']['archive_url'],
                ]
            );
        } */
        return response()->json(Package::all());

        /*  return response()->json(Package::all()); */
    }
}
