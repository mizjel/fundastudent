<?php

use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (\App\Status::$statuses as $status) {
            \App\Status::create([
                'status' => $status,
            ]);
        }
    }
}
