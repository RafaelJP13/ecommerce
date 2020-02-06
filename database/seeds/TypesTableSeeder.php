<?php

use Illuminate\Database\Seeder;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->insert([
            'id'   => 1,
            'name' => 'Gerente',
            'created_at' => '2020-06-02 00:00:00',
            'updated_at' => '2020-06-02 00:00:00',
        ]);

        DB::table('types')->insert([
            'id'   => 2,
            'name' => 'Vendedor',
            'created_at' => '2020-06-02 00:00:00',
            'updated_at' => '2020-06-02 00:00:00',
        ]);
    }
}
