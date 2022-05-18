<?php

namespace App\Services;

use App\Perkara;
use Illuminate\Support\Facades\Auth;
use App\Constant;
use App\Akses;

class TahunIniKejahatanService
{
    public function __construct()
    {
        $this->user = Auth::user();
        $this->year = date('Y');
    }

    public function roleAdmin($perPage, $param)
    {
        $query_daterange    = $param['query_daterange'];
        $original_date_from = '';
        $original_date_to   = '';

        if($query_daterange){
            $arr_date    = explode("-",$query_daterange);
            $arr_date[0] = rtrim($arr_date[0]);
            $arr_date[1] = ltrim($arr_date[1]);
            // change format date from
            $replace_from           = str_replace("/","-",$arr_date[0]);
            $original_date_from     = $replace_from;
            // change format date to
            $replace_to           = str_replace("/","-",$arr_date[1]);
            $original_date_to     = $replace_to;
        }

        // param filter
        $query_no_lp        = $param['query_no_lp'];
        $query_tgl_lp       = $param['query_tgl_lp'];
        $query_satker       = $param['query_satker'];
        $query_petugas      = $param['query_petugas'];
        $query_korban       = $param['query_korban'];
        $query_bukti        = $param['query_bukti'];
        $query_kejadian     = $param['query_kejadian'];
        $query_pidana       = $param['query_pidana'];
        $query_status       = $param['query_status'];

        // param from filter
        $satker       = $param['satker'];
        $divisi       = $param['divisi'];
        $jenis_kasus  = $param['jenis_kasus'];
        $tahun        = $param['tahun'];
        $bulan        = $param['bulan'];

        $datas = Perkara::orderBy('perkaras.updated_at', 'desc')
          ->leftJoin('jenis_pidanas', 'jenis_pidanas.id', '=', 'perkaras.jenis_pidana')
          ->leftJoin('kategori_bagians', 'kategori_bagians.id', '=', 'perkaras.kategori_bagian_id')
          ->leftJoin('korbans', 'korbans.no_lp', '=', 'perkaras.no_lp')
          ->leftJoin('statuses', 'statuses.id', '=', 'perkaras.status_id')
          ->select(
              'perkaras.id',
              'perkaras.no_lp',
              'perkaras.date_no_lp',
              'kategori_bagians.name as satuan',
              'perkaras.nama_petugas',
              'korbans.nama',
              'korbans.barang_bukti',
              'perkaras.date',
              'perkaras.time',
              'jenis_pidanas.name as pidana',
              'perkaras.status_id',
              'statuses.name as status')
          ->whereYear('date_no_lp', date('Y'))
          ->when(!empty($query_no_lp), function ($query) use ($query_no_lp) {
            $query->whereRaw("REPLACE(perkaras.no_lp,' ','') LIKE ?", ["%{$query_no_lp}%"]);
          })
          ->when(!empty($query_tgl_lp), function ($query) use ($query_tgl_lp) {
              $query->where('perkaras.date_no_lp', $query_tgl_lp);
          })
          ->when(!empty($query_satker), function ($query) use ($query_satker) {
              $query->where('kategori_bagians.name', 'like', "%$query_satker%");
          })
          ->when(!empty($query_petugas), function ($query) use ($query_petugas) {
              $query->where('perkaras.nama_petugas', 'like', "%$query_petugas%");
          })
          ->when(!empty($query_korban), function ($query) use ($query_korban) {
              $query->where('korbans.nama', 'like', "%$query_korban%");
          })
          ->when(!empty($query_bukti), function ($query) use ($query_bukti) {
              $query->where('korbans.barang_bukti', 'like', "%$query_bukti%");
          })
          ->when(!empty($query_kejadian), function ($query) use ($query_kejadian) {
              $query->where('perkaras.date', $query_kejadian);
          })
          ->when(!empty($query_pidana), function ($query) use ($query_pidana) {
              $query->where('jenis_pidanas.name', 'like', "%$query_pidana%");
          })
          ->when(!empty($query_status), function ($query) use ($query_status) {
              $query->where('statuses.name', 'like', "%$query_status%");
          })
          ->when(!empty($query_daterange), function ($query) use ($original_date_from, $original_date_to) {
              $query->whereBetween('perkaras.date_no_lp', [$original_date_from, $original_date_to]);
          })
          ->when($satker != null, function ($query) use ($satker) {
            $query->where('perkaras.kategori_bagian_id', $satker);
          })
          ->when($divisi != null, function ($query) use ($divisi) {
            $query->where('perkaras.divisi', $divisi);
          })
          ->when($jenis_kasus != null, function ($query) use ($jenis_kasus) {
            $query->where('perkaras.jenis_pidana', $jenis_kasus);
          })
          ->when($tahun != null, function ($query) use ($tahun) {
            $query->whereYear('perkaras.date_no_lp', $tahun);
          })
          ->when($bulan != null, function ($query) use ($bulan) {
            $query->whereMonth('perkaras.date_no_lp', $bulan);
          })
          ->paginate($perPage);

        return $datas;
    }

    public function roleNotAdmin($perPage, $param)
    {
        $query_daterange    = $param['query_daterange'];
        $original_date_from = '';
        $original_date_to   = '';

        if($query_daterange){
            $arr_date    = explode("-",$query_daterange);
            $arr_date[0] = rtrim($arr_date[0]);
            $arr_date[1] = ltrim($arr_date[1]);
            // change format date from
            $replace_from           = str_replace("/","-",$arr_date[0]);
            $original_date_from     = $replace_from;
            // change format date to
            $replace_to           = str_replace("/","-",$arr_date[1]);
            $original_date_to     = $replace_to;
        }

        // param filter
        $query_no_lp        = $param['query_no_lp'];
        $query_tgl_lp       = $param['query_tgl_lp'];
        $query_satker       = $param['query_satker'];
        $query_petugas      = $param['query_petugas'];
        $query_korban       = $param['query_korban'];
        $query_bukti        = $param['query_bukti'];
        $query_kejadian     = $param['query_kejadian'];
        $query_pidana       = $param['query_pidana'];
        $query_status       = $param['query_status'];

        // param from filter
        $satker       = $param['satker'];
        $divisi       = $param['divisi'];
        $jenis_kasus  = $param['jenis_kasus'];
        $tahun        = $param['tahun'];
        $bulan        = $param['bulan'];

        $datas = Akses::orderBy('perkaras.updated_at', 'desc')
            ->leftJoin('kategori_bagians', 'kategori_bagians.id', '=', 'akses.sakter_id')
            ->leftJoin('users', 'users.id', '=', 'akses.user_id')
            ->leftJoin('perkaras', 'perkaras.kategori_bagian_id', '=', 'akses.sakter_id')
            ->leftJoin('korbans', 'korbans.no_lp', '=', 'perkaras.no_lp')
            ->leftJoin('jenis_pidanas', 'jenis_pidanas.id', '=', 'perkaras.jenis_pidana')
            ->leftJoin('statuses', 'statuses.id', '=', 'perkaras.status_id')
            ->select(
                'perkaras.id',
                'perkaras.no_lp',
                'perkaras.date_no_lp',
                'kategori_bagians.name as satuan',
                'perkaras.nama_petugas',
                'korbans.nama',
                'korbans.barang_bukti',
                'perkaras.date',
                'perkaras.time',
                'jenis_pidanas.name as pidana',
                'perkaras.status_id',
                'statuses.name as status')
            ->whereYear('date_no_lp', date('Y'))
            ->where('akses.user_id', '=', Auth::user()->id)
            ->when(!empty($query_no_lp), function ($query) use ($query_no_lp) {
              $query->whereRaw("REPLACE(perkaras.no_lp,' ','') LIKE ?", ["%{$query_no_lp}%"]);
            })
            ->when(!empty($query_tgl_lp), function ($query) use ($query_tgl_lp) {
                $query->where('perkaras.date_no_lp', $query_tgl_lp);
            })
            ->when(!empty($query_satker), function ($query) use ($query_satker) {
                $query->where('kategori_bagians.name', 'like', "%$query_satker%");
            })
            ->when(!empty($query_petugas), function ($query) use ($query_petugas) {
                $query->where('perkaras.nama_petugas', 'like', "%$query_petugas%");
            })
            ->when(!empty($query_korban), function ($query) use ($query_korban) {
                $query->where('korbans.nama', 'like', "%$query_korban%");
            })
            ->when(!empty($query_bukti), function ($query) use ($query_bukti) {
                $query->where('korbans.barang_bukti', 'like', "%$query_bukti%");
            })
            ->when(!empty($query_kejadian), function ($query) use ($query_kejadian) {
                $query->where('perkaras.date', $query_kejadian);
            })
            ->when(!empty($query_pidana), function ($query) use ($query_pidana) {
                $query->where('jenis_pidanas.name', 'like', "%$query_pidana%");
            })
            ->when(!empty($query_status), function ($query) use ($query_status) {
                $query->where('statuses.name', 'like', "%$query_status%");
            })
            ->when(!empty($query_daterange), function ($query) use ($original_date_from, $original_date_to) {
                $query->whereBetween('perkaras.date_no_lp', [$original_date_from, $original_date_to]);
            })
            ->when($satker != null, function ($query) use ($satker) {
              $query->where('perkaras.kategori_bagian_id', $satker);
            })
            ->when($divisi != null, function ($query) use ($divisi) {
              $query->where('perkaras.divisi', $divisi);
            })
            ->when($jenis_kasus != null, function ($query) use ($jenis_kasus) {
              $query->where('perkaras.jenis_pidana', $jenis_kasus);
            })
            ->when($tahun != null, function ($query) use ($tahun) {
              $query->whereYear('perkaras.date_no_lp', $tahun);
            })
            ->when($bulan != null, function ($query) use ($bulan) {
              $query->whereMonth('perkaras.date_no_lp', $bulan);
            })
            ->paginate($perPage);
            
        return $datas;
    }

    // public function backup()
    // {
    //   /** param */
    //   $search_bar         = $request->search;
    //   $month              = $request->month;

    //   $login = Group::join('user_groups','user_groups.group_id','=','groups.id')
    //     ->where('user_groups.user_id', Auth::id())
    //     ->select('groups.name AS group')
    //     ->first();

    //   if($month != null){
    //     if($month == 3){
    //       $param_mount = date('Y-m-d', strtotime('-3 months'));
    //     }elseif($month == 6){
    //       $param_mount = date('Y-m-d', strtotime('-6 months'));
    //     // }elseif($month == 12){
    //     //   $param_mount = date('Y-m-d', strtotime('-12 months'));
    //     }
    //   }else{
    //     $month = 3;
    //     $param_mount = date('Y-m-d', strtotime('-3 months'));
    //   }

    //   // Data untuk role selain admin
    //   if($login->group != 'Admin')
    //   { // untuk user selain admin 
    //     $perkaras = Perkara::orderBy('perkaras.updated_at', 'desc')
    //       ->leftJoin('jenis_pidanas', 'jenis_pidanas.id', '=', 'perkaras.jenis_pidana')
    //       ->leftJoin('kategori_bagians', 'kategori_bagians.id', '=', 'perkaras.kategori_bagian_id')
    //       ->leftJoin('korbans', 'korbans.no_lp', '=', 'perkaras.no_lp')
    //       ->leftJoin('statuses', 'statuses.id', '=', 'perkaras.status_id')
    //       ->select(
    //           'perkaras.id',
    //           'perkaras.no_lp',
    //           'kategori_bagians.name as satuan',
    //           'perkaras.nama_petugas',
    //           'korbans.nama',
    //           'korbans.barang_bukti',
    //           'perkaras.date',
    //           'perkaras.time',
    //           'jenis_pidanas.name as pidana',
    //           'perkaras.status_id',
    //           'statuses.name as status')
    //       ->where('perkaras.user_id', '=', Auth::user()->id)
    //       ->whereYear('date', date('Y'))
    //       // ->where('status_id', '=', 1)
    //       ->when(!empty($param_mount), function ($query) use ($param_mount) {
    //         $query->where('date_no_lp', '<=', $param_mount);
    //       })
    //       ->where(function ($query) use ($search_bar) {
    //         $query->where('perkaras.no_lp', 'like', "%$search_bar%")
    //           ->orWhere('kategori_bagians.name', 'like', "%$search_bar%")
    //           ->orWhere('perkaras.nama_petugas', 'like', "%$search_bar%")
    //           ->orWhere('korbans.nama', 'like', "%$search_bar%")
    //           ->orWhere('jenis_pidanas.name', 'like', "%$search_bar%");
    //       })
    //       ->paginate(25);
    //   }else{
    //     $perkaras = Perkara::orderBy('perkaras.updated_at', 'desc')
    //       ->leftJoin('jenis_pidanas', 'jenis_pidanas.id', '=', 'perkaras.jenis_pidana')
    //       ->leftJoin('kategori_bagians', 'kategori_bagians.id', '=', 'perkaras.kategori_bagian_id')
    //       ->leftJoin('korbans', 'korbans.no_lp', '=', 'perkaras.no_lp')
    //       ->leftJoin('statuses', 'statuses.id', '=', 'perkaras.status_id')
    //       ->select(
    //           'perkaras.id',
    //           'perkaras.no_lp',
    //           'kategori_bagians.name as satuan',
    //           'perkaras.nama_petugas',
    //           'korbans.nama',
    //           'korbans.barang_bukti',
    //           'perkaras.date',
    //           'perkaras.time',
    //           'jenis_pidanas.name as pidana',
    //           'perkaras.status_id',
    //           'statuses.name as status')
    //       // ->where('status_id', '=', 1)
    //       ->when(!empty($param_mount), function ($query) use ($param_mount) {
    //         $query->where('date_no_lp', '<=', $param_mount);
    //       })
    //       ->whereYear('date', date('Y'))
    //       ->where(function ($query) use ($search_bar) {
    //         $query->where('perkaras.no_lp', 'like', "%$search_bar%")
    //           ->orWhere('kategori_bagians.name', 'like', "%$search_bar%")
    //           ->orWhere('perkaras.nama_petugas', 'like', "%$search_bar%")
    //           ->orWhere('korbans.nama', 'like', "%$search_bar%")
    //           ->orWhere('jenis_pidanas.name', 'like', "%$search_bar%");
    //       })
    //       ->paginate(25);
    //   }
    //   return view('admin.perkara.from-dashboard.total_this_year',compact('perkaras', 'search_bar', 'month'));
    // }

}
