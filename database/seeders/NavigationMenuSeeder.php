<?php

namespace Database\Seeders;

use App\Models\NavigationMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NavigationMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NavigationMenu::create([

            'sequence' => 1,
            'type' => 'Sidebar',
            'label' => 'Home',
            'slug' => 'home',
        ]);
        NavigationMenu::create([
            'sequence' => 2,
            'type' => 'Sidebar',
            'label' => 'About',
            'slug' => 'about',
        ]);
        NavigationMenu::create([
            'sequence' => 3,
            'type' => 'Sidebar',
            'label' => 'Contact',
            'slug' => 'contact',
        ]);
        NavigationMenu::create([
            'sequence' => 1,
            'type' => 'Top',
            'label' => 'Login',
            'slug' => 'login',
        ]);
        NavigationMenu::create([
            'sequence' => 1,
            'type' => 'Top',
            'label' => 'Home',
            'slug' => 'home',
        ]);
    }
}
