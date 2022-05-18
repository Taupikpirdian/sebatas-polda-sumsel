<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnOnKorbansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('korbans', function (Blueprint $table) {
            $table->string('nama')->after('no_lp')->nullable()->change();
            $table->string('umur_korban')->after('nama')->nullable()->change();
            $table->string('pendidikan_korban')->after('umur_korban')->nullable()->change();
            $table->string('pekerjaan_korban')->after('pendidikan_korban')->nullable()->change();
            $table->string('asal_korban')->after('pekerjaan_korban')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('korbans', function (Blueprint $table) {
            $table->string('nama')->after('no_lp')->nullable();
            $table->string('umur_korban')->after('nama')->nullable();
            $table->string('pendidikan_korban')->after('umur_korban')->nullable();
            $table->string('pekerjaan_korban')->after('pendidikan_korban')->nullable();
            $table->string('asal_korban')->after('pekerjaan_korban')->nullable();
        });
    }
}
