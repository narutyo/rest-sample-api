<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class InitializeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 初期ユーザー登録
        $user = new User;
        $user->fill([
          'name'      => 'external',
          'email'     => 'external@local',
          'identification_code'  => '2222',
          'password'  => Hash::make('123456'),
        ]);
        $user->save();
        $user = new User;
        $user->fill([
          'name'      => 'admin',
          'email'     => 'admin@local',
          'identification_code'  => '1111',
          'password'  => Hash::make('123456'),
        ]);
        $user->save();
    }
}
