<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
          'password'  => '123456',
          'admin_flg' => false,
          'system_user' => true,
        ]);
        $user->save();
        $user = new User;
        $user->fill([
          'name'      => 'admin',
          'email'     => 'admin@local',
          'identification_code'  => '1111',
          'password'  => '123456',
          'admin_flg' => true,
          'system_user' => true,
        ]);
        $user->save();
    }
}
