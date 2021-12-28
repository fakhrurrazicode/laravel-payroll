<?php

namespace Database\Seeds;

use Illuminate\Database\Seeder;

class JabatanTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('jabatan')->delete();
        
        \DB::table('jabatan')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nama' => 'Direksi',
                'gaji_pokok' => 10000000,
                'created_at' => '2021-12-28 19:42:18',
                'updated_at' => '2021-12-28 19:46:09',
            ),
            1 => 
            array (
                'id' => 2,
                'nama' => 'Direktur Utama',
                'gaji_pokok' => 9500000,
                'created_at' => '2021-12-28 19:42:41',
                'updated_at' => '2021-12-28 19:42:41',
            ),
            2 => 
            array (
                'id' => 3,
                'nama' => 'Direktur Keuangan',
                'gaji_pokok' => 9500000,
                'created_at' => '2021-12-28 19:42:54',
                'updated_at' => '2021-12-28 19:42:54',
            ),
            3 => 
            array (
                'id' => 4,
                'nama' => 'Direktur',
                'gaji_pokok' => 9500000,
                'created_at' => '2021-12-28 19:43:10',
                'updated_at' => '2021-12-28 19:43:10',
            ),
            4 => 
            array (
                'id' => 5,
                'nama' => 'Direktur Personalia',
                'gaji_pokok' => 9000000,
                'created_at' => '2021-12-28 19:43:33',
                'updated_at' => '2021-12-28 19:43:33',
            ),
            5 => 
            array (
                'id' => 6,
                'nama' => 'Manajer',
                'gaji_pokok' => 8000000,
                'created_at' => '2021-12-28 19:43:46',
                'updated_at' => '2021-12-28 19:43:46',
            ),
            6 => 
            array (
                'id' => 7,
                'nama' => 'Manajer Personalia',
                'gaji_pokok' => 7500000,
                'created_at' => '2021-12-28 19:44:00',
                'updated_at' => '2021-12-28 19:44:00',
            ),
            7 => 
            array (
                'id' => 8,
                'nama' => 'Manajer Pemasaran',
                'gaji_pokok' => 7500000,
                'created_at' => '2021-12-28 19:44:14',
                'updated_at' => '2021-12-28 19:44:14',
            ),
            8 => 
            array (
                'id' => 9,
                'nama' => 'Manajer Pabrik',
                'gaji_pokok' => 7500000,
                'created_at' => '2021-12-28 19:44:26',
                'updated_at' => '2021-12-28 19:44:26',
            ),
            9 => 
            array (
                'id' => 10,
                'nama' => 'Administrasi dan Pergudangan',
                'gaji_pokok' => 7000000,
                'created_at' => '2021-12-28 19:45:13',
                'updated_at' => '2021-12-28 19:45:13',
            ),
        ));
        
        
    }
}