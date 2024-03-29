<?php

namespace App\Console\Commands;

use App\Http\Controllers\CheckForUpdate as ControllersCheckForUpdate;
use App\Models\Package;
use App\Models\PackageName;
use App\Services\HttpClientService;
use Illuminate\Console\Command;

class CheckForUpdate extends Command
{
    public $http_cliente;
    public $package_list;
    public function __construct(HttpClientService $http_cliente)
    {
        $this->http_cliente = $http_cliente;
        $this->package_list = PackageName::all()->pluck('name')->toArray();

        parent::__construct();
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach ($this->package_list as $packages) {
            $data = $this->http_cliente->getVersionPackage($packages);



            $package = Package::firstOrNew(['name' => $data['name']]);

            $package->latest_version = $data['latest']['version'];
            $package->description = $data['latest']['pubspec']['description'];
            $package->url = $data['latest']['archive_url'];

            if ($package->isDirty()) {
                $package->save();

                // O pacote foi atualizado, não criado
                // colocar logica para enviar mensagem no discord
                $this->http_cliente->sendInfoDiscord($package);
            }


            /*   $package =    Package::updateOrCreate(
                [
                    'name' => $data['name'],
                    'latest_version' => $data['latest']['version']
                ], // condições para encontrar o registro existente
                [ // valores para atualizar
                    'latest_version' => $data['latest']['version'],
                    'description' => $data['latest']['pubspec']['description'],
                    'url' => $data['latest']['archive_url'],
                ]
            );
            if (!$package->wasRecentlyCreated) {
                // O pacote foi atualizado, não criado
                // colocar logica para enviar mensagem no discord
                $this->http_cliente->sendInfoDiscord($package);
            } */
        }

        //logs()->info('teste', [1, 2, 3]);
        //$this->http_cliente->sendInfoDiscord($package);
    }
}
