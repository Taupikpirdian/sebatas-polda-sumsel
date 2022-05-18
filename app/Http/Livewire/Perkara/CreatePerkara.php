<?php

namespace App\Http\Livewire\Perkara;

use App\Constant;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Http\Repositories\CreatePerkaraRepository;

class CreatePerkara extends Component
{
    public $is_narkoba = 0;
    public $jenis_pidanas, $satker, $type_narkoba, $satker_not_admin;
    public $satker_id, $divisi, $nama_petugas, $pangkat, $no_tlp, $no_lp, $date_no_lp, $jenis_pidana, $material, $qty, $desc, 
    $modus, $barang_bukti, $date, $time, $nama_korban, $umur_korban, $pendidikan_korban, 
    $pekerjaan_korban, $asal_korban, $lat, $long, $tkp;
    public $pendidikans, $jobs;
    public $nama_pelaku, $umur_pelaku, $pendidikan_pelaku, $pekerjaan_pelaku, $asal_pelaku;
    public $array_pelaku = [];
    public $nama_saksi;
    public $array_saksi = [];
    public $is_available_pelaku = 0;
    public $user_info;

    public function mount($params)
    {
        if($params['jns_pidana'] == Constant::NARKOBA){
            $this->is_narkoba = 1;
        }
        
        $this->user_info = Auth::user();
        $this->jenis_pidanas = (new CreatePerkaraRepository)->getDataJenisPidana($params['jns_pidana']);
        $this->satker = (new CreatePerkaraRepository)->satker();
        $this->type_narkoba = (new CreatePerkaraRepository)->typeNarkoba();
        $this->satker_not_admin = (new CreatePerkaraRepository)->listDataSatkerNotAdmin();
        $this->pendidikans = (new CreatePerkaraRepository)->dataPendidikan();
        $this->jobs = (new CreatePerkaraRepository)->dataPekerjaan();
    }

    protected $listeners = [
        'store',
    ];

    public function addPelaku()
    {
        array_push($this->array_pelaku, [
            'name' => $this->nama_pelaku,
            'umur' => $this->umur_pelaku,
            'pendidikan' => $this->pendidikan_pelaku,
            'pekerjaan' => $this->pekerjaan_pelaku,
            'asal' => $this->asal_pelaku,
        ]);

        $this->nama_pelaku = '';
        $this->umur_pelaku = '';
        $this->pendidikan_pelaku = '';
        $this->pekerjaan_pelaku = '';
        $this->asal_pelaku = '';
        $modal = '#pelakuModal';
        $this->emit('closeModal', $modal);
    }

    public function addSaksi()
    {
        array_push($this->array_saksi, [
            'name' => $this->nama_saksi,
        ]);
        
        $this->nama_saksi = '';
        $modal = '#saksiModal';
        $this->emit('closeModal', $modal);
    }

    public function removePelaku($key)
    {
        unset($this->array_pelaku[$key]);
        $this->array_pelaku = array_values($this->array_pelaku);
    }

    public function removeSaksi($key)
    {
        unset($this->array_saksi[$key]);
        $this->array_saksi = array_values($this->array_saksi);
    }

    public function validateData()
    {
        $this->validate([
            'nama_petugas' => 'required',
            'pangkat' => 'required',
            'no_tlp' => 'required',
            'no_lp' => 'required|unique:perkaras,no_lp',
            'date_no_lp' => 'required',
            'jenis_pidana' => 'required',
            'desc' => 'required',
            'modus' => 'required',
            'barang_bukti' => 'required',
            'date' => 'required',
            'time' => 'required',
            'lat' => 'required',
            'long' => 'required',
            'tkp' => 'required',
        ],
        [
            'nama_petugas.required' => 'Data ini tidak boleh kosong',
            'pangkat.required' => 'Data ini tidak boleh kosong',
            'no_tlp.required' => 'Data ini tidak boleh kosong',
            'no_lp.required' => 'Data ini tidak boleh kosong',
            'no_lp.unique' => 'No LP sudah digunakan',
            'date_no_lp.required' => 'Data ini tidak boleh kosong',
            'jenis_pidana.required' => 'Data ini tidak boleh kosong',
            'desc.required' => 'Data ini tidak boleh kosong',
            'modus.required' => 'Data ini tidak boleh kosong',
            'barang_bukti.required' => 'Data ini tidak boleh kosong',
            'date.required' => 'Data ini tidak boleh kosong',
            'time.required' => 'Data ini tidak boleh kosong',
            'lat.required' => 'Data ini tidak boleh kosong, klik map untuk isi data',
            'long.required' => 'Data ini tidak boleh kosong, klik map untuk isi data',
            'tkp.required' => 'Data ini tidak boleh kosong',
        ]);

        if($this->is_narkoba == 1){
            $this->validate([
                'material' => 'required',
                'qty' => 'required',
            ],
            [
                'material.required' => 'Data ini tidak boleh kosong',
                'qty.required' => 'Data ini tidak boleh kosong',
            ]);
        }

        if(checkRole($this->user_info->id)->group_id != Constant::GROUP_POLDA){
            $this->validate([
                'satker_id' => 'required',
            ],
            [
                'satker_id.required' => 'Data ini tidak boleh kosong',
            ]);
        }

        if(empty($this->array_pelaku)){
            $params = [
                'icon'  => 'error',
                'title' => 'Gagal!',
                'text'  => 'Kesalahan pengisian data pelaku, harap cek form isian data pelaku!',
            ];
            $this->emit('sweetAlert', $params);
        }else{
            $this->emit('confirmSubmit');
        }

    }

    public function store()
    {
        $dataCollect = $this->collectData();
        $storeData = (new CreatePerkaraRepository)->store($dataCollect);
        if($storeData['status']){
            $params = [
                'icon' => 'success',
                'title' => 'Berhasil!',
                'text' => $storeData['message'],
                'url' => $storeData['url'],
            ];
            $this->clearData();
            $this->emit('sweetAlertRedirect', $params);
        }else{
            $params = [
                'icon'  => 'error',
                'title' => 'Kesalahan Sistem!',
                'text'  => $storeData['message'],
            ];
            $this->emit('sweetAlert', $params);
        }
    }

    public function collectData()
    {
        return [
            'satker' => $this->satker_id,
            'divisi' => $this->divisi,
            'nama_petugas' => $this->nama_petugas,
            'pangkat' => $this->pangkat,
            'no_tlp' => $this->no_tlp,
            'no_lp' => $this->no_lp,
            'date_no_lp' => $this->date_no_lp,
            'jenis_pidana' => $this->jenis_pidana,
            'material' => $this->material,
            'qty' => $this->qty,
            'desc' => $this->desc,
            'modus' => $this->modus,
            'barang_bukti' => $this->barang_bukti,
            'date' => $this->date,
            'time' => $this->time,
            'nama_korban' => $this->nama_korban,
            'umur_korban' => $this->umur_korban,
            'pendidikan_korban' => $this->pendidikan_korban,
            'pekerjaan_korban' => $this->pekerjaan_korban,
            'asal_korban' => $this->asal_korban,
            'lat' => $this->lat,
            'long' => $this->long,
            'tkp' => $this->tkp,
            'array_pelaku' => $this->array_pelaku,
            'array_saksi' => $this->array_saksi,
        ];
    }

    public function clearData()
    {
        $this->satker = '';
        $this->divisi = '';
        $this->nama_petugas = '';
        $this->pangkat = '';
        $this->no_tlp = '';
        $this->no_lp = '';
        $this->date_no_lp = '';
        $this->jenis_pidana = '';
        $this->material = '';
        $this->qty = ''; 
        $this->desc = '';
        $this->modus = '';
        $this->barang_bukti = '';
        $this->date = '';
        $this->time = '';
        $this->nama_korban = '';
        $this->umur_korban = '';
        $this->pendidikan_korban = '';
        $this->pekerjaan_korban = '';
        $this->asal_korban = '';
        $this->lat = ''; 
        $this->long = '';
        $this->tkp = '';
        $this->array_pelaku = [];
        $this->array_saksi = [];
    }

    public function checkArray($array)
    {
        return count($array);
    }

    public function render()
    {
        $countPelaku = $this->checkArray($this->array_pelaku);
        if($countPelaku > 0){
            $this->is_available_pelaku = 1;
        }else{
            $this->is_available_pelaku = 0;
        }
        return view('livewire.perkara.create-perkara');
    }
}
