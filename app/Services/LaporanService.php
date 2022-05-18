<?php

namespace App\Services;

use App\Perkara;
use App\KategoriBagian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Constant;
use App\Services\RekapitulasiService;

class LaporanService
{
    public function __construct()
    {
        $this->user = Auth::user();
        $this->year = date('Y');
    }

    public function rekapPolda($params)
    {
        // params
        $label = '';
        $label = $params['divisi'];
        $total_narkoba = 0;

        /**
         * Row 1
         * data kasus terbaru 
         */

        $narkoba = Perkara::when(!empty($label), function ($query) use ($label) {
            $query->where('divisi', $label);
        })->sum('qty');

        $total_narkoba = number_format($narkoba);

        $count_kasus = Perkara::when(!empty($label), function ($query) use ($label) {
            $query->where('divisi', $label);
        })->count();

        $count_kasus_lama = Perkara::when(!empty($label), function ($query) use ($label) {
            $query->where('divisi', $label);
        })->where('date_no_lp', '<=', date('Y-m-d', strtotime('-6 months')))
          ->where('status_id', 1)
          ->count();

        $count_kasus_this_y = Perkara::when(!empty($label), function ($query) use ($label) {
            $query->where('divisi', $label);
        })->whereYear('date_no_lp', date('Y'))
          ->count();

        $count_kasus_belum = Perkara::when(!empty($label), function ($query) use ($label) {
            $query->where('divisi', $label);
        })->where('status_id', '1')
          ->count();

        $count_kasus_selesai = $count_kasus - $count_kasus_belum;
        /** hitung percentase */
        $percent_done = 0;
        if($count_kasus > 0){
          $percent_done = ($count_kasus_selesai/$count_kasus)*100;
        }

        /**
         * Row 2
         */
        $arrMonthProgress = array (
            array("Jan",0),
            array("Feb",0),
            array("Mar",0),
            array("Apr",0),
            array("Mei",0),
            array("Jun",0),
            array("Jul",0),
            array("Aug",0),
            array("Sep",0),
            array("Oct",0),
            array("Nov",0),
            array("Des",0),
        );
        $arrMonthDone = array (
            array("Jan",0),
            array("Feb",0),
            array("Mar",0),
            array("Apr",0),
            array("Mei",0),
            array("Jun",0),
            array("Jul",0),
            array("Aug",0),
            array("Sep",0),
            array("Oct",0),
            array("Nov",0),
            array("Des",0),
        );
        // kelompokan data progress berdasarkan bulan
        $dataMonthProgress = Perkara::select(DB::raw('count(id) as `data`'),
            DB::raw('MONTH(created_at) month'))
            ->when(!empty($label), function ($query) use ($label) {
                $query->where('divisi', $label);
            })
            ->where('status_id', '=', Constant::PROGRESS)
            ->whereYear('created_at', '=', $this->year)
            ->groupby('month')
            ->get();

        foreach($dataMonthProgress as $progres){
            $arrMonthProgress[$progres->month][1] = $progres->data;
        }
        // kelompokan data selesai berdasarkan bulan
        $dataMonthDones = Perkara::select(DB::raw('count(id) as `data`'),
            DB::raw('MONTH(created_at) month'))
            ->when(!empty($label), function ($query) use ($label) {
                $query->where('divisi', $label);
            })
            ->where('status_id', '!=', Constant::PROGRESS)
            ->whereYear('created_at', '=', $this->year)
            ->groupby('month')
            ->get();

        foreach($dataMonthDones as $done){
            $arrMonthDone[$done->month][1] = $done->data;
        }

        /**
         * Row 3
         */

        $index_jenis_kejahatans = DB::table('perkaras')
            ->leftJoin('jenis_pidanas', 'jenis_pidanas.id', '=', 'perkaras.jenis_pidana')
            ->select('jenis_pidanas.name', DB::raw('count(perkaras.jenis_pidana) as total'))
            ->when(!empty($label), function ($query) use ($label) {
                $query->where('divisi', $label);
            })
            ->groupBy('jenis_pidanas.name')
            ->orderBy('total', 'desc')
            ->limit(3)
            ->get();

        $index_satker_polda = Perkara::select([
            'perkaras.divisi', 
            DB::raw('count(perkaras.divisi) as total')
          ])
          ->groupBy('perkaras.divisi')
          ->orderBy('total', 'desc')
          ->where('perkaras.kategori_id', 1)
          ->get();

        $datas = [
            'total_narkoba'             => $total_narkoba,
            'year'                      => $this->year,
            'label'                     => $label,
            'count_kasus'               => $count_kasus,
            'count_kasus_lama'          => $count_kasus_lama,
            'count_kasus_this_y'        => $count_kasus_this_y,
            'percent_done'              => $percent_done,
            'arrMonthProgress'          => $arrMonthProgress,
            'arrMonthDone'              => $arrMonthDone,
            'index_jenis_kejahatans'    => $index_jenis_kejahatans,
            'index_satker_polda'        => $index_satker_polda
        ];

        return $datas;
    }

    public function rekapPolres($params)
    {
        // params
        $label = '';
        $nama_polres = '';
        $label = $params['divisi'];
        $kategori_bagian_id = $params['kategori_bagian_id'];
        $parameter = [
            'satker' => $kategori_bagian_id,
        ];

        // nama polres
        $kategori_bagian = KategoriBagian::where('id', $kategori_bagian_id)->first();
        $nama_polres = $kategori_bagian->name;

        $total_narkoba = 0;
        /**
         * Row 1
         * data kasus terbaru 
         */

        $narkoba = Perkara::when(!empty($label), function ($query) use ($label) {
            $query->where('divisi', $label);
        })->where('kategori_bagian_id', $kategori_bagian_id)->sum('qty');

        $total_narkoba = number_format($narkoba);

        $count_kasus = Perkara::when(!empty($label), function ($query) use ($label) {
            $query->where('divisi', $label);
        })->where('kategori_bagian_id', $kategori_bagian_id)->count();

        $count_kasus_lama = Perkara::when(!empty($label), function ($query) use ($label) {
            $query->where('divisi', $label);
        })->where('date_no_lp', '<=', date('Y-m-d', strtotime('-6 months')))
          ->where('kategori_bagian_id', $kategori_bagian_id)
          ->where('status_id', 1)
          ->count();

        $count_kasus_this_y = Perkara::when(!empty($label), function ($query) use ($label) {
            $query->where('divisi', $label);
        })->whereYear('date_no_lp', date('Y'))
          ->where('kategori_bagian_id', $kategori_bagian_id)
          ->count();

        $count_kasus_belum = Perkara::when(!empty($label), function ($query) use ($label) {
            $query->where('divisi', $label);
        })->where('status_id', '1')
          ->where('kategori_bagian_id', $kategori_bagian_id)
          ->count();

        $count_kasus_selesai = $count_kasus - $count_kasus_belum;
        /** hitung percentase */
        $percent_done = 0;
        if($count_kasus > 0){
          $percent_done = ($count_kasus_selesai/$count_kasus)*100;
        }

        /**
         * Row 2
         */
        $arrMonthProgress = array (
            array("Jan",0),
            array("Feb",0),
            array("Mar",0),
            array("Apr",0),
            array("Mei",0),
            array("Jun",0),
            array("Jul",0),
            array("Aug",0),
            array("Sep",0),
            array("Oct",0),
            array("Nov",0),
            array("Des",0),
        );
        $arrMonthDone = array (
            array("Jan",0),
            array("Feb",0),
            array("Mar",0),
            array("Apr",0),
            array("Mei",0),
            array("Jun",0),
            array("Jul",0),
            array("Aug",0),
            array("Sep",0),
            array("Oct",0),
            array("Nov",0),
            array("Des",0),
        );
        // kelompokan data progress berdasarkan bulan
        $dataMonthProgress = Perkara::select(DB::raw('count(id) as `data`'),
            DB::raw('MONTH(created_at) month'))
            ->when(!empty($label), function ($query) use ($label) {
                $query->where('divisi', $label);
            })
            ->where('kategori_bagian_id', $kategori_bagian_id)
            ->where('status_id', '=', Constant::PROGRESS)
            ->whereYear('created_at', '=', $this->year)
            ->groupby('month')
            ->get();

        foreach($dataMonthProgress as $progres){
            $arrMonthProgress[$progres->month][1] = $progres->data;
        }
        // kelompokan data selesai berdasarkan bulan
        $dataMonthDones = Perkara::select(DB::raw('count(id) as `data`'),
            DB::raw('MONTH(created_at) month'))
            ->when(!empty($label), function ($query) use ($label) {
                $query->where('divisi', $label);
            })
            ->where('kategori_bagian_id', $kategori_bagian_id)
            ->where('status_id', '!=', Constant::PROGRESS)
            ->whereYear('created_at', '=', $this->year)
            ->groupby('month')
            ->get();

        foreach($dataMonthDones as $done){
            $arrMonthDone[$done->month][1] = $done->data;
        }

        /**
         * Row 3
         */

        $index_jenis_kejahatans = DB::table('perkaras')
            ->leftJoin('jenis_pidanas', 'jenis_pidanas.id', '=', 'perkaras.jenis_pidana')
            ->select('jenis_pidanas.name', DB::raw('count(perkaras.jenis_pidana) as total'))
            ->when(!empty($label), function ($query) use ($label) {
                $query->where('divisi', $label);
            })
            ->where('kategori_bagian_id', $kategori_bagian_id)
            ->groupBy('jenis_pidanas.name')
            ->orderBy('total', 'desc')
            ->limit(3)
            ->get();

        $index_satker_polda = Perkara::select([
            'perkaras.divisi', 
            DB::raw('count(perkaras.divisi) as total')
          ])
          ->where('kategori_bagian_id', $kategori_bagian_id)
          ->groupBy('perkaras.divisi')
          ->orderBy('total', 'desc')
          ->where('perkaras.kategori_id', 1)
          ->get();

        // rekap polsek
        $rekap_polsek = (new RekapitulasiService())->rekapPolres($parameter);

        $datas = [
            'total_narkoba'             => $total_narkoba,
            'year'                      => $this->year,
            'kategori_bagian_id'        => $kategori_bagian_id,
            'label'                     => $label,
            'nama_polres'               => $nama_polres,
            'count_kasus'               => $count_kasus,
            'count_kasus_lama'          => $count_kasus_lama,
            'count_kasus_this_y'        => $count_kasus_this_y,
            'percent_done'              => $percent_done,
            'arrMonthProgress'          => $arrMonthProgress,
            'arrMonthDone'              => $arrMonthDone,
            'index_jenis_kejahatans'    => $index_jenis_kejahatans,
            'index_satker_polda'        => $index_satker_polda,
            'rekap_polsek'              => $rekap_polsek
        ];

        return $datas;
    }

    public function backupRekapPolda($params)
    {
        $divisi = $params['divisi'];

        $data = Perkara::orderBy('perkaras.updated_at', 'desc')
            ->leftJoin('jenis_pidanas', 'jenis_pidanas.id', '=', 'perkaras.jenis_pidana')
            ->leftJoin('kategori_bagians', 'kategori_bagians.id', '=', 'perkaras.kategori_bagian_id')
            ->leftJoin('korbans', 'korbans.no_lp', '=', 'perkaras.no_lp')
            ->leftJoin('statuses', 'statuses.id', '=', 'perkaras.status_id')
            ->select(
                'perkaras.id',
                'perkaras.no_lp',
                'kategori_bagians.name as satuan',
                'perkaras.nama_petugas',
                'korbans.nama',
                'korbans.barang_bukti',
                'perkaras.date',
                'perkaras.time',
                'perkaras.divisi',
                'jenis_pidanas.name as pidana',
                'perkaras.status_id',
                'statuses.name as status')
            ->where('perkaras.kategori_id', 1)
            ->when(!empty($divisi), function ($query) use ($divisi) {
              $query->where('kategori_bagian_id', $divisi);
            })
            ->where(function ($query) use ($search) {
              $query->where('perkaras.no_lp', 'like', "%$search%")
                ->orWhere('kategori_bagians.name', 'like', "%$search%")
                ->orWhere('perkaras.nama_petugas', 'like', "%$search%")
                ->orWhere('korbans.nama', 'like', "%$search%")
                ->orWhere('jenis_pidanas.name', 'like', "%$search%");
            })
            ->paginate(25);

        // Ditreskrimsus Pie Selesai
        $pie_polda = Perkara::where('kategori_bagian_id', $divisi)
            ->where('status_id', '!=', 1)
            ->count();

        // Ditreskrimsus Pie Belum Selesai
        $pie_polda_belum = Perkara::where('kategori_bagian_id', $divisi)
            ->where('status_id', '=', 1)
            ->count();

        /** untuk label */
        $satker_fr_param = KategoriBagian::where('id', $divisi)->first();

        $datas = [
            'count_kasus'               => $count_kasus,
            'count_kasus_lama'          => $count_kasus_lama,
            'count_kasus_this_y'        => $count_kasus_this_y,
            'percent_done'              => $percent_done,
            'arrMonthProgress'          => $arrMonthProgress,
            'arrMonthDone'              => $arrMonthDone,
            'index_jenis_kejahatans'    => $index_jenis_kejahatans,
            'index_satker_polda'        => $index_satker_polda,
            'index_satker_polres'       => $index_satker_polres,
            'index_satker_polsek'       => $index_satker_polsek
        ];

        return $datas;
    }

    public function backupRekapPolres()
    {
        // params
      $polres_param = $request->polres;
      $divisi_param = $request->divisi;
      $search       = $request->search;
      $unit         = $request->unit;
      // label
      $label_polres = KategoriBagian::where('id', $polres_param)->first();

      // data
      $data = Perkara::orderBy('perkaras.updated_at', 'desc')
          ->leftJoin('jenis_pidanas', 'jenis_pidanas.id', '=', 'perkaras.jenis_pidana')
          ->leftJoin('kategori_bagians', 'kategori_bagians.id', '=', 'perkaras.kategori_bagian_id')
          ->leftJoin('korbans', 'korbans.no_lp', '=', 'perkaras.no_lp')
          ->leftJoin('statuses', 'statuses.id', '=', 'perkaras.status_id')
          ->select(
              'perkaras.id',
              'perkaras.no_lp',
              'kategori_bagians.name as satuan',
              'perkaras.nama_petugas',
              'korbans.nama',
              'korbans.barang_bukti',
              'perkaras.date',
              'perkaras.time',
              'perkaras.divisi',
              'jenis_pidanas.name as pidana',
              'perkaras.status_id',
              'statuses.name as status')
          ->where('perkaras.divisi', '=', $divisi_param)
          ->where('perkaras.kategori_bagian_id', $polres_param)
          ->where('perkaras.kategori_id', 2)
          ->where(function ($query) use ($search) {
            $query->where('perkaras.no_lp', 'like', "%$search%")
              ->orWhere('kategori_bagians.name', 'like', "%$search%")
              ->orWhere('perkaras.nama_petugas', 'like', "%$search%")
              ->orWhere('korbans.nama', 'like', "%$search%")
              ->orWhere('jenis_pidanas.name', 'like', "%$search%");
          })
          ->paginate(25);

      // data pie
      $pie = Perkara::where('divisi', $divisi_param)
          ->where('status_id', '!=', 1)
          ->where('perkaras.kategori_bagian_id', $polres_param)
          ->count();

      $pie_belum = Perkara::where('divisi', $divisi_param)
          ->where('status_id', '=', 1)
          ->where('perkaras.kategori_bagian_id', $polres_param)
          ->count();

      // data turunan
      $dataTurunans = TurunanSatuan::select([
            'perkaras.id',
            'perkaras.no_lp',
            'kategori_bagians.name as satuan',
            'perkaras.nama_petugas',
            'korbans.nama',
            'korbans.barang_bukti',
            'perkaras.date',
            'perkaras.time',
            'perkaras.divisi',
            'jenis_pidanas.name as pidana',
            'perkaras.status_id',
            'statuses.name as status'
        ])->where('turunan_satuans.satker_id', $polres_param)
          ->join('perkaras', 'turunan_satuans.satker_turunan_id', '=', 'perkaras.kategori_bagian_id')
          ->join('korbans', 'perkaras.no_lp', '=', 'korbans.no_lp')
          ->join('kategori_bagians', 'perkaras.kategori_bagian_id', '=', 'kategori_bagians.id')
          ->join('statuses', 'perkaras.status_id', '=', 'statuses.id')
          ->join('jenis_pidanas', 'perkaras.jenis_pidana', '=', 'jenis_pidanas.id')
          ->where(function ($query) use ($unit) {
            $query->where('perkaras.no_lp', 'like', "%$unit%")
              ->orWhere('kategori_bagians.name', 'like', "%$unit%")
              ->orWhere('perkaras.nama_petugas', 'like', "%$unit%")
              ->orWhere('korbans.nama', 'like', "%$unit%")
              ->orWhere('jenis_pidanas.name', 'like', "%$unit%");
          })
          ->paginate(25);

      // data statistik
      // ambil data dan di groupby sesuai satker
      $grouping = TurunanSatuan::select([
          'kategori_bagians.name',
          'kategori_bagian_id',
          DB::raw('count(kategori_bagian_id) as total')
      ])->where('turunan_satuans.satker_id', $polres_param)
        ->join('perkaras', 'turunan_satuans.satker_turunan_id', '=', 'perkaras.kategori_bagian_id')
        ->join('kategori_bagians', 'perkaras.kategori_bagian_id', '=', 'kategori_bagians.id')
        ->groupBy('kategori_bagians.name', 'kategori_bagian_id')
        ->orderBy('kategori_bagians.name', 'asc')
        ->get();

      // hitung jumlah kasus selesai
      foreach ($grouping as $key => $add) {
          $rekap_blm_selesai = TurunanSatuan::select([
              'kategori_bagians.name',
              'kategori_bagian_id',
              DB::raw('count(kategori_bagian_id) as total')
            ])->where('turunan_satuans.satker_id', $polres_param)
              ->join('perkaras', 'turunan_satuans.satker_turunan_id', '=', 'perkaras.kategori_bagian_id')
              ->join('kategori_bagians', 'perkaras.kategori_bagian_id', '=', 'kategori_bagians.id')
              ->groupBy('kategori_bagians.name', 'kategori_bagian_id')
              ->orderBy('kategori_bagians.name', 'asc')
              ->where('status_id', 1)
              ->get();

          foreach ($rekap_blm_selesai as $key => $add2) {
              if($add->kategori_bagian_id == $add2->kategori_bagian_id){
                  $add->kasus_selesai = $add->total - $add2->total;
              }
          }
      }

      // hitung jumlah data untuk parameter
      foreach ($grouping as $key => $countArray) {
          $count = count(get_object_vars($countArray));
          $countArray->array = $count;
      }

      // hitung persentase kasus selesai
      foreach ($grouping as $key => $persentase) {
          if($persentase->array == 3){
              $persentase->percent_success = 0;
          }else{
              $persentase->percent_success = number_format(($persentase->kasus_selesai/$persentase->total)*100);
          }
      }

      // hitung total kasus
      $count_kasus = TurunanSatuan::join('perkaras', 'turunan_satuans.satker_turunan_id', '=', 'perkaras.kategori_bagian_id')
                    ->where('turunan_satuans.satker_id', $polres_param)
                    ->count();
      
      // hitung total kasus selesai
      $count_kasus_selesai = TurunanSatuan::join('perkaras', 'turunan_satuans.satker_turunan_id', '=', 'perkaras.kategori_bagian_id')
                    ->where('turunan_satuans.satker_id', $polres_param)
                    ->where('status_id', '!=', 1)
                    ->count();

      // hitung total kasus belum selesai
      $count_kasus_belum_selesai = TurunanSatuan::join('perkaras', 'turunan_satuans.satker_turunan_id', '=', 'perkaras.kategori_bagian_id')
                    ->where('turunan_satuans.satker_id', $polres_param)
                    ->where('status_id', 1)
                    ->count();

      if($count_kasus > 0){
        $persentase = ($count_kasus_selesai / $count_kasus)*100;
        $english_format_number = number_format($persentase);
      }else{
        $english_format_number = 0;
      }

      return view('admin.laporan.rekap_polres', compact(
          'pie',
          'pie_belum',
          'data',
          'divisi_param',
          'label_polres',
          'dataTurunans',
          'polres_param',
          'grouping',
          'count_kasus_selesai',
          'count_kasus_belum_selesai',
          'count_kasus'
      ));
    }
}
