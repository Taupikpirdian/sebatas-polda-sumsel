<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use App\Perkara;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class PerkaraExport implements FromView
{
    use Exportable;
    
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function view(): View
    {
    	$param = (explode(", ",$this->name));
      $kategori_bagian_id = $param[0];
      $jenis_pidana = $param[1];
      $mode = $param[2];

      if(!$mode){ // umum
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

      }elseif($mode == 'polda'){
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
      }

      return view('excel.rekapitulasi_all', [
          'rekaps' => $rekaps
      ]);

    }

    // backup data
    // if($param[0] && $param[1]){

    //   return view('excel.rekapitulasi_satker_pidana', [
    //       'rekapitulasis' => DB::table('perkaras')
    //           ->leftJoin('kategori_bagians', 'kategori_bagians.id', '=', 'perkaras.kategori_bagian_id')
    //           ->leftJoin('jenis_pidanas', 'jenis_pidanas.id', '=', 'perkaras.jenis_pidana')
    //           ->select('kategori_bagians.name', 'jenis_pidanas.name as pidana', DB::raw('count(kategori_bagian_id) as total'))
    //           ->groupBy('kategori_bagians.name', 'jenis_pidanas.name')
    //           ->where('kategori_bagian_id', $param[0])
    //           ->where('jenis_pidana', $param[1])
    //           ->get()
    //   ]);
      
    // }elseif($param[0]){

    //   return view('excel.rekapitulasi_satker', [
    //       'rekapitulasis' => DB::table('perkaras')
    //           ->leftJoin('kategori_bagians', 'kategori_bagians.id', '=', 'perkaras.kategori_bagian_id')
    //           ->select('kategori_bagians.name', DB::raw('count(kategori_bagian_id) as total'))
    //           ->groupBy('kategori_bagians.name')
    //           ->where('kategori_bagian_id', $param[0])
    //           ->get()
    //   ]);

    // }elseif ($param[1]) {

    //   return view('excel.rekapitulasi', [
    //       'rekapitulasis' => DB::table('perkaras')
    //           ->leftJoin('kategori_bagians', 'kategori_bagians.id', '=', 'perkaras.kategori_bagian_id')
    //           ->leftJoin('jenis_pidanas', 'jenis_pidanas.id', '=', 'perkaras.jenis_pidana')
    //           ->select('kategori_bagians.name', 'jenis_pidanas.name as pidana', DB::raw('count(kategori_bagian_id) as total'))
    //           ->groupBy('kategori_bagians.name', 'jenis_pidanas.name')
    //           ->where('jenis_pidana', $param[1])
    //           ->get()
    //   ]);

    // }

}
