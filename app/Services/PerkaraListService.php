<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Akses;
use App\Perkara;
use App\JenisPidana;
use Illuminate\Http\Request;
use App\Constant;

class PerkaraListService
{
    public function __construct()
    {
        /**
         * Polda
         * Ditreskrimsus
         * Ditreskrimum
         * Ditresnarkoba, jenis_pidana == 32
         * 
         * Polres
         * Satreskrim
         * Satnarkoba, jenis_pidana == 32
         * Unit Reskrim
         */
        $this->is_satnarkoba = 0;
        $divisi = Auth::user()->divisi;
        // get data kategori Constant::JENIS_PIDANA_SATNARKOBA
        $jenis_pidanas = JenisPidana ::where('kategori_jns_pidana', Constant::JENIS_PIDANA_SATNARKOBA)->get();
        foreach($jenis_pidanas as $jenis_pidana){
            $arr_id[] = $jenis_pidana->id;
        }
        $this->arr_jenis_pidana = $arr_id;

        if($divisi == 'Ditresnarkoba' || $divisi == 'Satnarkoba'){
            $this->is_satnarkoba    = 1;
        }
        
    }
    
    public function showAdmin($perPage, $param)
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

        $perkaras = Perkara::orderBy('perkaras.updated_at', 'desc')
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
            ->whereYear('date_no_lp', '<', date('Y', strtotime('0 year')))
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
            ->paginate($perPage);

        return $perkaras;
    }

    public function showNotAdmin($perPage, $param)
    {
        $query_daterange    = $param['query_daterange'];
        $original_date_from = '';
        $original_date_to   = '';
        $arr_jenis_pidana   = $this->arr_jenis_pidana;

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
        $query_petugas      = $param['query_petugas'];
        $query_korban       = $param['query_korban'];
        $query_bukti        = $param['query_bukti'];
        $query_kejadian     = $param['query_kejadian'];
        $query_pidana       = $param['query_pidana'];
        $query_status       = $param['query_status'];

        $perkaras = Akses::orderBy('perkaras.updated_at', 'desc')
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
              ->whereYear('date_no_lp', '<', date('Y', strtotime('0 year')))
              ->where('akses.user_id', '=', Auth::user()->id)
              ->when(!empty($query_no_lp), function ($query) use ($query_no_lp) {
                $query->whereRaw("REPLACE(perkaras.no_lp,' ','') LIKE ?", ["%{$query_no_lp}%"]);
              })
              ->when(!empty($query_tgl_lp), function ($query) use ($query_tgl_lp) {
                $query->where('perkaras.date_no_lp', $query_tgl_lp);
              })
              ->when($this->is_satnarkoba == 1, function ($query) use ($arr_jenis_pidana) { // show only narkoba data
                $query->whereIn('perkaras.jenis_pidana', $arr_jenis_pidana);
              })
              ->when($this->is_satnarkoba == 0, function ($query) use ($arr_jenis_pidana) {
                $query->whereNotIn('perkaras.jenis_pidana', $arr_jenis_pidana);
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
              ->paginate($perPage);

        return $perkaras;
    }

}
