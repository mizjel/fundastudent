<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(StatusSeeder::class);
        $this->call(SchoolsAndMailExtensionsSeeder::class);
        $this->call(UsersTableSeeder::class);
//        $this->call(AcademicYearSeeder::class);
    }
}
