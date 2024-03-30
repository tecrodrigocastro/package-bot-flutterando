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
        // $this->http_cliente = new HttpClientService();
    }

    public function addPackage()
    {

        $http_cliente = new HttpClientService();

        $this->validate();
        PackageName::create(['name' => $this->name]);

        $data = $http_cliente->getVersionPackage($this->name);

        ModelsPackage::create([
            'name' => $this->name,
            'latest_version' => $data['latest']['version'],
            'description' => $data['latest']['pubspec']['description'],
            'url' => 'https://pub.dev/packages/' . $this->name,
        ]);


        $this->package_list = PackageName::all();


        session()->flash('message', 'Package adicionado com sucesso!');
    }

    public function removePackage($id)
    {
        $teste =  PackageName::find($id);
        ModelsPackage::where('name', $teste->name)->delete();
        $teste->delete();
        $this->package_list = PackageName::all();
        session()->flash('message', 'Package deletado com sucesso!');
    }

    public function render()
    {
        return view('livewire.package');
    }
}
