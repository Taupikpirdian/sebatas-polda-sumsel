<?php

use Illuminate\Database\Seeder;
use App\KategoriBagian;

class KategoriBagianTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 1;
        $kategori_bagian->kategori_id = 1;
        $kategori_bagian->name 		  = 'Polda Sumsel';
        $kategori_bagian->save();

        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 2;
        $kategori_bagian->kategori_id = 2;
        $kategori_bagian->name 		  = 'Polresta Palembang';
        $kategori_bagian->save();

        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 3;
        $kategori_bagian->kategori_id = 2;
        $kategori_bagian->name 		  = 'Polres Ogan Komering Ilir';
        $kategori_bagian->save();

        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 4;
        $kategori_bagian->kategori_id = 2;
        $kategori_bagian->name 		  = 'Polres Ogan Komering Ulu';
        $kategori_bagian->save();

        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 5; 
        $kategori_bagian->kategori_id = 2;
        $kategori_bagian->name 		  = 'Polres Lubuk Linggau';
        $kategori_bagian->save();

        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 6;
        $kategori_bagian->kategori_id = 2;
        $kategori_bagian->name 		  = 'Polres Musi Banyuasin';
        $kategori_bagian->save();

        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 7;
        $kategori_bagian->kategori_id = 2;
        $kategori_bagian->name 		  = 'Polres Lahat';
        $kategori_bagian->save();

        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 8;
        $kategori_bagian->kategori_id = 2;
        $kategori_bagian->name 		  = 'Polres Muara Enim';
        $kategori_bagian->save();

        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 9;
        $kategori_bagian->kategori_id = 2;
        $kategori_bagian->name 		  = 'Polres Pagar Alam';
        $kategori_bagian->save();

        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 10;
        $kategori_bagian->kategori_id = 2;
        $kategori_bagian->name 		  = 'Polres Banyuasin';
        $kategori_bagian->save();

        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 11;
        $kategori_bagian->kategori_id = 2;
        $kategori_bagian->name 		  = 'Polres Prabumulih';
        $kategori_bagian->save();

        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 12;
        $kategori_bagian->kategori_id = 2;
        $kategori_bagian->name 		  = 'Polres Ogan Komering Ulu Timur';
        $kategori_bagian->save();

        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 13;
        $kategori_bagian->kategori_id = 2;
        $kategori_bagian->name 		  = 'Polres Ogan Komering Ulu Selatan';
        $kategori_bagian->save();

        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 14;
        $kategori_bagian->kategori_id = 2;
        $kategori_bagian->name 		  = 'Polres Musi Rawas';
        $kategori_bagian->save();

        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 15;
        $kategori_bagian->kategori_id = 2;
        $kategori_bagian->name 		  = 'Polres Ogan Ilir';
        $kategori_bagian->save();

        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 16;
        $kategori_bagian->kategori_id = 2;
        $kategori_bagian->name 		  = 'Polres Empat Lawang';
        $kategori_bagian->save();

        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 17;
        $kategori_bagian->kategori_id = 2;
        $kategori_bagian->name 		  = 'Polres PALI';
        $kategori_bagian->save();

        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 18;
        $kategori_bagian->kategori_id = 2;
        $kategori_bagian->name 		  = 'Polres Muratara';
        $kategori_bagian->save();

        // POLRESTA PALEMBANG
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 19;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Ilir Barat I';
        $kategori_bagian->save();

        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 20;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Ilir Barat II';
        $kategori_bagian->save();

        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 21;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Ilir Timur I';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 22;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Ilir Timur II';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 23;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Seberang Ulu I';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 24;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Seberang Ulu II';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 25;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Sukarami';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 26;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Sako';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 27;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Plaju';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 28;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Gandus';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 29;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Kemuning';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 30;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Kalidoni';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 31;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Kertapati';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 32;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Boom Baru';
        $kategori_bagian->save();
        
        // POLRES OKI
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 33;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Pedamaran';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 34;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Mesuji';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 35;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Tanjung Lubuk';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 36;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Tulung Selapan';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 37;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Pampangan';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 38;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Sirah Pulau Padang';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 39;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Lempuing';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 40;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Kayuagung';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 41;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Air Sugihan';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 42;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Cengal';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 43;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Sungai Menang';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 44;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Jejawi';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 45;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Lempuing Jaya';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 46;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Pedamaran Timur';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 47;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Mesuji Makmur';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 48;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Pangkalan Lampam';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 49;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Mesuji Raya';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 50;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Teluk Gelam';
        $kategori_bagian->save();
        
        // POLRES OKU
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 51;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Baturaja Timur';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 52;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Baturaja Barat';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 53;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Pengandonan';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 54;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Peninjauan';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 55;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Lubuk Batang';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 56;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Sosoh Buay Rayap';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 57;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Lengkiti';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 58;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Semidang Aji';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 59;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Lubuk Raja';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 60;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Sinar Peninjauan';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 61;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Ulu Ogan';
        $kategori_bagian->save();
        
        // POLRES LUBUKLINGGAU
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 62;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Lubuk Linggau Barat ';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 63;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Lubuk Linggau Timur ';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 64;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Lubuk Linggau Utara';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 65;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Lubuk Linggau Selatan ';
        $kategori_bagian->save();

        // POLRES MUBA
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 66;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Sekayu';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 67;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Babat Toman';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 68;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Batang Hari Leko';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 69;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Sungai Lilin';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 70;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Keluang';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 71;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Lais';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 72;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Bayung Lencir';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 73;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Sungai Keruh';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 74;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Sanga Desa';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 75;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Plakat Tinggi';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 76;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Lalan';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 77;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Tungkal Jaya';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 78;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Babat Supat';
        $kategori_bagian->save();
        
        // POLRES LAHAT
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 79;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Lahat';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 80;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Merapi';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 81;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Pulau Pinang';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 82;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Mulak Ulu';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 83;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Kota Agung';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 84;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Pajar Bulan';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 85;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Jarai';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 86;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Tanjung Sakti';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 87;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Kikim Timur';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 88;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Kikim Tengah';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 89;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Kikim Selatan';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 90;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Kikim Barat';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 91;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Pseksu';
        $kategori_bagian->save();
        
        // POLRES MUARA ENIM
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 92;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Semendo';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 93;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Tanjung Agung';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 94;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Lawang Kidul';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 95;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Gunung Megang';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 96;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Rambang Dangku';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 97;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Rambang Lubay';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 98;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Lembak';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 99;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Gelumbang';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 100;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Sungai Rotan';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 101;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Rambang';
        $kategori_bagian->save();
        
        // POLRES PAGARALAM
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 102;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Pagar Alam Utara';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 103;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Pagar Alam Selatan';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 104;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Dempo Utara';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 105;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Dempo Selatan';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 106;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Dempo Tengah';
        $kategori_bagian->save();
        
        // POLRES BANYUASIN
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 107;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Talang Kelapa';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 108;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Mariana';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 109;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Pangkalan Balai ';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 110;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Betung';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 111;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Pulau Rimau ';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 112;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Rantau Bayur';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 113;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Rambutan';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 114;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Makarti Jaya';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 115;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Muara Padang';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 116;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Sungsang';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 117;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Muara';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 118;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Tanjung Lago';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 119;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Tungkal Ilir';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 120;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Air Kumbang';
        $kategori_bagian->save();
        
        // POLRES PRABUMULIH
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 121;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Prabumulih Timur';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 122;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Prabumulih Barat';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 123;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Rambang Kapak Tengah';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 124;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Cambai';
        $kategori_bagian->save();
        
        // POLRES OKU TIMUR
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 125;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Martapura';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 126;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Buay Madang';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 127;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Belitang I';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 128;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Belitang II';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 129;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Cempaka';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 130;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Madang Suku I';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 131;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Madang Suku II';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 132;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Belitang III';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 133;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Buay Pemuka Peliung';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 134;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Semendawai Suku III';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 135;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Buay Madang Timur';
        $kategori_bagian->save();
        
        // POLRES OKU SELATAN
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 136;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Muaradua';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 137;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Simpang Martapura';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 138;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Banding Agung';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 139;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Pulau Beringin';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 140;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Muaradua Kisam';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 141;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Buay Pemaca';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 142;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Mekakau Ilir';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 143;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Buay Runjung';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 144;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Kisam Tinggi';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 145;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Buay Sandang Aji';
        $kategori_bagian->save();
        
        // POLRES MUSI RAWAS
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 146;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Muara Beliti';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 147;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Muara Kelingi';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 148;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Muara Lakitan';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 149;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Bts Ulu Cecar';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 150;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Jayaloka';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 151;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Tugu Mulyo';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 152;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Purwodadi';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 153;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Megang Sakti';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 154;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Bkl Ulu Terawas';
        $kategori_bagian->save();
        
        // POLRES OGAN ILIR
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 155;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Pemulutan';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 156;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Indralaya';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 157;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Tanjung Raja';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 158;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Tanjung Batu';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 159;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Rantau Alai';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 160;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Muara Kuang';
        $kategori_bagian->save();
        
        // POLRES EMPAT LAWANG
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 161;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Tebing Tinggi ';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 162;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Muara Pinang';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 163;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Lintang Kanan';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 164;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Talang Padang';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 165;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Ulu Musi';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 166;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Pendopo';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 167;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Pasemah Air Keruh';
        $kategori_bagian->save();
        
        // POLRES PALI
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 168;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Pendopo Talang Ubi';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 169;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Penukal Abab';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 170;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Tanah Abang';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 171;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Penukal Utara';
        $kategori_bagian->save();
        
        // POLRES MURATARA
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 172;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Karang Jaya';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 173;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Muara Rupit';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 174;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Karang Dapo';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 175;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Rawas Ulu';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 176;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Nibung';
        $kategori_bagian->save();
        
        $kategori_bagian = new KategoriBagian();
        $kategori_bagian->id = 177;
        $kategori_bagian->kategori_id = 3;
        $kategori_bagian->name 		  = 'Polsek Rawas Ilir';
        $kategori_bagian->save();
        
    }
}
