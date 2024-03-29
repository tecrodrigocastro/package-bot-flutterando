<?php

namespace App\Livewire;

use App\Models\Package as ModelsPackage;
use App\Models\PackageName;
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
        $this->package_list = PackageName::all();;
    }

    public function addPackage()
    {
        $this->validate();
        PackageName::create(['name' => $this->name]);

        ModelsPackage::create([
            'name' => $this->name,
            'latest_version' => '0.0.0',
            'description' => 'No description',
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
