<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnKategoriJnsPidanaOnJenisPidanasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jenis_pidanas', function (Blueprint $table) {
            $table->integer('kategori_jns_pidana')->after('id')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jenis_pidanas', function (Blueprint $table) {
            $table->dropColumn('kategori_jns_pidana');
        });
    }
}
