<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'name' => 'Badreddine Zatout',
                'email' => 'admin@example.com',
                'role' => 'admin',
                'password' => '$2y$10$mciTph.QOp/uFbZuEUrj.u3Z5Z8WXwWYHeMAzDssHOivSeXc2ti6y',
            ]
        );
        User::create([
            'name' => 'Bob Green',
            'email' => 'bob@esi.dz',
            'role' => 'user',
            'password' => '$2y$10$B5zMDb5V5bMxqpAC3/APSOcNvOdZhoucWJh7LFFXmWuppEiu9Vb2W'
        ]);
    }
}
