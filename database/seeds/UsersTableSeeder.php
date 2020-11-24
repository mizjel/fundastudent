<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\BankAccount;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        factory(User::class, 20)->create(['verified' => 1]);

        //Admin account
        $admin = factory(User::class)->create([
            'email' => 'admin@test.nl',
            'verified' => 1,
        ]);

        factory(BankAccount::class)->create([
            'user_id' => $admin->id,
        ]);

        \App\Admin::create([
            'user_id' => $admin->id
        ]);

        //User account
        $user = factory(User::class)->create([
            'email' => 'user@test.nl',
        ]);

        factory(BankAccount::class)->create([
            'user_id' => $user->id,
        ]);

        //Verified user
        $verifiedUser = factory(User::class)->create([
            'email' => 'verified@test.nl',
            'verified' => 1
        ]);

        factory(BankAccount::class)->create([
            'user_id' => $verifiedUser->id,
        ]);

    }
}
