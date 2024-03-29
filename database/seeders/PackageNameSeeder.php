<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $package_list = [
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

        foreach ($package_list as $package) {
            \App\Models\PackageName::create(['name' => $package]);
        }
    }
}
