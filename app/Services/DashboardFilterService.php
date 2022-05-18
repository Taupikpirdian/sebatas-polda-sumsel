<?php

namespace App\Services;

use App\Perkara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Constant;
use Carbon\Carbon;

class DashboardFilterService
{
    public function __construct()
    {
        $this->user = Auth::user();
        $this->year = date('Y');
    }

    public function roleAdmin(Request $request)
    {
        /** param */
        $satker_param       = $request->satker;
        $divisi_param       = $request->divisi;
        $jenis_kasus_param  = $request->jenis_kasus;
        $tahun_param        = $request->tahun;
        $bulan_param        = $request->bulan;

        /**
         * Row 3
         */

        $petas = Perkara::orderBy('created_at', 'desc')
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($divisi_param), function ($query) use ($divisi_param) {
            $query->where('divisi', $divisi_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date_no_lp', $tahun_param);
          })
          ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
            $query->whereMonth('date_no_lp', $bulan_param);
          })
          ->get();

        /**
         * Row 1
         * data kasus terbaru 
         */

        // total kasus
        $count_kasus_f_map = $petas->count();
        // kasus selesai
        $count_kasus_belum_f_map = $petas->where('status_id', '1')->count();
        // kasus belum selesai
        $count_kasus_selesai_f_map = $count_kasus_f_map - $count_kasus_belum_f_map;
        // persentase kasus
        if($count_kasus_f_map > 0){
          $percent_done_f_map = ($count_kasus_selesai_f_map/$count_kasus_f_map)*100;
        }else{
          $percent_done_f_map = 0;
        }

        /**
         * Row 2
         * RESIKO PENDUDUK TERKENA TINDAK PIDANA
         * RESIKO PENDUDUK TERKENA TINDAK PIDANA
         * PENYELESAIAN PERKARA
         */

        /**
         * Row 4
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
            ->when(!empty($satker_param), function ($query) use ($satker_param) {
              $query->where('kategori_bagian_id', $satker_param);
            })
            ->when(!empty($divisi_param), function ($query) use ($divisi_param) {
              $query->where('divisi', $divisi_param);
            })
            ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
              $query->where('jenis_pidana', $jenis_kasus_param);
            })
            ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
              $query->whereYear('date_no_lp', $tahun_param);
            })
            ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
              $query->whereMonth('date_no_lp', $bulan_param);
            })
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
            ->when(!empty($satker_param), function ($query) use ($satker_param) {
              $query->where('kategori_bagian_id', $satker_param);
            })
            ->when(!empty($divisi_param), function ($query) use ($divisi_param) {
              $query->where('divisi', $divisi_param);
            })
            ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
              $query->where('jenis_pidana', $jenis_kasus_param);
            })
            ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
              $query->whereYear('date_no_lp', $tahun_param);
            })
            ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
              $query->whereMonth('date_no_lp', $bulan_param);
            })
            ->groupby('month')
            ->get();

        foreach($dataMonthDones as $done){
            $month = $done->month - 1;
            $arrMonthDone[$done->month][1] = $done->data;
        }

        /** top kasus Filter*/
        $top_kasus_filter = DB::table('perkaras')
          ->leftJoin('jenis_pidanas', 'jenis_pidanas.id', '=', 'perkaras.jenis_pidana')
          ->select('jenis_pidanas.name', DB::raw('count(perkaras.jenis_pidana) as total'))
          // ->whereTime('time', '>=', \Carbon\Carbon::parse('21:01')) // ini entah apa
          // ->whereTime('time', '<=', \Carbon\Carbon::parse('23:59')) // ini entah apa
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($divisi_param), function ($query) use ($divisi_param) {
            $query->where('divisi', $divisi_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date_no_lp', $tahun_param);
          })
          ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
            $query->whereMonth('date_no_lp', $bulan_param);
          })
          ->groupBy('jenis_pidanas.name')
          ->orderBy('total', 'desc')
          ->limit(3)
          ->get();

        $top_kasus_satker_polda_filter = Perkara::select('kategori_bagians.id', 'kategori_bagians.name', DB::raw('count(perkaras.kategori_id) as total'))
          ->join('kategori_bagians', 'perkaras.kategori_bagian_id', '=', 'kategori_bagians.id')
          ->join('kategoris', 'kategori_bagians.kategori_id', '=', 'kategoris.id')
          ->groupBy('kategori_bagians.id', 'kategori_bagians.name')
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($divisi_param), function ($query) use ($divisi_param) {
            $query->where('divisi', $divisi_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date_no_lp', $tahun_param);
          })
          ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
            $query->whereMonth('date_no_lp', $bulan_param);
          })
          ->orderBy('total', 'desc')
          ->where('kategoris.id', 1)
          ->limit(1)
          ->get();

        $top_kasus_satker_polres_filter = Perkara::select('kategori_bagians.id', 'kategori_bagians.name', DB::raw('count(perkaras.kategori_id) as total'))
          ->join('kategori_bagians', 'perkaras.kategori_bagian_id', '=', 'kategori_bagians.id')
          ->join('kategoris', 'kategori_bagians.kategori_id', '=', 'kategoris.id')
          ->groupBy('kategori_bagians.id', 'kategori_bagians.name')
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($divisi_param), function ($query) use ($divisi_param) {
            $query->where('divisi', $divisi_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date_no_lp', $tahun_param);
          })
          ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
            $query->whereMonth('date_no_lp', $bulan_param);
          })
          ->orderBy('total', 'desc')
          ->where('kategoris.id', 2)
          ->limit(1)
          ->get();

        $top_kasus_satker_polsek_filter = Perkara::select('kategori_bagians.id', 'kategori_bagians.name', DB::raw('count(perkaras.kategori_id) as total'))
          ->join('kategori_bagians', 'perkaras.kategori_bagian_id', '=', 'kategori_bagians.id')
          ->join('kategoris', 'kategori_bagians.kategori_id', '=', 'kategoris.id')
          ->groupBy('kategori_bagians.id', 'kategori_bagians.name')
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($divisi_param), function ($query) use ($divisi_param) {
            $query->where('divisi', $divisi_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date_no_lp', $tahun_param);
          })
          ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
            $query->whereMonth('date_no_lp', $bulan_param);
          })
          ->orderBy('total', 'desc')
          ->where('kategoris.id', 3)
          ->limit(1)
          ->get();

        $datas = [
            'satker_param'                    => $satker_param,
            'jenis_kasus_param'               => $jenis_kasus_param,
            'tahun_param'                     => $tahun_param,
            'bulan_param'                     => $bulan_param,
            'divisi_param'                    => $divisi_param,
            'petas'                           => $petas,
            'count_kasus_f_map'               => $count_kasus_f_map,
            'count_kasus_belum_f_map'         => $count_kasus_belum_f_map,
            'count_kasus_selesai_f_map'       => $count_kasus_selesai_f_map,
            'percent_done_f_map'              => $percent_done_f_map,
            'top_kasus_filter'                => $top_kasus_filter,
            'top_kasus_satker_polda_filter'   => $top_kasus_satker_polda_filter,
            'top_kasus_satker_polres_filter'  => $top_kasus_satker_polres_filter,
            'top_kasus_satker_polsek_filter'  => $top_kasus_satker_polsek_filter,
            'arrMonthProgress'                => $arrMonthProgress,
            'arrMonthDone'                    => $arrMonthDone
        ];

        return $datas;
    }

    public function roleNotAdmin(Request $request)
    {
        /** param */
        $satker_param       = $request->satker;
        $divisi_param       = $request->divisi;
        $jenis_kasus_param  = $request->jenis_kasus;
        $tahun_param        = $request->tahun;
        $bulan_param        = $request->bulan;
        /**
         * Row 3
         */

        $petas = Perkara::orderBy('created_at', 'desc')
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
          $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($divisi_param), function ($query) use ($divisi_param) {
            $query->where('divisi', $divisi_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date_no_lp', $tahun_param);
          })
          ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
            $query->whereMonth('date_no_lp', $bulan_param);
          })
          ->where('perkaras.user_id', Auth::user()->id)
          ->get();

        /**
         * Row 1
         * data kasus terbaru 
         */

        // total kasus
        $count_kasus_f_map = $petas->count();

        // kasus selesai
        $count_kasus_belum_f_map = $petas->where('status_id', '1')->count();
        // kasus belum selesai
        $count_kasus_selesai_f_map = $count_kasus_f_map - $count_kasus_belum_f_map;
        // persentase kasus
        if($count_kasus_f_map > 0){
          $percent_done_f_map = ($count_kasus_selesai_f_map/$count_kasus_f_map)*100;
        }else{
          $percent_done_f_map = 0;
        }

        /**
         * Row 2
         * RESIKO PENDUDUK TERKENA TINDAK PIDANA
         * RESIKO PENDUDUK TERKENA TINDAK PIDANA
         * PENYELESAIAN PERKARA
         */

        /**
         * Row 4
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
            ->where('perkaras.user_id', Auth::user()->id)
            ->when(!empty($satker_param), function ($query) use ($satker_param) {
              $query->where('kategori_bagian_id', $satker_param);
            })
            ->when(!empty($divisi_param), function ($query) use ($divisi_param) {
              $query->where('divisi', $divisi_param);
            })
            ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
              $query->where('jenis_pidana', $jenis_kasus_param);
            })
            ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
              $query->whereYear('date_no_lp', $tahun_param);
            })
            ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
              $query->whereMonth('date_no_lp', $bulan_param);
            })
            ->groupby('month')
            ->get();

        foreach($dataMonthProgress as $progres){
            $month = $progres->month - 1;
            $arrMonthProgress[$progres->month][1] = $progres->data;
        }
        // kelompokan data selesai berdasarkan bulan
        $dataMonthDones = Perkara::select(DB::raw('count(id) as `data`'),
            DB::raw('MONTH(date_no_lp) month'))
            ->where('status_id', '!=', Constant::PROGRESS)
            ->where('perkaras.user_id', Auth::user()->id)
            ->when(!empty($satker_param), function ($query) use ($satker_param) {
              $query->where('kategori_bagian_id', $satker_param);
            })
            ->when(!empty($divisi_param), function ($query) use ($divisi_param) {
              $query->where('divisi', $divisi_param);
            })
            ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
              $query->where('jenis_pidana', $jenis_kasus_param);
            })
            ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
              $query->whereYear('date_no_lp', $tahun_param);
            })
            ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
              $query->whereMonth('date_no_lp', $bulan_param);
            })
            ->groupby('month')
            ->get();

        foreach($dataMonthDones as $done){
            $month = $done->month - 1;
            $arrMonthDone[$done->month][1] = $done->data;
        }

        /** top kasus Filter*/
        $top_kasus_filter = DB::table('perkaras')
          ->leftJoin('jenis_pidanas', 'jenis_pidanas.id', '=', 'perkaras.jenis_pidana')
          ->select('jenis_pidanas.name', DB::raw('count(perkaras.jenis_pidana) as total'))
          // ->whereTime('time', '>=', \Carbon\Carbon::parse('21:01')) // ini entah apa
          // ->whereTime('time', '<=', \Carbon\Carbon::parse('23:59')) // ini entah apa
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($divisi_param), function ($query) use ($divisi_param) {
            $query->where('divisi', $divisi_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date_no_lp', $tahun_param);
          })
          ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
            $query->whereMonth('date_no_lp', $bulan_param);
          })
          ->where('perkaras.user_id', Auth::user()->id)
          ->groupBy('jenis_pidanas.name')
          ->orderBy('total', 'desc')
          ->limit(3)
          ->get();

        $top_kasus_satker_polda_filter = Perkara::select('kategori_bagians.id', 'kategori_bagians.name', DB::raw('count(perkaras.kategori_id) as total'))
          ->join('kategori_bagians', 'perkaras.kategori_bagian_id', '=', 'kategori_bagians.id')
          ->join('kategoris', 'kategori_bagians.kategori_id', '=', 'kategoris.id')
          ->groupBy('kategori_bagians.id', 'kategori_bagians.name')
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($divisi_param), function ($query) use ($divisi_param) {
            $query->where('divisi', $divisi_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date_no_lp', $tahun_param);
          })
          ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
            $query->whereMonth('date_no_lp', $bulan_param);
          })
          ->where('perkaras.user_id', Auth::user()->id)
          ->orderBy('total', 'desc')
          ->where('kategoris.id', 1)
          ->limit(1)
          ->get();

        $top_kasus_satker_polres_filter = Perkara::select('kategori_bagians.id', 'kategori_bagians.name', DB::raw('count(perkaras.kategori_id) as total'))
          ->join('kategori_bagians', 'perkaras.kategori_bagian_id', '=', 'kategori_bagians.id')
          ->join('kategoris', 'kategori_bagians.kategori_id', '=', 'kategoris.id')
          ->groupBy('kategori_bagians.id', 'kategori_bagians.name')
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($divisi_param), function ($query) use ($divisi_param) {
            $query->where('divisi', $divisi_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date_no_lp', $tahun_param);
          })
          ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
            $query->whereMonth('date_no_lp', $bulan_param);
          })
          ->where('perkaras.user_id', Auth::user()->id)
          ->orderBy('total', 'desc')
          ->where('kategoris.id', 2)
          ->limit(1)
          ->get();

        $top_kasus_satker_polsek_filter = Perkara::select('kategori_bagians.id', 'kategori_bagians.name', DB::raw('count(perkaras.kategori_id) as total'))
          ->join('kategori_bagians', 'perkaras.kategori_bagian_id', '=', 'kategori_bagians.id')
          ->join('kategoris', 'kategori_bagians.kategori_id', '=', 'kategoris.id')
          ->groupBy('kategori_bagians.id', 'kategori_bagians.name')
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($divisi_param), function ($query) use ($divisi_param) {
            $query->where('divisi', $divisi_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date_no_lp', $tahun_param);
          })
          ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
            $query->whereMonth('date_no_lp', $bulan_param);
          })
          ->where('perkaras.user_id', Auth::user()->id)
          ->orderBy('total', 'desc')
          ->where('kategoris.id', 3)
          ->limit(1)
          ->get();

        $datas = [
            'satker_param'                    => $satker_param,
            'jenis_kasus_param'               => $jenis_kasus_param,
            'tahun_param'                     => $tahun_param,
            'bulan_param'                     => $bulan_param,
            'divisi_param'                    => $divisi_param,
            'petas'                           => $petas,
            'count_kasus_f_map'               => $count_kasus_f_map,
            'count_kasus_belum_f_map'         => $count_kasus_belum_f_map,
            'count_kasus_selesai_f_map'       => $count_kasus_selesai_f_map,
            'percent_done_f_map'              => $percent_done_f_map,
            'top_kasus_filter'                => $top_kasus_filter,
            'top_kasus_satker_polda_filter'   => $top_kasus_satker_polda_filter,
            'top_kasus_satker_polres_filter'  => $top_kasus_satker_polres_filter,
            'top_kasus_satker_polsek_filter'  => $top_kasus_satker_polsek_filter,
            'arrMonthProgress'                => $arrMonthProgress,
            'arrMonthDone'                    => $arrMonthDone
        ];

        return $datas;
    }

    public function backupRoleAdmin(Request $request)
    {
        // Line 1
        /** total kasus */
        $count_kasus = Perkara::count();
        // data perkara sudah lewat 
        $count_kasus_lama = Perkara::where('date_no_lp', '<=', date('Y-m-d', strtotime('-6 months')))->where('status_id', 1)->count();
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
        /** progress perkara */
        $count_kasus_belum = Perkara::where('status_id', '1')->count();
        $count_kasus_selesai = $count_kasus - $count_kasus_belum;
        /** hitung percentase */
        $percent_done     = 0;
        $percent_progress = 0;
        if($count_kasus > 0){
          $percent_done = ($count_kasus_selesai/$count_kasus)*100;
          $percent_progress = ($count_kasus_belum/$count_kasus)*100;
        }

        // Line 2
        // logs
        $logs = Log::select([
          'perkaras.id', 
          'perkaras.no_lp', 
          'logs.status',
          'logs.created_at',
          'users.name',
        ])->join('perkaras', 'logs.perkara_id', '=', 'perkaras.id')
          ->join('users', 'logs.user_id', '=', 'users.id')
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
          ->limit(4)
          ->get();

        // Line 3
        /** top kasus */
        $top_kasus = DB::table('perkaras')
          ->leftJoin('jenis_pidanas', 'jenis_pidanas.id', '=', 'perkaras.jenis_pidana')
          ->select('jenis_pidanas.name', DB::raw('count(perkaras.jenis_pidana) as total'))
          ->groupBy('jenis_pidanas.name')
          ->orderBy('total', 'desc')
          ->limit(3)
          ->get();

        $top_kasus_satker = DB::table('perkaras')
          ->leftJoin('kategoris', 'perkaras.kategori_id', '=', 'kategoris.id')
          ->select('kategoris.name', DB::raw('count(perkaras.kategori_id) as total'))
          ->groupBy('kategoris.name')
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

        // Line 4
        /** kebutuhan filter */
        $kategori_bagians = KategoriBagian::orderBy('name', 'asc')->get();
        $jenispidanas = JenisPidana::orderBy('name', 'asc')->get();

        // Line 5
        /** untuk label */
        $satker_fr_param = KategoriBagian::where('id', $satker_param)->first();
        $jenis_pidana_fr_param = JenisPidana::where('id', $jenis_kasus_param)->first();

        // Line 6
        // Rumus
        // Persentase perkembangan jumlah kejahatan
        // jumlah kejahatan tahun ini
        $x = Perkara::when(!empty($tahun_param), function ($query) use ($tahun_param) {
          $query->whereYear('date', $tahun_param);
        })->when(!empty($bulan_param), function ($query) use ($bulan_param) {
          $query->whereMonth('date', $bulan_param);
        })->count();

        $tahun_param_sebelum = $tahun_param - 1;
        // jumlah kejahatan tahun sebelumnya
        $y = Perkara::when(!empty($tahun_param_sebelum), function ($query) use ($tahun_param_sebelum) {
          $query->whereYear('date', $tahun_param_sebelum);
        })->when(!empty($bulan_param), function ($query) use ($bulan_param) {
          $query->whereMonth('date', $bulan_param);
        })->count();

        $persentase_perkembangan_jumlah_kejahatan = 0;
        if($y > 0){
          $persentase_perkembangan_jumlah_kejahatan = (($x-$y)/$y)*100;
        }

        // Perhitungan persentase penyelesaian kejahatan
        $count_kasus_f_persentase  = Perkara::whereYear('date', $tahun_param)
                                      ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
                                        $query->whereMonth('date', $bulan_param);
                                      })->count();

        $count_kasus_selesai_f_persentase = Perkara::where('status_id', '!=', '1')->count();
        $persentase_penyelesaian_perkara  = 0;
        if($count_kasus_selesai_f_persentase > 0){
          $persentase_penyelesaian_perkara  = ($count_kasus_selesai_f_persentase*100)/$count_kasus_f_persentase;
        }

        // Selang waktu terjadi kejahatan
        $bulat_selang_waktu = 0;
        if($count_kasus_f_persentase > 0){
          $selang_waktu       = (365*24*60*60)/$count_kasus_f_persentase;
          $convert_menit      = $selang_waktu/60;
          $bulat_selang_waktu = ceil($convert_menit);
        }

        // perbandingan jumlah polisi dengan jumlah penduduk
        // get data polisi
        $data_master = DataMaster::first();
        // get data penduduk
        // jika param satker dipilih
        $data_penduduk = JumlahPenduduk::where('kategori_bagian_id', $satker_param)->first();
        if($data_penduduk != null){
          $jumlah_penduduk  = $data_penduduk->pria + $data_penduduk->wanita;
        }else{
          $jumlah_pria      = JumlahPenduduk::sum('pria');
          $jumlah_wanita    = JumlahPenduduk::sum('wanita');
          $jumlah_penduduk  = $jumlah_pria + $jumlah_wanita;
        }

        $perbandingan_jumlah_polisi_dgn_penduduk = 0;
        if($data_master){
          $perbandingan_jumlah_polisi_dgn_penduduk = ceil($jumlah_penduduk/$data_master->jumlah_polisi);
        }

        // resiko penduduk terkena perkara
        $resiko_terkena_pidana = 0;
        if($jumlah_penduduk > 0){
          $resiko_terkena_pidana = ($count_kasus_f_persentase*100000)/$jumlah_penduduk;
        }

        // Line 7
        /** top kasus Filter*/
        $top_kasus_filter = DB::table('perkaras')
        ->leftJoin('jenis_pidanas', 'jenis_pidanas.id', '=', 'perkaras.jenis_pidana')
        ->select('jenis_pidanas.name', DB::raw('count(perkaras.jenis_pidana) as total'))
        ->whereTime('time', '>=', \Carbon\Carbon::parse('21:01'))
        ->whereTime('time', '<=', \Carbon\Carbon::parse('23:59'))
        ->when(!empty($satker_param), function ($query) use ($satker_param) {
          $query->where('kategori_bagian_id', $satker_param);
        })
        ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
          $query->where('jenis_pidana', $jenis_kasus_param);
        })
        ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
          $query->whereYear('date', $tahun_param);
        })
        ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
          $query->whereMonth('date', $bulan_param);
        })
        ->groupBy('jenis_pidanas.name')
        ->orderBy('total', 'desc')
        ->limit(3)
        ->get();

        $top_kasus_satker_filter = DB::table('perkaras')
          ->leftJoin('kategoris', 'perkaras.kategori_id', '=', 'kategoris.id')
          ->select('kategoris.name', DB::raw('count(perkaras.kategori_id) as total'))
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })
          ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
            $query->whereMonth('date', $bulan_param);
          })
          ->groupBy('kategoris.name')
          ->orderBy('total', 'desc')
          ->limit(3)
          ->get();

        $top_kasus_satker_bagian_filter = DB::table('perkaras')
          ->leftJoin('kategori_bagians', 'perkaras.kategori_bagian_id', '=', 'kategori_bagians.id')
          ->select('kategori_bagians.name', DB::raw('count(perkaras.kategori_bagian_id) as total'))
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })
          ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
            $query->whereMonth('date', $bulan_param);
          })
          ->groupBy('kategori_bagians.name')
          ->orderBy('total', 'desc')
          ->limit(3)
          ->get();

        $top_kasus_satker_polda_filter = Perkara::select('kategori_bagians.id', 'kategori_bagians.name', DB::raw('count(perkaras.kategori_id) as total'))
          ->join('kategori_bagians', 'perkaras.kategori_bagian_id', '=', 'kategori_bagians.id')
          ->join('kategoris', 'kategori_bagians.kategori_id', '=', 'kategoris.id')
          ->groupBy('kategori_bagians.id', 'kategori_bagians.name')
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })
          ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
            $query->whereMonth('date', $bulan_param);
          })
          ->orderBy('total', 'desc')
          ->where('kategoris.id', 1)
          ->limit(3)
          ->get();

        $top_kasus_satker_polres_filter = Perkara::select('kategori_bagians.id', 'kategori_bagians.name', DB::raw('count(perkaras.kategori_id) as total'))
          ->join('kategori_bagians', 'perkaras.kategori_bagian_id', '=', 'kategori_bagians.id')
          ->join('kategoris', 'kategori_bagians.kategori_id', '=', 'kategoris.id')
          ->groupBy('kategori_bagians.id', 'kategori_bagians.name')
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })
          ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
            $query->whereMonth('date', $bulan_param);
          })
          ->orderBy('total', 'desc')
          ->where('kategoris.id', 2)
          ->limit(3)
          ->get();

        $top_kasus_satker_polsek_filter = Perkara::select('kategori_bagians.id', 'kategori_bagians.name', DB::raw('count(perkaras.kategori_id) as total'))
          ->join('kategori_bagians', 'perkaras.kategori_bagian_id', '=', 'kategori_bagians.id')
          ->join('kategoris', 'kategori_bagians.kategori_id', '=', 'kategoris.id')
          ->groupBy('kategori_bagians.id', 'kategori_bagians.name')
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })
          ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
            $query->whereMonth('date', $bulan_param);
          })
          ->orderBy('total', 'desc')
          ->where('kategoris.id', 3)
          ->limit(3)
          ->get();

        // Line 8
        // filter satker dan jenis pidana
        $petas = Perkara::orderBy('created_at', 'desc')
        ->when(!empty($satker_param), function ($query) use ($satker_param) {
          $query->where('kategori_bagian_id', $satker_param);
        })
        ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
          $query->where('jenis_pidana', $jenis_kasus_param);
        })
        ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
          $query->whereYear('date', $tahun_param);
        })
        ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
          $query->whereMonth('date', $bulan_param);
        })
        ->get();

        // total kasus
        $count_kasus_f_map = $petas->count();
        // kasus selesai
        $count_kasus_belum_f_map = $petas->where('status_id', '1')->count();
        // kasus belum selesai
        $count_kasus_selesai_f_map = $count_kasus_f_map - $count_kasus_belum_f_map;
        // persentase kasus
        if($count_kasus_f_map > 0){
          $percent_done_f_map = ($count_kasus_selesai_f_map/$count_kasus_f_map)*100;
        }else{
          $percent_done_f_map = 0;
        }

        // Line 9
        // diagram barang
        /** januari */
        $jan_f_diagram = Perkara::whereMonth('date', '=', '01')
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })->get();
        /** count */
        $jan_f_diagram_done     = $jan_f_diagram->where('status_id', '!=', 1)->count();
        $jan_f_diagram_progres  = $jan_f_diagram->where('status_id', 1)->count();

        /** februari */
        $feb_f_diagram = Perkara::whereMonth('date', '=', '02')
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })->get();
        /** count */
        $feb_f_diagram_done     = $feb_f_diagram->where('status_id', '!=', 1)->count();
        $feb_f_diagram_progres  = $feb_f_diagram->where('status_id', 1)->count();

        /** maret */
        $mar_f_diagram = Perkara::whereMonth('date', '=', '03')
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })->get();
        /** count */
        $mar_f_diagram_done     = $mar_f_diagram->where('status_id', '!=', 1)->count();
        $mar_f_diagram_progres  = $mar_f_diagram->where('status_id', 1)->count();

        /** april */
        $apr_f_diagram = Perkara::whereMonth('date', '=', '04')
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })->get();
        /** count */
        $apr_f_diagram_done     = $apr_f_diagram->where('status_id', '!=', 1)->count();
        $apr_f_diagram_progres  = $apr_f_diagram->where('status_id', 1)->count();

        /** mei */
        $mei_f_diagram = Perkara::whereMonth('date', '=', '05')
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })->get();
        /** count */
        $mei_f_diagram_done     = $mei_f_diagram->where('status_id', '!=', 1)->count();
        $mei_f_diagram_progres  = $mei_f_diagram->where('status_id', 1)->count();

        /** juni */
        $jun_f_diagram = Perkara::whereMonth('date', '=', '06')
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })->get();
        /** count */
        $jun_f_diagram_done     = $jun_f_diagram->where('status_id', '!=', 1)->count();
        $jun_f_diagram_progres  = $jun_f_diagram->where('status_id', 1)->count();

        /** juli */
        $jul_f_diagram = Perkara::whereMonth('date', '=', '07')
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })->get();
        /** count */
        $jul_f_diagram_done     = $jul_f_diagram->where('status_id', '!=', 1)->count();
        $jul_f_diagram_progres  = $jul_f_diagram->where('status_id', 1)->count();

        /** agustus */
        $aug_f_diagram = Perkara::whereMonth('date', '=', '08')
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })->get();
        /** count */
        $aug_f_diagram_done     = $aug_f_diagram->where('status_id', '!=', 1)->count();
        $aug_f_diagram_progres  = $aug_f_diagram->where('status_id', 1)->count();

        /** september */
        $sep_f_diagram = Perkara::whereMonth('date', '=', '09')
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })->get();
        /** count */
        $sep_f_diagram_done     = $sep_f_diagram->where('status_id', '!=', 1)->count();
        $sep_f_diagram_progres  = $sep_f_diagram->where('status_id', 1)->count();

        /** oktober */
        $oct_f_diagram = Perkara::whereMonth('date', '=', '10')
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })->get();
        /** count */
        $oct_f_diagram_done     = $oct_f_diagram->where('status_id', '!=', 1)->count();
        $oct_f_diagram_progres  = $oct_f_diagram->where('status_id', 1)->count();

        /** november */
        $nov_f_diagram = Perkara::whereMonth('date', '=', '11')
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })->get();
        /** count */
        $nov_f_diagram_done     = $nov_f_diagram->where('status_id', '!=', 1)->count();
        $nov_f_diagram_progres  = $nov_f_diagram->where('status_id', 1)->count();

        /** desember */
        $des_f_diagram = Perkara::whereMonth('date', '=', '12')
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })->get();
        /** count */
        $des_f_diagram_done     = $des_f_diagram->where('status_id', '!=', 1)->count();
        $des_f_diagram_progres  = $des_f_diagram->where('status_id', 1)->count();

        // Line 9
        // data time for chart
        $time_session_1 = Perkara::whereTime('time', '>=', \Carbon\Carbon::parse('00:00'))
          ->whereTime('time', '<=', \Carbon\Carbon::parse('03:00'))
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })
          ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
            $query->whereMonth('date', $bulan_param);
          })
          ->count();

        $time_session_2 = Perkara::whereTime('time', '>=', \Carbon\Carbon::parse('03:01'))
          ->whereTime('time', '<=', \Carbon\Carbon::parse('06:00'))
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })
          ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
            $query->whereMonth('date', $bulan_param);
          })
          ->count();

        $time_session_3 = Perkara::whereTime('time', '>=', \Carbon\Carbon::parse('06:01'))
          ->whereTime('time', '<=', \Carbon\Carbon::parse('09:00'))
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })
          ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
            $query->whereMonth('date', $bulan_param);
          })
          ->count();

        $time_session_4 = Perkara::whereTime('time', '>=', \Carbon\Carbon::parse('09:01'))
          ->whereTime('time', '<=', \Carbon\Carbon::parse('12:00'))
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })
          ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
            $query->whereMonth('date', $bulan_param);
          })
          ->count();

        $time_session_5 = Perkara::whereTime('time', '>=', \Carbon\Carbon::parse('12:01'))
          ->whereTime('time', '<=', \Carbon\Carbon::parse('15:00'))
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })
          ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
            $query->whereMonth('date', $bulan_param);
          })
          ->count();

        $time_session_6 = Perkara::whereTime('time', '>=', \Carbon\Carbon::parse('15:01'))
          ->whereTime('time', '<=', \Carbon\Carbon::parse('18:00'))
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })
          ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
            $query->whereMonth('date', $bulan_param);
          })
          ->count();

        $time_session_7 = Perkara::whereTime('time', '>=', \Carbon\Carbon::parse('18:01'))
          ->whereTime('time', '<=', \Carbon\Carbon::parse('21:00'))
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })
          ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
            $query->whereMonth('date', $bulan_param);
          })
          ->count();

        $time_session_8 = Perkara::whereTime('time', '>=', \Carbon\Carbon::parse('21:01'))
          ->whereTime('time', '<=', \Carbon\Carbon::parse('23:59'))
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })
          ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
            $query->whereMonth('date', $bulan_param);
          })
          ->count();
        
        // array data time
        $data_time = [
          $time_session_1,
          $time_session_2,
          $time_session_3,
          $time_session_4,
          $time_session_5,
          $time_session_6,
          $time_session_7,
          $time_session_8,
        ];

        $min = min($data_time); // data maksimal chart
        $max = max($data_time); // data min chart
        $range = 100; // data range chart
    }

    public function backupRoleNotAdmin(Request $request)
    {
        // Line 1
        /** total kasus */
        $count_kasus = Perkara::where('perkaras.user_id', '=', Auth::user()->id)->count();
        // data perkara sudah lewat 
        $count_kasus_lama = Perkara::where('date_no_lp', '<=', date('Y-m-d', strtotime('-6 months')))->where('status_id', 1)->where('perkaras.user_id', '=', Auth::user()->id)->count();
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
          
        /** progress perkara */
        $count_kasus_belum = Perkara::where('perkaras.user_id', '=', Auth::user()->id)->where('status_id', '1')->count();
        $count_kasus_selesai = $count_kasus - $count_kasus_belum;
        /** hitung percentase */
        if($count_kasus != 0){
          /** hitung percentase */
          $percent_done     = ($count_kasus_selesai/$count_kasus)*100;
          $percent_progress = ($count_kasus_belum/$count_kasus)*100;
        }else{
          $percent_done     = 0;
          $percent_progress = 0;
        }

        // Line 2
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
        ->limit(4)
        ->get();

        // Line 3
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
     
        // Line 4
        /** kebutuhan filter */
        $kategori_bagians = Akses::select('kategori_bagians.id', 'kategori_bagians.name')
          ->leftJoin('kategori_bagians', 'kategori_bagians.id', '=', 'akses.sakter_id')
          ->where('akses.user_id', Auth::user()->id)
          ->get();
        $jenispidanas = JenisPidana::orderBy('name', 'asc')->get();

        // Line 5
        /** untuk label */
        $satker_fr_param = KategoriBagian::where('id', $satker_param)->first();
        $jenis_pidana_fr_param = JenisPidana::where('id', $jenis_kasus_param)->first();

        // Line 6
        // Rumus
        // Persentase perkembangan jumlah kejahatan
        // jumlah kejahatan tahun ini
        $x = Perkara::when(!empty($tahun_param), function ($query) use ($tahun_param) {
          $query->whereYear('date', $tahun_param);
        })->where('perkaras.user_id', '=', Auth::user()->id)->count();

        $tahun_param_sebelum = $tahun_param - 1;
        // jumlah kejahatan tahun sebelumnya
        $y = Perkara::when(!empty($tahun_param_sebelum), function ($query) use ($tahun_param_sebelum) {
          $query->whereYear('date', $tahun_param_sebelum);
        })->where('perkaras.user_id', '=', Auth::user()->id)->count();

        $persentase_perkembangan_jumlah_kejahatan = (($x-$y)/$y)*100;

        // Perhitungan persentase penyelesaian kejahatan
        $count_kasus_f_persentase         = Perkara::whereYear('date', $tahun_param)->where('perkaras.user_id', '=', Auth::user()->id)->count();
        $count_kasus_selesai_f_persentase = Perkara::where('status_id', '!=', '1')->where('perkaras.user_id', '=', Auth::user()->id)->count();
        $persentase_penyelesaian_perkara  = ($count_kasus_selesai_f_persentase*100)/$count_kasus_f_persentase;

        // Selang waktu terjadi kejahatan
        $selang_waktu       = (365*24*60*60)/$count_kasus_f_persentase;
        $convert_menit      = $selang_waktu/60;
        $bulat_selang_waktu = ceil($convert_menit);

        // perbandingan jumlah polisi dengan jumlah penduduk
        // get data polisi
        $data_master = DataMaster::first();
        // get data penduduk
        // jika param satker dipilih
        $akses_satker = Akses::select(['akses.sakter_id'])->where('akses.user_id', '=', Auth::user()->id)->first();
        $satker_induk = TurunanSatuan::select(['turunan_satuans.satker_id'])->where('satker_turunan_id', $akses_satker->sakter_id)->first();
        
        if($satker_induk){ // jika polda, tidak ada data turunan satuan
          $data_penduduk = JumlahPenduduk::where('kategori_bagian_id', $satker_induk->satker_id)->first();
        }else{
          $data_penduduk = null;
        }

        if($data_penduduk != null){
          $jumlah_penduduk  = $data_penduduk->pria + $data_penduduk->wanita;
        }else{
          $jumlah_pria      = JumlahPenduduk::sum('pria');
          $jumlah_wanita    = JumlahPenduduk::sum('wanita');
          $jumlah_penduduk  = $jumlah_pria + $jumlah_wanita;
        }

        $perbandingan_jumlah_polisi_dgn_penduduk = ceil($data_master->jumlah_penduduk/$data_master->jumlah_polisi);

        // resiko penduduk terkena perkara
        $resiko_terkena_pidana = ($count_kasus_f_persentase*100000)/$data_master->jumlah_penduduk;

        // Line 7
        /** top kasus Filter*/
        $top_kasus_filter = DB::table('perkaras')
          ->leftJoin('jenis_pidanas', 'jenis_pidanas.id', '=', 'perkaras.jenis_pidana')
          ->select('jenis_pidanas.name', DB::raw('count(perkaras.jenis_pidana) as total'))
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })
          ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
            $query->whereMonth('date', $bulan_param);
          })
          ->groupBy('jenis_pidanas.name')
          ->orderBy('total', 'desc')
          ->limit(3)
          ->get();

        // supaya tidak error di hosting
        $top_kasus_satker_filter = null;
        $top_kasus_satker_bagian_filter = null;
        $top_kasus_satker_polda_filter = null;
        $top_kasus_satker_polres_filter = null;
        $top_kasus_satker_polsek_filter = null;

        // Line 8
        // filter satker dan jenis pidana
        $petas = Perkara::orderBy('created_at', 'desc')
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })
          ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
            $query->whereMonth('date', $bulan_param);
          })
          ->get();

        // total kasus
        $count_kasus_f_map = $petas->count();
        // kasus selesai
        $count_kasus_belum_f_map = $petas->where('status_id', '1')->count();
        // kasus belum selesai
        $count_kasus_selesai_f_map = $count_kasus_f_map - $count_kasus_belum_f_map;
        // persentase kasus
        if($count_kasus_f_map > 0){
          $percent_done_f_map = ($count_kasus_selesai_f_map/$count_kasus_f_map)*100;
        }else{
          $percent_done_f_map = 0;
        }

        // Line 9
        // diagram batang
        /** januari */
        $jan_f_diagram = Perkara::whereMonth('date', '=', '01')
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })->get();
        /** count */
        $jan_f_diagram_done     = $jan_f_diagram->where('status_id', '!=', 1)->count();
        $jan_f_diagram_progres  = $jan_f_diagram->where('status_id', 1)->count();

        /** februari */
        $feb_f_diagram = Perkara::whereMonth('date', '=', '02')
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })->get();
        /** count */
        $feb_f_diagram_done     = $feb_f_diagram->where('status_id', '!=', 1)->count();
        $feb_f_diagram_progres  = $feb_f_diagram->where('status_id', 1)->count();

        /** maret */
        $mar_f_diagram = Perkara::whereMonth('date', '=', '03')
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })->get();
        /** count */
        $mar_f_diagram_done     = $mar_f_diagram->where('status_id', '!=', 1)->count();
        $mar_f_diagram_progres  = $mar_f_diagram->where('status_id', 1)->count();

        /** april */
        $apr_f_diagram = Perkara::whereMonth('date', '=', '04')
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })->get();
        /** count */
        $apr_f_diagram_done     = $apr_f_diagram->where('status_id', '!=', 1)->count();
        $apr_f_diagram_progres  = $apr_f_diagram->where('status_id', 1)->count();

        /** mei */
        $mei_f_diagram = Perkara::whereMonth('date', '=', '05')
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })->get();
        /** count */
        $mei_f_diagram_done     = $mei_f_diagram->where('status_id', '!=', 1)->count();
        $mei_f_diagram_progres  = $mei_f_diagram->where('status_id', 1)->count();

        /** juni */
        $jun_f_diagram = Perkara::whereMonth('date', '=', '06')
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })->get();
        /** count */
        $jun_f_diagram_done     = $jun_f_diagram->where('status_id', '!=', 1)->count();
        $jun_f_diagram_progres  = $jun_f_diagram->where('status_id', 1)->count();

        /** juli */
        $jul_f_diagram = Perkara::whereMonth('date', '=', '07')
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })->get();
        /** count */
        $jul_f_diagram_done     = $jul_f_diagram->where('status_id', '!=', 1)->count();
        $jul_f_diagram_progres  = $jul_f_diagram->where('status_id', 1)->count();

        /** agustus */
        $aug_f_diagram = Perkara::whereMonth('date', '=', '08')
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })->get();
        /** count */
        $aug_f_diagram_done     = $aug_f_diagram->where('status_id', '!=', 1)->count();
        $aug_f_diagram_progres  = $aug_f_diagram->where('status_id', 1)->count();

        /** september */
        $sep_f_diagram = Perkara::whereMonth('date', '=', '09')
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })->get();
        /** count */
        $sep_f_diagram_done     = $sep_f_diagram->where('status_id', '!=', 1)->count();
        $sep_f_diagram_progres  = $sep_f_diagram->where('status_id', 1)->count();

        /** oktober */
        $oct_f_diagram = Perkara::whereMonth('date', '=', '10')
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })->get();
        /** count */
        $oct_f_diagram_done     = $oct_f_diagram->where('status_id', '!=', 1)->count();
        $oct_f_diagram_progres  = $oct_f_diagram->where('status_id', 1)->count();

        /** november */
        $nov_f_diagram = Perkara::whereMonth('date', '=', '11')
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })->get();
        /** count */
        $nov_f_diagram_done     = $nov_f_diagram->where('status_id', '!=', 1)->count();
        $nov_f_diagram_progres  = $nov_f_diagram->where('status_id', 1)->count();

        /** desember */
        $des_f_diagram = Perkara::whereMonth('date', '=', '12')
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })->get();
        /** count */
        $des_f_diagram_done     = $des_f_diagram->where('status_id', '!=', 1)->count();
        $des_f_diagram_progres  = $des_f_diagram->where('status_id', 1)->count();

        // Line 9
        // data time for chart
        $time_session_1 = Perkara::whereTime('time', '>=', \Carbon\Carbon::parse('00:00'))
          ->whereTime('time', '<=', \Carbon\Carbon::parse('03:00'))
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })
          ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
            $query->whereMonth('date', $bulan_param);
          })
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->count();

        $time_session_2 = Perkara::whereTime('time', '>=', \Carbon\Carbon::parse('03:01'))
          ->whereTime('time', '<=', \Carbon\Carbon::parse('06:00'))
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })
          ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
            $query->whereMonth('date', $bulan_param);
          })
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->count();

        $time_session_3 = Perkara::whereTime('time', '>=', \Carbon\Carbon::parse('06:01'))
          ->whereTime('time', '<=', \Carbon\Carbon::parse('09:00'))
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })
          ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
            $query->whereMonth('date', $bulan_param);
          })
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->count();

        $time_session_4 = Perkara::whereTime('time', '>=', \Carbon\Carbon::parse('09:01'))
          ->whereTime('time', '<=', \Carbon\Carbon::parse('12:00'))
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })
          ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
            $query->whereMonth('date', $bulan_param);
          })
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->count();

        $time_session_5 = Perkara::whereTime('time', '>=', \Carbon\Carbon::parse('12:01'))
          ->whereTime('time', '<=', \Carbon\Carbon::parse('15:00'))
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })
          ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
            $query->whereMonth('date', $bulan_param);
          })
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->count();

        $time_session_6 = Perkara::whereTime('time', '>=', \Carbon\Carbon::parse('15:01'))
          ->whereTime('time', '<=', \Carbon\Carbon::parse('18:00'))
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })
          ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
            $query->whereMonth('date', $bulan_param);
          })
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->count();

        $time_session_7 = Perkara::whereTime('time', '>=', \Carbon\Carbon::parse('18:01'))
          ->whereTime('time', '<=', \Carbon\Carbon::parse('21:00'))
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })
          ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
            $query->whereMonth('date', $bulan_param);
          })
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->count();

        $time_session_8 = Perkara::whereTime('time', '>=', \Carbon\Carbon::parse('21:01'))
          ->whereTime('time', '<=', \Carbon\Carbon::parse('23:59'))
          ->when(!empty($satker_param), function ($query) use ($satker_param) {
            $query->where('kategori_bagian_id', $satker_param);
          })
          ->when(!empty($jenis_kasus_param), function ($query) use ($jenis_kasus_param) {
            $query->where('jenis_pidana', $jenis_kasus_param);
          })
          ->when(!empty($tahun_param), function ($query) use ($tahun_param) {
            $query->whereYear('date', $tahun_param);
          })
          ->when(!empty($bulan_param), function ($query) use ($bulan_param) {
            $query->whereMonth('date', $bulan_param);
          })
          ->where('perkaras.user_id', '=', Auth::user()->id)
          ->count();

        // array data time
        $data_time = [
          $time_session_1,
          $time_session_2,
          $time_session_3,
          $time_session_4,
          $time_session_5,
          $time_session_6,
          $time_session_7,
          $time_session_8,
        ];

        $min = min($data_time); // data maksimal chart
        $max = max($data_time); // data min chart
        $range = 100; // data range chart
    }
}
