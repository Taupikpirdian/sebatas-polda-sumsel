<?php

namespace App\Services;

use App\Perkara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Constant;

class DashboardService
{
    public function __construct()
    {
        $this->user = Auth::user();
        $this->year = date('Y');
    }

    public function roleAdmin()
    {
        /**
         * Row 1
         * data kasus terbaru 
         */

        $count_kasus = Perkara::count();
        $count_kasus_lama = Perkara::where('date_no_lp', '<=', date('Y-m-d', strtotime('-6 months')))->where('status_id', 1)->count();
        $count_kasus_this_y = Perkara::whereYear('date_no_lp', date('Y'))->count();

        $count_kasus_belum = Perkara::where('status_id', '1')->count();
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
            DB::raw('MONTH(date_no_lp) month'))
            ->where('status_id', '=', Constant::PROGRESS)
            ->whereYear('date_no_lp', '=', $this->year)
            ->groupby('month')
            ->get();

        foreach($dataMonthProgress as $progres){
            $month = $progres->month - 1;
            $arrMonthProgress[$month][1] = $progres->data;
        }
        // kelompokan data selesai berdasarkan bulan
        $dataMonthDones = Perkara::select(DB::raw('count(id) as `data`'),
            DB::raw('MONTH(date_no_lp) month'))
            ->where('status_id', '!=', Constant::PROGRESS)
            ->whereYear('date_no_lp', '=', $this->year)
            ->groupby('month')
            ->get();

        foreach($dataMonthDones as $done){
            $month = $done->month - 1;
            $arrMonthDone[$month][1] = $done->data;
        }

        /**
         * Row 3
         */

        $index_jenis_kejahatans = DB::table('perkaras')
        ->leftJoin('jenis_pidanas', 'jenis_pidanas.id', '=', 'perkaras.jenis_pidana')
        ->select('jenis_pidanas.name', DB::raw('count(perkaras.jenis_pidana) as total'))
        ->groupBy('jenis_pidanas.name')
        ->orderBy('total', 'desc')
        ->limit(3)
        ->get();

        $index_satker_polda = Perkara::select('kategori_bagians.id', 'kategori_bagians.name', DB::raw('count(perkaras.kategori_id) as total'))
          ->join('kategori_bagians', 'perkaras.kategori_bagian_id', '=', 'kategori_bagians.id')
          ->join('kategoris', 'kategori_bagians.kategori_id', '=', 'kategoris.id')
          ->groupBy('kategori_bagians.id', 'kategori_bagians.name')
          ->orderBy('total', 'desc')
          ->where('kategoris.id', 1)
          ->limit(1)
          ->get();

        $index_satker_polres = Perkara::select('kategori_bagians.id', 'kategori_bagians.name', DB::raw('count(perkaras.kategori_id) as total'))
          ->join('kategori_bagians', 'perkaras.kategori_bagian_id', '=', 'kategori_bagians.id')
          ->join('kategoris', 'kategori_bagians.kategori_id', '=', 'kategoris.id')
          ->groupBy('kategori_bagians.id', 'kategori_bagians.name')
          ->orderBy('total', 'desc')
          ->where('kategoris.id', 2)
          ->limit(1)
          ->get();

        $index_satker_polsek = Perkara::select('kategori_bagians.id', 'kategori_bagians.name', DB::raw('count(perkaras.kategori_id) as total'))
          ->join('kategori_bagians', 'perkaras.kategori_bagian_id', '=', 'kategori_bagians.id')
          ->join('kategoris', 'kategori_bagians.kategori_id', '=', 'kategoris.id')
          ->groupBy('kategori_bagians.id', 'kategori_bagians.name')
          ->orderBy('total', 'desc')
          ->where('kategoris.id', 3)
          ->limit(1)
          ->get();

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

    public function roleNotAdmin()
    {
        /**
         * Row 1
         * data kasus terbaru 
         */
        $count_kasus = Perkara::where('perkaras.user_id', '=', Auth::user()->id)->count();
        $count_kasus_lama = Perkara::where('date_no_lp', '<=', date('Y-m-d', strtotime('-6 months')))->where('status_id', 1)->where('perkaras.user_id', '=', Auth::user()->id)->count();
        $count_kasus_this_y = Perkara::where('perkaras.user_id', '=', Auth::user()->id)->whereYear('date_no_lp', date('Y'))->count();

        $count_kasus_belum = Perkara::where('perkaras.user_id', '=', Auth::user()->id)->where('status_id', '1')->count();
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
            DB::raw('MONTH(date_no_lp) month'))
            ->where('status_id', '=', Constant::PROGRESS)
            ->where('perkaras.user_id', '=', Auth::user()->id)
            ->whereYear('date_no_lp', '=', $this->year)
            ->groupby('month')
            ->get();

        foreach($dataMonthProgress as $progres){
            $month = $progres->month - 1;
            $arrMonthProgress[$month][1] = $progres->data;
        }
        // kelompokan data selesai berdasarkan bulan
        $dataMonthDones = Perkara::select(DB::raw('count(id) as `data`'),
            DB::raw('MONTH(date_no_lp) month'))
            ->where('status_id', '!=', Constant::PROGRESS)
            ->where('perkaras.user_id', '=', Auth::user()->id)
            ->whereYear('date_no_lp', '=', $this->year)
            ->groupby('month')
            ->get();

        foreach($dataMonthDones as $done){
            $month = $done->month - 1;
            $arrMonthDone[$month][1] = $done->data;
        }

        /**
         * Row 3
         */

        $index_jenis_kejahatans = DB::table('perkaras')
        ->leftJoin('jenis_pidanas', 'jenis_pidanas.id', '=', 'perkaras.jenis_pidana')
        ->select('jenis_pidanas.name', DB::raw('count(perkaras.jenis_pidana) as total'))
        ->where('perkaras.user_id', '=', Auth::user()->id)
        ->groupBy('jenis_pidanas.name')
        ->orderBy('total', 'desc')
        ->limit(3)
        ->get();

        $index_satker_polda = Perkara::select('kategori_bagians.id', 'kategori_bagians.name', DB::raw('count(perkaras.kategori_id) as total'))
          ->join('kategori_bagians', 'perkaras.kategori_bagian_id', '=', 'kategori_bagians.id')
          ->join('kategoris', 'kategori_bagians.kategori_id', '=', 'kategoris.id')
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->groupBy('kategori_bagians.id', 'kategori_bagians.name')
          ->orderBy('total', 'desc')
          ->where('kategoris.id', 1)
          ->limit(1)
          ->get();

        $index_satker_polres = Perkara::select('kategori_bagians.id', 'kategori_bagians.name', DB::raw('count(perkaras.kategori_id) as total'))
          ->join('kategori_bagians', 'perkaras.kategori_bagian_id', '=', 'kategori_bagians.id')
          ->join('kategoris', 'kategori_bagians.kategori_id', '=', 'kategoris.id')
          ->groupBy('kategori_bagians.id', 'kategori_bagians.name')
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->orderBy('total', 'desc')
          ->where('kategoris.id', 2)
          ->limit(1)
          ->get();

        $index_satker_polsek = Perkara::select('kategori_bagians.id', 'kategori_bagians.name', DB::raw('count(perkaras.kategori_id) as total'))
          ->join('kategori_bagians', 'perkaras.kategori_bagian_id', '=', 'kategori_bagians.id')
          ->join('kategoris', 'kategori_bagians.kategori_id', '=', 'kategoris.id')
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->groupBy('kategori_bagians.id', 'kategori_bagians.name')
          ->orderBy('total', 'desc')
          ->where('kategoris.id', 3)
          ->limit(1)
          ->get();

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

    public function backupRoleAdmin(Request $request)
    {
        /**
         * Row 1
         * data kasus terbaru 
         */
        
        $perkaras = Perkara::orderBy('created_at', 'desc')
          ->leftJoin('jenis_pidanas', 'jenis_pidanas.id', '=', 'perkaras.jenis_pidana')
          ->leftJoin('kategori_bagians', 'kategori_bagians.id', '=', 'perkaras.kategori_bagian_id')
          ->leftJoin('korbans', 'korbans.no_lp', '=', 'perkaras.no_lp')
          ->select([
            'perkaras.*',
            'jenis_pidanas.name as pidana',
            'kategori_bagians.name as satuan',
            'korbans.nama',
            'korbans.barang_bukti',
          ])
          ->limit(9)
          ->get();

        /** top kasus */
        $top_kasus = DB::table('perkaras')
          ->leftJoin('jenis_pidanas', 'jenis_pidanas.id', '=', 'perkaras.jenis_pidana')
          ->select('jenis_pidanas.name', DB::raw('count(perkaras.jenis_pidana) as total'))
          ->groupBy('jenis_pidanas.name')
          ->orderBy('total', 'desc')
          ->limit(3)
          ->get();

        $top_kasus_satker = Perkara::select('kategoris.id', 'kategoris.name', DB::raw('count(perkaras.kategori_id) as total'))
          ->leftJoin('kategoris', 'perkaras.kategori_id', '=', 'kategoris.id')
          ->groupBy('kategoris.id', 'kategoris.name')
          ->orderBy('total', 'desc')
          ->limit(3)
          ->get();

        $top_kasus_satker_bagian = DB::table('perkaras')
          ->leftJoin('kategori_bagians', 'perkaras.kategori_bagian_id', '=', 'kategori_bagians.id')
          ->select('kategori_bagians.name', DB::raw('count(perkaras.kategori_bagian_id) as total'))
          ->groupBy('kategori_bagians.name')
          ->orderBy('total', 'desc')
          ->limit(3)
          ->get();

        $top_kasus_satker_polda = Perkara::select('kategori_bagians.id', 'kategori_bagians.name', DB::raw('count(perkaras.kategori_id) as total'))
          ->join('kategori_bagians', 'perkaras.kategori_bagian_id', '=', 'kategori_bagians.id')
          ->join('kategoris', 'kategori_bagians.kategori_id', '=', 'kategoris.id')
          ->groupBy('kategori_bagians.id', 'kategori_bagians.name')
          ->orderBy('total', 'desc')
          ->where('kategoris.id', 1)
          ->limit(3)
          ->get();

        $top_kasus_satker_polres = Perkara::select('kategori_bagians.id', 'kategori_bagians.name', DB::raw('count(perkaras.kategori_id) as total'))
          ->join('kategori_bagians', 'perkaras.kategori_bagian_id', '=', 'kategori_bagians.id')
          ->join('kategoris', 'kategori_bagians.kategori_id', '=', 'kategoris.id')
          ->groupBy('kategori_bagians.id', 'kategori_bagians.name')
          ->orderBy('total', 'desc')
          ->where('kategoris.id', 2)
          ->limit(3)
          ->get();

        $top_kasus_satker_polsek = Perkara::select('kategori_bagians.id', 'kategori_bagians.name', DB::raw('count(perkaras.kategori_id) as total'))
          ->join('kategori_bagians', 'perkaras.kategori_bagian_id', '=', 'kategori_bagians.id')
          ->join('kategoris', 'kategori_bagians.kategori_id', '=', 'kategoris.id')
          ->groupBy('kategori_bagians.id', 'kategori_bagians.name')
          ->orderBy('total', 'desc')
          ->where('kategoris.id', 3)
          ->limit(3)
          ->get();

        /** total kasus */
        $count_kasus = Perkara::count();
        $count_kasus_belum = Perkara::where('status_id', '1')->count();
        $count_kasus_selesai = $count_kasus - $count_kasus_belum;
        /** hitung percentase */
        $percent_done = 0;
        $percent_progress = 0;
        if($count_kasus > 0){
          $percent_done = ($count_kasus_selesai/$count_kasus)*100;
          $percent_progress = ($count_kasus_belum/$count_kasus)*100;
        }
        /** total kasus this year */
        $count_kasus_this_y = Perkara::whereYear('date', date('Y'))->count();

        // diagram batang this year
        /** januari */
        $jan_f_diagram_ty = Perkara::whereMonth('date', '=', '01')
          ->whereYear('date', date('Y'))
          ->count();

        /** februari */
        $feb_f_diagram_ty = Perkara::whereMonth('date', '=', '02')
          ->whereYear('date', date('Y'))
          ->count();

        /** maret */
        $mar_f_diagram_ty = Perkara::whereMonth('date', '=', '03')
          ->whereYear('date', date('Y'))
          ->count();

        /** april */
        $apr_f_diagram_ty = Perkara::whereMonth('date', '=', '04')
          ->whereYear('date', date('Y'))
          ->count();

        /** mei */
        $mei_f_diagram_ty = Perkara::whereMonth('date', '=', '05')
          ->whereYear('date', date('Y'))
          ->count();

        /** juni */
        $jun_f_diagram_ty = Perkara::whereMonth('date', '=', '06')
          ->whereYear('date', date('Y'))
          ->count();

        /** juli */
        $jul_f_diagram_ty = Perkara::whereMonth('date', '=', '07')
          ->whereYear('date', date('Y'))
          ->count();

        /** agustus */
        $aug_f_diagram_ty = Perkara::whereMonth('date', '=', '08')
          ->whereYear('date', date('Y'))
          ->count();

        /** september */
        $sep_f_diagram_ty = Perkara::whereMonth('date', '=', '09')
          ->whereYear('date', date('Y'))
          ->count();

        /** oktober */
        $oct_f_diagram_ty = Perkara::whereMonth('date', '=', '10')
          ->whereYear('date', date('Y'))
          ->count();

        /** november */
        $nov_f_diagram_ty = Perkara::whereMonth('date', '=', '11')
          ->whereYear('date', date('Y'))
          ->count();

        /** desember */
        $des_f_diagram_ty = Perkara::whereMonth('date', '=', '12')
          ->whereYear('date', date('Y'))
          ->count();

        // data perkara sudah lewat 
        $count_kasus_lama = Perkara::where('date_no_lp', '<=', date('Y-m-d', strtotime('-6 months')))->where('status_id', 1)->count();

        return $datas;
    }

    public function backupRoleNotAdmin()
    {
        /** kebutuhan filter */
        $kategori_bagians = Akses::select('kategori_bagians.id', 'kategori_bagians.name')->leftJoin('kategori_bagians', 'kategori_bagians.id', '=', 'akses.sakter_id')
                ->where('akses.user_id', Auth::user()->id)
                ->get();

        /** data kasus terbaru */
        $perkaras = Perkara::orderBy('created_at', 'desc')
          ->leftJoin('jenis_pidanas', 'jenis_pidanas.id', '=', 'perkaras.jenis_pidana')
          ->leftJoin('kategori_bagians', 'kategori_bagians.id', '=', 'perkaras.kategori_bagian_id')
          ->leftJoin('korbans', 'korbans.no_lp', '=', 'perkaras.no_lp')
          ->select([
            'perkaras.*',
            'jenis_pidanas.name as pidana',
            'kategori_bagians.name as satuan',
            'korbans.nama',
            'korbans.barang_bukti',
          ])
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->limit(9)
          ->get();

        /** top kasus */
        $top_kasus = DB::table('perkaras')
          ->leftJoin('jenis_pidanas', 'jenis_pidanas.id', '=', 'perkaras.jenis_pidana')
          ->select('jenis_pidanas.name', DB::raw('count(perkaras.jenis_pidana) as total'))
          ->groupBy('jenis_pidanas.name')
          ->orderBy('total', 'desc')
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->limit(3)
          ->get();

        // supaya tidak error di hosting
        $top_kasus_satker = null;
        $top_kasus_satker_bagian = null;
        $top_kasus_satker_polda = null;
        $top_kasus_satker_polres = null;
        $top_kasus_satker_polsek = null;

        /** total kasus */
        $count_kasus = Perkara::where('perkaras.user_id', '=', Auth::user()->id)->count();
        $count_kasus_belum = Perkara::where('perkaras.user_id', '=', Auth::user()->id)->where('status_id', '1')->count();
        $count_kasus_selesai = $count_kasus - $count_kasus_belum;
        /** hitung percentase */
        if($count_kasus != 0){
          $percent_done = ($count_kasus_selesai/$count_kasus)*100;
          $percent_progress = ($count_kasus_belum/$count_kasus)*100;
        }else{
          $percent_done = 0;
          $percent_progress = 0;
        }
        /** total kasus this year */
        $count_kasus_this_y = Perkara::where('perkaras.user_id', '=', Auth::user()->id)->whereYear('date', date('Y'))->count();

        // diagram batang this year
        /** januari */
        $jan_f_diagram_ty = Perkara::whereMonth('date', '=', '01')
          ->where('perkaras.user_id', Auth::user()->id)
          ->whereYear('date', date('Y'))
          ->count();

        /** februari */
        $feb_f_diagram_ty = Perkara::whereMonth('date', '=', '02')
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->whereYear('date', date('Y'))
          ->count();

        /** maret */
        $mar_f_diagram_ty = Perkara::whereMonth('date', '=', '03')
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->whereYear('date', date('Y'))
          ->count();

        /** april */
        $apr_f_diagram_ty = Perkara::whereMonth('date', '=', '04')
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->whereYear('date', date('Y'))
          ->count();

        /** mei */
        $mei_f_diagram_ty = Perkara::whereMonth('date', '=', '05')
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->whereYear('date', date('Y'))
          ->count();

        /** juni */
        $jun_f_diagram_ty = Perkara::whereMonth('date', '=', '06')
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->whereYear('date', date('Y'))
          ->count();

        /** juli */
        $jul_f_diagram_ty = Perkara::whereMonth('date', '=', '07')
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->whereYear('date', date('Y'))
          ->count();

        /** agustus */
        $aug_f_diagram_ty = Perkara::whereMonth('date', '=', '08')
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->whereYear('date', date('Y'))
          ->count();

        /** september */
        $sep_f_diagram_ty = Perkara::whereMonth('date', '=', '09')
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->whereYear('date', date('Y'))
          ->count();

        /** oktober */
        $oct_f_diagram_ty = Perkara::whereMonth('date', '=', '10')
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->whereYear('date', date('Y'))
          ->count();

        /** november */
        $nov_f_diagram_ty = Perkara::whereMonth('date', '=', '11')
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->whereYear('date', date('Y'))
          ->count();

        /** desember */
        $des_f_diagram_ty = Perkara::whereMonth('date', '=', '12')
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->whereYear('date', date('Y'))
          ->count();

        // logs
        $logs = Log::select([
          'perkaras.id', 
          'perkaras.no_lp', 
          'logs.status',
          'logs.created_at',
          'users.name',
        ])->join('perkaras', 'logs.perkara_id', '=', 'perkaras.id')
          ->join('users', 'logs.user_id', '=', 'users.id')
          ->where('logs.user_id', '=', Auth::user()->id)
          ->orderBy('logs.created_at', 'desc')
          ->limit(25)
          ->get();

        foreach($logs as $key=>$log){
          $dataTime = Carbon::parse($log->created_at);
          $nowTime  = Carbon::now()->toDateTimeString();
          // for time
          $hours   =  $dataTime->diff($nowTime)->format('%H');
          $minutes =  $dataTime->diff($nowTime)->format('%I');
          // for day
          $age_of_data = \Carbon\Carbon::parse($log->created_at)->diff(\Carbon\Carbon::now())->format('%d');
          if($age_of_data == 0){
            // include data to collection
            if($hours == 0){
              $log->age_of_data   = $minutes." minutes ago";
            }else{
              $log->age_of_data   = $hours." hours ago";
            }
          }else{
            // include data to collection
            $log->age_of_data   = $age_of_data." days ago";
          }
        }

        // data perkara sudah lewat 
        $count_kasus_lama = Perkara::where('date_no_lp', '<=', date('Y-m-d', strtotime('-6 months')))->where('status_id', 1)->where('perkaras.user_id', '=', Auth::user()->id)->count();

        // data time for chart
    }
}
