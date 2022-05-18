<?php

namespace App\Http\Repositories;

use App\Akses;
use App\Korban;
use App\Perkara;
use App\Constant;
use App\UserGroup;
use App\JenisPidana;
use App\TypeNarkoba;
use App\KategoriBagian;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CreatePerkaraRepository {
    
    public function getDataJenisPidana($jenis_pidana) 
    {
        return JenisPidana::when($jenis_pidana != 0, function ($query) { // show only narkoba data
            $query->where('kategori_jns_pidana', '=', 1);
        })->when($jenis_pidana == 0, function ($query) {
            $query->where('kategori_jns_pidana', '!=', 1);
        })->orderBy('name', 'asc')
          ->get();
    }

    public function satker()
    {
        return KategoriBagian::select(['id', 'name'])->get();
    }

    public function typeNarkoba()
    {
        return TypeNarkoba::select(['name', 'id'])->get();
    }

    public function listDataSatkerNotAdmin()
    {
        return Akses::select([
            'kategori_bagians.id',
            'kategori_bagians.name',
        ])->leftJoin('kategori_bagians', 'kategori_bagians.id', '=', 'akses.sakter_id')
          ->where('akses.user_id', Auth::user()->id)
          ->get();
    }

    public function dataPendidikan()
    {
        return [
            "SD/Sederajat" => "SD/Sederajat",
            "SMP/Sederajat" => "SMP/Sederajat",
            "SMA/SMK/Sederajat" => "SMA/SMK/Sederajat",
            "D3/Sarjana Muda/Sederajat" => "D3/Sarjana Muda/Sederajat",
            "S1/Sarjana" => "S1/Sarjana",
            "S2/Master" => "S2/Master",
            "S3/Doktor" => "S3/Doktor",
            "Lainnya" => "Lainnya",
        ];
    }

    public function dataPekerjaan()
    {
        return [
            "Pegawai Negeri Sipil" => "Pegawai Negeri Sipil",
            "Karyawan Swasta" => "Karyawan Swasta",
            "Mahasiswa / Pelajar" => "Mahasiswa / Pelajar",
            "TNI" => "TNI",
            "Polri" => "Polri",
            "Pengangguran" => "Pengangguran",
            "Lain - lain" => "Lain - lain",
        ];
    }

    public function store($datas)
    {
        $user_group = checkRole(Auth::user()->id);

        DB::beginTransaction();
        try {
            // masuk table perkaras
            $perkara = new Perkara;
            $perkara->user_id = Auth::user()->id;
            $perkara->no_lp = $datas['no_lp'];
            $perkara->date_no_lp = $datas['date_no_lp'];
            
            if($user_group->group_id == Constant::GROUP_ADMIN){ // User Admin. tidak digunakan lagi
                $check_satuan = KategoriBagian::where('id', $datas['satker'])->first();
                $perkara->kategori_id         = $check_satuan->kategori_id;
                $perkara->kategori_bagian_id  = $datas['satker'];
                $perkara->divisi              = $datas['divisi'];
                if ($check_satuan->kategori_id == "1") {
                    $perkara->pin         = "http://maps.google.com/mapfiles/ms/icons/blue-dot.png";
                }
        
                if ($check_satuan->kategori_id == "2") {
                    $perkara->pin         = "http://maps.google.com/mapfiles/ms/icons/red-dot.png";
                }
        
                if ($check_satuan->kategori_id == "3") {
                    $perkara->pin         = "http://maps.google.com/mapfiles/ms/icons/yellow-dot.png";
                }
            
            }elseif ($user_group->group_id == Constant::GROUP_POLDA) { // User Polda
                // get id satker from table akses
                $satker_id_f_akses = Akses::where('user_id', Auth::user()->id)->first();

                $perkara->kategori_id = Constant::POLDA;
                $perkara->kategori_bagian_id = $satker_id_f_akses->sakter_id;
                $perkara->divisi = Auth::user()->divisi;
                $perkara->pin = "http://maps.google.com/mapfiles/ms/icons/blue-dot.png";
            }else{ // User Polres
                $check_satuan = KategoriBagian::where('id', $datas['satker'])->first();
                $perkara->kategori_id         = $check_satuan->kategori_id;
                $perkara->kategori_bagian_id  = $datas['satker'];
                $perkara->divisi              = Auth::user()->divisi;
                // Untuk Polda
                if ($check_satuan->kategori_id == Constant::POLDA) {
                    $perkara->pin = "http://maps.google.com/mapfiles/ms/icons/blue-dot.png";
                }
                // Untuk Polres
                if ($check_satuan->kategori_id == Constant::POLRES) {
                    $perkara->pin = "http://maps.google.com/mapfiles/ms/icons/red-dot.png";
                }
                // Untuk Polsek
                if ($check_satuan->kategori_id == Constant::POLSEK) {
                    $perkara->pin = "http://maps.google.com/mapfiles/ms/icons/yellow-dot.png";
                }
            }

            $perkara->uraian = $datas['desc'];
            $perkara->modus_operasi = $datas['modus'];
            $perkara->nama_petugas = $datas['nama_petugas'];
            $perkara->pangkat = $datas['pangkat'];
            $perkara->no_tlp = $datas['no_tlp'];
            $perkara->tkp = $datas['tkp'];
            $perkara->lat = $datas['lat'];
            $perkara->long = $datas['long'];
            $perkara->date = $datas['date'];
            $perkara->time = $datas['time'];
            $perkara->status_id = Constant::PROGRESS;
            $perkara->handle_bukti = 0;
            $perkara->soft_delete_id = 0;
            $perkara->jenis_pidana = $datas['jenis_pidana'];
            $perkara->material = $datas['material'];
            $perkara->qty = $datas['qty'];
            $perkara->anggaran = 0;
            $perkara->is_limpah = 0;
            $perkara->save();
            // masuk table korban
            $saksi = '';
            if(isset($datas['array_saksi'])){
                $countArraySaksi = count($datas['array_saksi']);
                foreach($datas['array_saksi'] as $key=>$value){
                    $saksi .= $value['name'];
                    if($countArraySaksi != $key + 1){
                        $saksi .= ', ';
                    }
                }
            }

            $arrays = $datas['array_pelaku'];
        
            $a = str_replace(array('[', ']'), '', htmlspecialchars(json_encode($arrays), ENT_NOQUOTES));
            $b = (str_replace('{"','',$a));
            $c = (str_replace('"}','',$b));
            $d = (str_replace(',',', ',$c));
            $string_pelaku = (str_replace('"','',$d));

            $korban = new Korban;
            $korban->perkara_id = $perkara->id;
            $korban->no_lp = $datas['no_lp'];
            $korban->nama = $datas['nama_korban'];
            $korban->umur_korban = $datas['umur_korban'];
            $korban->pendidikan_korban = $datas['pendidikan_korban'];
            $korban->pekerjaan_korban = $datas['pekerjaan_korban'];
            $korban->asal_korban = $datas['asal_korban'];
            $korban->saksi = $saksi;
            $korban->pelaku = $string_pelaku;
            $korban->barang_bukti = $datas['barang_bukti'];
            $korban->save();

            // masukan ke log
            $createLog = [
                'user_id'    => Auth::user()->id,
                'perkara_id' => $perkara->id,
                'status'     => 1,
            ];
            saveLog($createLog);

            DB::commit();
            $year_perkara = date('Y', strtotime($datas['date_no_lp']));
            $year_now = date('Y');
            // kondisi data update
            if($year_perkara == $year_now){
                $url = '/perkara/this-year';
            }else{
                $url = '/perkara/last-year';
            }

            return [
                'status' => true,
                'url' => $url,
                'message' => 'Berhasil Input Data',
            ];

        } catch (\Throwable $th) {
            DB::rollback();
            return [
                'status' => false,
                'url' => null,
                'message' => $th->getMessage(),
            ];
        }
    }
}