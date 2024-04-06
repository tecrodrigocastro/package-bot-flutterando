<?php

namespace App\Livewire;

use App\Models\Package as ModelsPackage;
use App\Models\PackageName;
use App\Services\HttpClientService;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Package extends Component
{


    public Collection $package_list;


    #[Validate('required')]
    public  $name;

    public function mount()
    {

        $this->package_list = PackageName::all();
    }

    public function addPackage()
    {
        $this->validate();

        $this->createPackageName();
        $this->createPackageModel();

        $this->package_list = PackageName::all();

        session()->flash('message', 'Package adicionado com sucesso!');
    }

    private function createPackageName()
    {
        PackageName::create(['name' => $this->name]);
    }

    private function createPackageModel()
    {
        $http_cliente = new HttpClientService();
        $data = $http_cliente->getVersionPackage($this->name);

        ModelsPackage::create([
            'name' => $this->name,
            'latest_version' => $data['latest']['version'],
            'description' => $data['latest']['pubspec']['description'],
            'url' => 'https://pub.dev/packages/' . $this->name,
        ]);
    }

    public function removePackage($id)
    {
        $packageName = PackageName::find($id);
        ModelsPackage::where('name', $packageName->name)->delete();
        $packageName->delete();

        $this->package_list = PackageName::all();
    }

    public function sendNotification()
    {
        $http_cliente = new HttpClientService();
        $package = ModelsPackage::query()->get()->first();


        $http_cliente->sendInfoDiscord($package);


        session()->flash('message', 'Notificação enviada com sucesso!');
    }

    public function render()
    {
        return view('livewire.package');
    }
}
