<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            ['key' => 'field_size','value' => 7,],
            ['key' => 'pawn_count','value' => 4,],
//            ['key' => 'pawn_count','value' => 4,],
        ]);
    }
}
