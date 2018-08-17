<?php

use Illuminate\Database\Seeder;

class DictionaryTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dictionary_types')->insert([
            'name' => 'free entry'
        ]);

        DB::table('dictionary_types')->insert([
            'name' => 'paid entry'
        ]);
    }
}
