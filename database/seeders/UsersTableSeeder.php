<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        DB::table('users')->insert([
            'name'         => "hasib",
            'email'        => 'hasib@unifiedtransform.com',
            'password'     => bcrypt('secret'),
            'role'         => 'master',
            'active'       => 1,
            'verified'     => 1,
            'phone_number' => '09000000000',
        ]);
        */

        factory(User::class, 10)->states('admin')->create();
        factory(User::class, 10)->states('accountant')->create();
        factory(User::class, 10)->states('librarian')->create();
        factory(User::class, 30)->states('teacher')->create();
        factory(User::class, 200)->states('student')->create();
    }
}
