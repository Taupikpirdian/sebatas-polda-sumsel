<?php

use Illuminate\Database\Seeder;
use App\KategoriBagian;

class KategoriBagianPolairudTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 178;
        $kategori_bagian->kategori_id = 1;
        $kategori_bagian->name 		  = 'Polda Ditpolairud';
        $kategori_bagian->save();

        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 179;
        $kategori_bagian->kategori_id = 2;
        $kategori_bagian->name 		  = 'Satpolairesta Palembang';
        $kategori_bagian->save();

        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 180;
        $kategori_bagian->kategori_id = 2;
        $kategori_bagian->name 		  = 'Satpolaires Muba';
        $kategori_bagian->save();

        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 181;
        $kategori_bagian->kategori_id = 2;
        $kategori_bagian->name 		  = 'Satpolaires Banyuasin';
        $kategori_bagian->save();

        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 182;
        $kategori_bagian->kategori_id = 2;
        $kategori_bagian->name 		  = 'Satpolaires Oki';
        $kategori_bagian->save();
    }
}
