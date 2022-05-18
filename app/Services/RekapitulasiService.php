<?php

namespace App\Services;

use App\Perkara;
use App\TurunanSatuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Constant;

class RekapitulasiService
{
    public function __construct()
    {
        $this->user = Auth::user();
        $this->year = date('Y');
    }

    public function rekapUmum()
    {
        // ambil data dan di groupby sesuai satker
        $rekaps = DB::table('perkaras')
            ->select('kategori_bagians.name', 'kategori_bagian_id', DB::raw('count(kategori_bagian_id) as total'))
            ->leftJoin('kategori_bagians', 'kategori_bagians.id', '=', 'perkaras.kategori_bagian_id')
            ->groupBy('kategori_bagians.name', 'kategori_bagian_id')
            ->orderBy('kategori_bagians.name', 'asc')
            ->get();

        // hitung jumlah kasus selesai
        foreach ($rekaps as $key => $rekap) {
          // count kasus selesai
          $kasus_selesai = Perkara::where('kategori_bagian_id', $rekap->kategori_bagian_id)->where('status_id', '!=', 1)->count();
          // count kasus progress
          $kasus_progress = Perkara::where('kategori_bagian_id', $rekap->kategori_bagian_id)->where('status_id', 1)->count();
          $rekap->kasus_selesai   = $kasus_selesai;
          $rekap->kasus_progress  = $kasus_progress;
        }

        $count_kasus = Perkara::count();
        $count_kasus_selesai = Perkara::where('status_id', '!=', 1)->count();
        $count_kasus_belum_selesai = Perkara::where('status_id', 1)->count();

        $datas = [
            'rekaps'                    => $rekaps,
            'count_kasus'               => $count_kasus,
            'count_kasus_selesai'       => $count_kasus_selesai,
            'count_kasus_belum_selesai' => $count_kasus_belum_selesai
        ];

        return $datas;
    }

    public function rekapPolda()
    {
        // ambil data dan di groupby sesuai satker
        $rekaps = DB::table('perkaras')
            ->select(
                'divisi as name', 
                DB::raw('count(divisi) as total')
                )
            ->groupBy('divisi')
            ->orderBy('divisi', 'asc')
            ->where('kategori_id', 1)
            ->get();

        // hitung jumlah kasus selesai
        foreach ($rekaps as $key => $rekap) {
          // count kasus selesai
          $kasus_selesai = Perkara::where('divisi', $rekap->name)->where('status_id', '!=', 1)->count();
          // count kasus progress
          $kasus_progress = Perkara::where('divisi', $rekap->name)->where('status_id', 1)->count();
          $rekap->kasus_selesai   = $kasus_selesai;
          $rekap->kasus_progress  = $kasus_progress;
        }

        $count_kasus = Perkara::where('kategori_id', 1)->count();
        $count_kasus_selesai = Perkara::where('kategori_id', 1)->where('status_id', '!=', 1)->count();
        $count_kasus_belum_selesai = Perkara::where('kategori_id', 1)->where('status_id', 1)->count();

        $datas = [
            'rekaps'                    => $rekaps,
            'count_kasus'               => $count_kasus,
            'count_kasus_selesai'       => $count_kasus_selesai,
            'count_kasus_belum_selesai' => $count_kasus_belum_selesai
        ];

        return $datas;
    }

    public function rekapPolres($param)
    {
        $satker = $param['satker'];
        $rekaps = TurunanSatuan::select([
          'kategori_bagians.name',
          'kategori_bagian_id',
          DB::raw('count(kategori_bagian_id) as total')
        ])->where('turunan_satuans.satker_id', $satker)
          ->join('perkaras', 'turunan_satuans.satker_turunan_id', '=', 'perkaras.kategori_bagian_id')
          ->join('kategori_bagians', 'perkaras.kategori_bagian_id', '=', 'kategori_bagians.id')
          ->groupBy('kategori_bagians.name', 'kategori_bagian_id')
          ->orderBy('kategori_bagians.name', 'asc')
          ->get();

        // hitung jumlah kasus selesai
        foreach ($rekaps as $key => $rekap) {
          // count kasus selesai
          $kasus_selesai = Perkara::where('kategori_bagian_id', $rekap->kategori_bagian_id)->where('status_id', '!=', 1)->count();
          // count kasus progress
          $kasus_progress = Perkara::where('kategori_bagian_id', $rekap->kategori_bagian_id)->where('status_id', 1)->count();
          $rekap->kasus_selesai   = $kasus_selesai;
          $rekap->kasus_progress  = $kasus_progress;
        }

        $count_kasus = TurunanSatuan::where('turunan_satuans.satker_id', $satker)
            ->join('perkaras', 'turunan_satuans.satker_turunan_id', '=', 'perkaras.kategori_bagian_id')
            ->count();

        $count_kasus_selesai = TurunanSatuan::where('turunan_satuans.satker_id', $satker)
            ->join('perkaras', 'turunan_satuans.satker_turunan_id', '=', 'perkaras.kategori_bagian_id')
            ->where('status_id', '!=', 1)
            ->count();

        $count_kasus_belum_selesai = TurunanSatuan::where('turunan_satuans.satker_id', $satker)
            ->join('perkaras', 'turunan_satuans.satker_turunan_id', '=', 'perkaras.kategori_bagian_id')
            ->where('status_id', 1)
            ->count();

        $datas = [
            'rekaps'                    => $rekaps,
            'count_kasus'               => $count_kasus,
            'count_kasus_selesai'       => $count_kasus_selesai,
            'count_kasus_belum_selesai' => $count_kasus_belum_selesai
        ];

        return $datas;
    }

}
