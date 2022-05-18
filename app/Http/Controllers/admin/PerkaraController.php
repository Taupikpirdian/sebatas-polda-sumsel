<?php

namespace App\Http\Controllers\admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Perkara;
use App\KategoriBagian;
use App\JenisPidana;
use App\UserGroup;
use App\Korban;
use App\Status;
use App\Akses;
use App\User;
use App\Tiket;
use App\MasterAnggaran;
use App\TurunanSatuan;
use App\Anggaran;
use App\TypeNarkoba;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Constant;

class PerkaraController extends Controller
{
    public $user_info;
    public $jenis_pidana;

    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->jenis_pidana = 0;
            $this->user_info = Auth::user(); // returns user

            $divisi = $this->user_info->divisi;
            if($divisi == 'Ditresnarkoba' || $divisi == 'Satnarkoba'){
                $this->jenis_pidana = Constant::NARKOBA;
            }

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perkaras = Perkara::orderBy('created_at', 'desc')->paginate(25);
        $start_page= (($perkaras->currentPage()-1) * 25) + 1;
        return view('admin.perkara.list',compact('start_page'), array('perkaras'=>$perkaras));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $params = [
            'jns_pidana' => $this->jenis_pidana,
        ];

        if(checkRole($this->user_info->id)->name != "Admin"){
            return View::make('admin.perkara.create', compact('params'));
        }else{
            return Redirect::back()->withErrors(['msg' => 'The Message']);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // store
        $request->validate(
            [
              'no_lp'         => 'unique:perkaras,no_lp',
              'date_no_lp'    => 'required|date_format:d/m/Y',
              'date'          => 'required|date_format:d/m/Y',
              'satker'        => 'required',
              'nama_petugas'  => 'required',
              'pangkat'       => 'required',
              'no_tlp'        => 'required',
              'jenis_pidana'  => 'required',
              'desc'          => 'required',
              'modus'         => 'required',
              'barang_bukti'  => 'required',
              'tkp'           => 'required',
              'lat'           => 'required',
              'long'          => 'required',
              'date'          => 'required',
              'time'          => 'required'
            ],
            [
              'no_lp.unique'             => 'No LP sudah digunakan',
              'date_no_lp.date_format'   => 'Format tanggal harus d/m/Y',
              'date.date_format'         => 'Format tanggal harus d/m/Y',
              'no_lp.required'           => 'Data ini tidak boleh kosong',
              'date.required'            => 'Data ini tidak boleh kosong',
              'date_no_lp.required'      => 'Data ini tidak boleh kosong',
              'satker.required'          => 'Data ini tidak boleh kosong',
              'nama_petugas.required'    => 'Data ini tidak boleh kosong',
              'pangkat.required'         => 'Data ini tidak boleh kosong',
              'no_tlp.required'          => 'Data ini tidak boleh kosong',
              'jenis_pidana.required'    => 'Data ini tidak boleh kosong',
              'desc.required'            => 'Data ini tidak boleh kosong',
              'modus.required'           => 'Data ini tidak boleh kosong',
              'pelaku.required'          => 'Data ini tidak boleh kosong',
              'barang_bukti.required'    => 'Data ini tidak boleh kosong',
              'tkp.required'             => 'Data ini tidak boleh kosong',
              'lat.required'             => 'Data ini tidak boleh kosong',
              'long.required'            => 'Data ini tidak boleh kosong',
              'date.required'            => 'Data ini tidak boleh kosong',
              'time.required'            => 'Data ini tidak boleh kosong'
            ]
          );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $perkara = Perkara::where('id', $id)->firstOrFail();
        return view('admin.perkara.show', compact('perkara'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $perkara = Perkara::leftJoin('kategori_bagians', 'kategori_bagians.id', '=', 'perkaras.kategori_bagian_id')
            ->leftJoin('jenis_pidanas', 'jenis_pidanas.id', '=', 'perkaras.jenis_pidana')
            ->leftJoin('type_narkobas','type_narkobas.id','=','perkaras.material')
            ->leftJoin('korbans', 'korbans.no_lp', '=', 'perkaras.no_lp')
            ->select([
                'perkaras.*',
                'kategori_bagians.name as satuan',
                'jenis_pidanas.name as pidana',
                'korbans.nama as korban',
                'korbans.saksi as saksi',
                'korbans.pelaku as pelaku',
                'type_narkobas.name as narkobas',
            ])->where('perkaras.id', $id)->firstOrFail();

        $status=Status::where('id', '!=', 1)->pluck('name', 'id');
        $status->prepend('=== Update Status ===', '');
        return view('admin.perkara.edit', compact('perkara', 'status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $perkara        = Perkara::findOrFail($id);
        $year_perkara   = date('Y', strtotime($perkara->date));
        $year_now       = date('Y');

        // Validasi
        $validatedData = $request->validate([
            'dokumen'                           => 'file|mimes:pdf|max:5000',
            'tanggal_surat_sprint_penyidik'     => 'required|date_format:d/m/Y',
        ],
        [
            'dokumen.mimes'                                 => 'Upload Dokumen Berupa PDF dengan Ukuran Maksimal 5Mb',
            'dokumen.max'                                   => 'Dokumen Terlau Besar, Ukuran Maksimal 5Mb',
            'tanggal_surat_sprint_penyidik.date_format'     => 'Format tanggal harus d/m/Y',
        ]);

        // jika input tanggal dokumen
        if($request->tgl_doc){
            // Validasi
            $validatedData = $request->validate([
                    'tgl_doc'                           => 'date_format:d/m/Y'
                ],
                [
                    'tgl_doc.date_format'               => 'Format tanggal harus d/m/Y'
                ]
            );
        }

        DB::beginTransaction();
        try {
            $perkara->user_id                       = Auth::user()->id;
            $perkara->status_id                     = Input::get('status');
            $perkara->tanggal_surat_sprint_penyidik = customTanggal(Input::get('tanggal_surat_sprint_penyidik'), 'd/m/Y', 'Y-m-d');
            if($request->tgl_doc){
                $perkara->tgl_document              = customTanggal(Input::get('tgl_doc'), 'd/m/Y', 'Y-m-d');
            }
            $perkara->keterangan                    = Input::get('keterangan');
    
            $file = $request->file('dokumen');
            if($file){
                $ext = $file->getClientOriginalExtension();
                $newName = rand(100000,1001238912).".".$ext;
        
                /** save to folder public */
                // $file->move('uploads/file',$newName);
                
                /** save to folder storage */
                Storage::disk('public')->putFileAs('file', $file, $newName);
                $perkara->document = $newName;
            }
    
            $perkara->save();
            // masukan ke log
            $createLog = [
              'user_id'    => Auth::user()->id,
              'perkara_id' => $id,
              'status'     => 2,
            ];
            saveLog($createLog);

            DB::commit();
            // kondisi data update
            if($year_perkara == $year_now){
                return Redirect::action('admin\PerkaraController@thisYear', compact('perkara'))->with('flash-update','Data berhasil diubah.');
            }else{
                return Redirect::action('admin\PerkaraController@lastYear', compact('perkara'))->with('flash-update','Data berhasil diubah.');
            }

        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $perkara = Perkara::where('id', $id)->firstOrFail();
        $korban = Korban::where('perkara_id', $id)->first();
        if($korban){
            $korban->delete();
        }
        $perkara->delete();
        return  Redirect::back()->with('flash-update','Data berhasil dihapus.');
    }

    public function lastYear()
    {
        // use livewire
        return view('admin.perkara.last_year');
    }

    public function thisYear()
    {
        // use livewire
        return view('admin.perkara.this_year');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateData($id)
    {
        // for flaging, get from kategori_jns_pidana
        $is_narkoba = 0;
        if($this->jenis_pidana == Constant::NARKOBA){
            $is_narkoba = 1;
        }

        $perkara = Perkara::where('id', $id)->firstOrFail();

        if($perkara){
            $perkara->date = customTanggal($perkara->date, 'Y-m-d', 'd/m/Y');
            $perkara->date_no_lp = customTanggal($perkara->date_no_lp, 'Y-m-d', 'd/m/Y');
        }


        // jika tidak ada data korban
        $korban = Korban::where('perkara_id', $id)->first();
        if($korban == null){
            $korbanCreate = new Korban();
            $korbanCreate->perkara_id           = $perkara->id;
            $korbanCreate->no_lp                = $perkara->no_lp;
            $korbanCreate->nama                 = "";
            $korbanCreate->umur_korban          = "";
            $korbanCreate->pendidikan_korban    = "";
            $korbanCreate->pekerjaan_korban     = "";
            $korbanCreate->asal_korban          = "";
            $korbanCreate->saksi                = "";
            $korbanCreate->pelaku               = "";
            $korbanCreate->barang_bukti         = "";
            $korbanCreate->save();
        }

        $pelaku = $perkara->korban->pelaku;

        $jenis_pidanas=JenisPidana::when($this->jenis_pidana != 0, function ($query) { // show only narkoba data
                $query->where('kategori_jns_pidana', '=', 1);
            })->when($this->jenis_pidana == 0, function ($query) {
                $query->where('kategori_jns_pidana', '!=', 1);
            })->orderBy('name', 'asc')
            ->pluck('name', 'id');

        $jenis_pidanas->prepend('=== Pilih Jenis Pidana ===', '');

        $type_narkoba=TypeNarkoba::pluck('name', 'id');
        $type_narkoba->prepend('=== Pilih Jenis Narkoba ===', '');

        // untuk admin
        $satker=KategoriBagian::pluck('name', 'id');
        $satker->prepend('=== Pilih Satuan Kerja (Satker) ===', '');
        
        // untuk bukan admin
        $satker_not_admin=Akses::leftJoin('kategori_bagians', 'kategori_bagians.id', '=', 'akses.sakter_id')
                ->where('akses.user_id', Auth::user()->id)
                ->pluck('kategori_bagians.name', 'kategori_bagians.id');

        $satker_not_admin->prepend('=== Pilih Satuan Kerja (Satker) ===', '');

        return view('admin.perkara.update', compact('pelaku', 'perkara', 'jenis_pidanas', 'satker', 'satker_not_admin', 'type_narkoba', 'is_narkoba'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updated(Request $request, $id)
    {
        // Validasi
        $request->validate(
            [
              'no_lp'         => 'unique:perkaras,no_lp,'. $id,
              'date_no_lp'    => 'required|date_format:d/m/Y',
              'date'          => 'required|date_format:d/m/Y',
              'satker'        => 'required',
              'nama_petugas'  => 'required',
              'pangkat'       => 'required',
              'no_tlp'        => 'required',
              'jenis_pidana'  => 'required',
              'desc'          => 'required',
              'modus'         => 'required',
              'barang_bukti'  => 'required',
              'tkp'           => 'required',
              'lat'           => 'required',
              'long'          => 'required',
              'date'          => 'required',
              'time'          => 'required'
            ],
            [
              'no_lp.unique'             => 'No LP '. $request->no_lp .' sudah digunakan',
              'date_no_lp.date_format'   => 'Format tanggal harus d/m/Y',
              'date.date_format'         => 'Format tanggal harus d/m/Y',
              'no_lp.required'           => 'Data ini tidak boleh kosong',
              'date.required'            => 'Data ini tidak boleh kosong',
              'date_no_lp.required'      => 'Data ini tidak boleh kosong',
              'satker.required'          => 'Data ini tidak boleh kosong',
              'nama_petugas.required'    => 'Data ini tidak boleh kosong',
              'pangkat.required'         => 'Data ini tidak boleh kosong',
              'no_tlp.required'          => 'Data ini tidak boleh kosong',
              'jenis_pidana.required'    => 'Data ini tidak boleh kosong',
              'desc.required'            => 'Data ini tidak boleh kosong',
              'modus.required'           => 'Data ini tidak boleh kosong',
              'pelaku.required'          => 'Data ini tidak boleh kosong',
              'barang_bukti.required'    => 'Data ini tidak boleh kosong',
              'tkp.required'             => 'Data ini tidak boleh kosong',
              'lat.required'             => 'Data ini tidak boleh kosong',
              'long.required'            => 'Data ini tidak boleh kosong',
              'date.required'            => 'Data ini tidak boleh kosong',
              'time.required'            => 'Data ini tidak boleh kosong'
            ]
        );

        // get group user
        $user_group = UserGroup::leftjoin('groups', 'groups.id', '=', 'user_groups.group_id')
        ->select(
            'groups.name',
            'user_groups.group_id'
            )
        ->where('user_id', Auth::user()->id)
        ->first();

        DB::beginTransaction();
        try {
            $perkara = Perkara::findOrFail($id);
                
            $year_perkara = date('Y', strtotime($perkara->date_no_lp));
            $year_now = date('Y');
            $perkara->user_id             = Auth::user()->id;
            $perkara->no_lp               = Input::get('no_lp');
            $perkara->date_no_lp          = customTanggal(Input::get('date_no_lp'), 'd/m/Y', 'Y-m-d');
            
            if($user_group->group_id == 1){ // User Admin
                $check_satuan = KategoriBagian::where('id', $request->satker)->first();
                $perkara->kategori_id         = $check_satuan->kategori_id;
                $perkara->kategori_bagian_id  = Input::get('satker');
                $perkara->divisi              = Input::get('divisi');
                if ($check_satuan->kategori_id == "1") {
                    $perkara->pin         = "http://maps.google.com/mapfiles/ms/icons/blue-dot.png";
                }
        
                if ($check_satuan->kategori_id == "2") {
                    $perkara->pin         = "http://maps.google.com/mapfiles/ms/icons/red-dot.png";
                }
        
                if ($check_satuan->kategori_id == "3") {
                    $perkara->pin         = "http://maps.google.com/mapfiles/ms/icons/yellow-dot.png";
                }
            
            }elseif ($user_group->group_id == 2) { // User Polda
                // get id satker from table akses
                $satker_id_f_akses = Akses::where('user_id', Auth::user()->id)->first();
    
                $perkara->kategori_id         = 1;
                $perkara->kategori_bagian_id  = $satker_id_f_akses->sakter_id;
                $perkara->divisi              = Auth::user()->divisi;
                $perkara->pin                 = "http://maps.google.com/mapfiles/ms/icons/blue-dot.png";
            
            }else{ // User Polres
                $check_satuan = KategoriBagian::where('id', $request->satker)->first();
                $perkara->kategori_id         = $check_satuan->kategori_id;
                $perkara->kategori_bagian_id  = Input::get('satker');
                $perkara->divisi              = Auth::user()->divisi;
    
                // Untuk Polda
                if ($check_satuan->kategori_id == "1") {
                    $perkara->pin         = "http://maps.google.com/mapfiles/ms/icons/blue-dot.png";
                }
    
                // Untuk Polres
                if ($check_satuan->kategori_id == "2") {
                    $perkara->pin         = "http://maps.google.com/mapfiles/ms/icons/red-dot.png";
                }
                
                // Untuk Polsek
                if ($check_satuan->kategori_id == "3") {
                    $perkara->pin         = "http://maps.google.com/mapfiles/ms/icons/yellow-dot.png";
                }
            }
    
            $perkara->uraian              = Input::get('desc');
            $perkara->modus_operasi       = Input::get('modus');
            $perkara->nama_petugas        = Input::get('nama_petugas');
            $perkara->pangkat             = Input::get('pangkat');
            $perkara->no_tlp              = Input::get('no_tlp');
            $perkara->tkp                 = Input::get('tkp');
            $perkara->lat                 = Input::get('lat');
            $perkara->long                = Input::get('long');
            $perkara->date                = customTanggal(Input::get('date'), 'd/m/Y', 'Y-m-d');
            $perkara->time                = Input::get('time');
            // $perkara->status_id           = 1;
            $perkara->jenis_pidana        = Input::get('jenis_pidana');
            if($perkara->jenis_pidana == '32'){
                $perkara->material            = Input::get('material');
                $perkara->qty                 = Input::get('qty');
            }else{
                $perkara->material            = NULL;
                $perkara->qty                 = NULL;
            }
            $perkara->anggaran            = Input::get('anggaran');
    
            // masuk table korban
            $korban = Korban::where('perkara_id', $id)->first();
            $korban->no_lp               = Input::get('no_lp');
            $korban->nama                = Input::get('nama_korban');
            $korban->umur_korban         = Input::get('umur_korban');
            $korban->pendidikan_korban   = Input::get('pendidikan_korban');
            $korban->pekerjaan_korban    = Input::get('pekerjaan_korban');
            $korban->asal_korban         = Input::get('asal_korban');
            $korban->barang_bukti        = $request->barang_bukti;
    
            if($request->saksi){
                $saksi = implode(", ",$request->saksi);
                $korban->saksi           = $saksi;
            }
            
            if($request->pelaku){
                $arrays = $request->pelaku;
                $a = str_replace(array('[', ']'), '', htmlspecialchars(json_encode($arrays), ENT_NOQUOTES));
                $b = (str_replace('{"','',$a));
                $c = (str_replace('"}','',$b));
                $d = (str_replace(',',', ',$c));
                $string_pelaku = (str_replace('"','',$d));
                $korban->pelaku          = $string_pelaku;
            }
    
            $perkara->save();
            $korban->save();
            // masukan ke log
            $createLog = [
              'user_id'    => Auth::user()->id,
              'perkara_id' => $id,
              'status'     => 3,
            ];
            saveLog($createLog);

            DB::commit();
            // kondisi data update
            if($year_perkara == $year_now){
                return Redirect::action('admin\PerkaraController@thisYear', compact('perkara'))->with('flash-update','Data berhasil diubah.');
            }else{
                return Redirect::action('admin\PerkaraController@lastYear', compact('perkara'))->with('flash-update','Data berhasil diubah.');
            }

        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
        }
    }

    public function tiket(Request $request, $id)
    {
        $check_tiket = Tiket::where('id', $id)->where('status', 0)->first();
        
        if($check_tiket == null){
            return  Redirect::back()->with('flash-destroy','Anda sudah pernah membuat tiket untuk no LP ini, tiket masih dalam progress, harap untuk menunggu.');
        }else{
            $tiket= new Tiket;
            $tiket->perkara_id = $id;
            $tiket->action     = $request->actionRequest;
            $tiket->reason     = $request->reason;
            $tiket->status     = 0;
            $tiket->save();
            return  Redirect::back()->with('flash-update','Tiket berhasil dibuat, Silahkan tunggu 1x24 Jam. Anda bisa mengecek status tiket di menu tiket.');
        }
    }

    public function updateAnggaran($id)
    {
        // data perkara
        $perkara = Perkara::where('id', $id)->firstOrFail();
        // history dana perkara
        $anggarans = Anggaran::orderBy('created_at', 'desc')->where('perkara_id', $id)->get();
        // anggaran yang sudah digunakan
        $sum_anggaran = Anggaran::where('perkara_id', $id)->sum('anggaran');

        return view('admin.perkara.update_anggaran', compact('perkara', 'anggarans', 'sum_anggaran'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function storeUpdateAnggaran(Request $request, $id)
    {
        $perkara = Perkara::select([
          'perkaras.id', 
          'perkaras.no_lp', 
          'perkaras.kategori_id',
          'perkaras.kategori_bagian_id',
          'perkaras.status_id',
          'perkaras.anggaran',
          'kategori_bagians.name',
        ])->join('kategori_bagians', 'perkaras.kategori_bagian_id', '=', 'kategori_bagians.id')
          ->where('perkaras.id', $id)
          ->first();

        // check if anggaran null or 0
        if($perkara->anggaran == null || $perkara->anggaran == 0){
            return  Redirect::back()->with('flash-danger','Data anggaran untuk '.$perkara->name.' masih 0 atau belum ada, harap cek kembali di menu edit perkara.');
        }

        $year_perkara   = date('Y', strtotime($perkara->date));
        $year_now       = date('Y');

        // save histori anggaran
        $anggaran = new Anggaran();

        // cek untuk data bukan polsek
        if($perkara->kategori_id != 3){
          // cek sudah ada data master atau belum
          $master_anggaran = MasterAnggaran::select('total_anggaran')->where('satker_id', $perkara->kategori_bagian_id)->first();
          if($master_anggaran == null){ // jika data tidak ada
            // kirim dari bot telegram ke grup
            $createArray = [
              'user_id'    => Auth::user()->id,
              'satker_id'  => $perkara->kategori_bagian_id,
              'status'     => 6, // error data master anggaran tidak ada
            ];
            messageToTelegram($createArray);
            return  Redirect::back()->with('flash-danger','Data master anggaran untuk '.$perkara->name.' belum tersedia, harap menghubungi Admin.');
          }
          // save kategori_id
          $anggaran->master_sakter_id   = $perkara->kategori_bagian_id;

        }else{
          // cek punya akun induk atau belum,
          /** data yang dibutuhkan */
          /** satker polsek */
          /** id polsek */
          $satker_turunan = TurunanSatuan::where('satker_turunan_id', $perkara->kategori_bagian_id)->first();
          if($satker_turunan == null){
            // kirim dari bot telegram ke grup
            $createArray = [
              'user_id'    => Auth::user()->id,
              'satker_id'  => $perkara->kategori_bagian_id,
              'status'     => 5, // error satker induk
            ];
            messageToTelegram($createArray);
            return  Redirect::back()->with('flash-danger','Data induk satker tidak tersedia, harap menghubungi Admin.');
          }
          // cek dana master ada atau tidak sesuai id satker induk
          $master_anggaran = MasterAnggaran::select('total_anggaran')->where('satker_id', $satker_turunan->satker_id)->first();
          // get nama satker induk
          $satker_induk = KategoriBagian::where('id', $satker_turunan->satker_id)->first();
          if($master_anggaran == null){ // jika data tidak ada
            // kirim dari bot telegram ke grup
            $createArray = [
              'user_id'    => Auth::user()->id,
              'satker_id'  => $perkara->kategori_bagian_id,
              'status'     => 6, // error data master anggaran tidak ada
            ];
            messageToTelegram($createArray);
            return  Redirect::back()->with('flash-danger','Data master anggaran untuk '.$satker_induk->name.' belum tersedia, harap menghubungi Admin.');
          }
          // save kategori_id
          $anggaran->master_sakter_id   = $satker_turunan->satker_id;
        }
        
        $anggaran->user_id      = Auth::user()->id;
        $anggaran->perkara_id   = $id;
        $anggaran->anggaran     = $request->anggaran;
        $anggaran->date         = $request->date;
        $anggaran->keterangan   = $request->keterangan;
        $anggaran->save();

        // masukan ke log
        $createLog = [
          'user_id'    => Auth::user()->id,
          'perkara_id' => $id,
          'status'     => 4,
        ];
        saveLog($createLog);
        // kondisi data update
        return  Redirect::back()->with('flash-update','Anggaran berhasil diupdate.');
    }

    public function uploadPdf(Request $request, $id)
    {
        // Validasi
        $request->validate([
            'dokumen' => 'file|mimes:pdf|max:5000',
        ],
        [
            'dokumen.mimes' => 'Upload Dokumen Berupa PDF dengan Ukuran Maksimal 5Mb',
            'dokumen.max' => 'Dokumen Terlau Besar, Ukuran Maksimal 5Mb'
        ]
        );

        $perkara                                = Perkara::findOrFail($id);
        $perkara->tanggal_surat_sprint_penyidik = Input::get('tanggal_surat_sprint_penyidik');
        $perkara->tgl_document                  = Input::get('tgl_doc');
        $perkara->keterangan                    = Input::get('keterangan');

        $file = $request->file('dokumen');
        if($file){
            $ext = $file->getClientOriginalExtension();
            $newName = rand(100000,1001238912).".".$ext;
    
            /** save to folder storage */
            Storage::disk('public')->putFileAs('file', $file, $newName);
            $perkara->document = $newName;
        }
        $perkara->save();
        // masukan ke log
        $createLog = [
          'user_id'    => Auth::user()->id,
          'perkara_id' => $id,
          'status'     => 2,
        ];
        saveLog($createLog);
        // kondisi data update
        return Redirect::back()->with('flash-update','Update data berhasil.');
    }

    public function limpahPerkara($id)
    {
        /**
         * Rule
         * 
         * Satnarkoba <=> Ditresnarkoba
         * 
         * Satreskrim <=> Ditreskrimsus
         * Satreskrim <=> Ditreskrimum
         * 
         * Unit Reskrim <=> Satreskrim
         * 
         * Unit Reskrim <=> Ditreskrimsus
         * Unit Reskrim <=> Ditreskrimum
         * 
         */

        if(Auth::user()->divisi == "Satnarkoba"){
            $divisis = array(
                "Ditresnarkoba" => "Ditresnarkoba",
            );
        }elseif(Auth::user()->divisi == "Ditresnarkoba"){
            $divisis = array(
                "Satnarkoba"    => "Satnarkoba",
            );
        }elseif(Auth::user()->divisi == "Satreskrim"){
            $divisis = array(
                "Ditreskrimsus" => "Ditreskrimsus",
                "Ditreskrimum"  => "Ditreskrimum",
                "Unit Reskrim"   => "Unit Reskrim",
            );
        }elseif(Auth::user()->divisi == "Ditreskrimsus"){
            $divisis = array(
                "Satreskrim"    => "Satreskrim",
                "Unit Reskrim"   => "Unit Reskrim",
            );
        }elseif(Auth::user()->divisi == "Ditreskrimum"){
            $divisis = array(
                "Satreskrim"    => "Satreskrim",
                "Unit Reskrim"   => "Unit Reskrim",
            );
        }elseif(Auth::user()->divisi == "Unit Reskrim"){
            $divisis = array(
                "Ditreskrimsus" => "Ditreskrimsus",
                "Ditreskrimum"  => "Ditreskrimum",
                "Satreskrim"    => "Satreskrim",
            );
        }else{
            $divisis = array(
                "Ditreskrimsus" => "Ditreskrimsus",
                "Ditreskrimum"  => "Ditreskrimum",
                "Ditresnarkoba" => "Ditresnarkoba",
                "Satreskrim"    => "Satreskrim",
                "Satnarkoba"    => "Satnarkoba",
                "Unit Reskrim"   => "Unit Reskrim",
            );
        }

        $perkara = Perkara::where('id', $id)->firstOrFail();
        return view('admin.perkara.limpah', compact('perkara', 'divisis'));
    }

    public function getStates($id)
    {
        $users = DB::table("users")->where("divisi", $id)->pluck("name","id");
        return json_encode($users);
    }

    public function limpahPerkaraPost(Request $request, $id)
    {
        $perkara = Perkara::where('id', $id)->first();
        /**
         * ambil data user sesuai param name dan divisi
         */
        $user = User::where('name', $request->satker)->first();
        $akses = Akses::select([
            'akses.sakter_id',
            'kategori_bagians.kategori_id',
        ])->join('kategori_bagians', 'akses.sakter_id', '=', 'kategori_bagians.id')
          ->where('akses.user_id', $user->id)
          ->get();

        dd($akses);

        // update data
        $perkara->user_id               = $user->id;
        $perkara->kategori_id           = $akses->kategori_id;
        $perkara->kategori_bagian_id    = $akses->sakter_id;
        $perkara->is_limpah             = 1;
        $perkara->limpah_date           = date("Y-m-d");
        $perkara->save();

        $year_perkara   = date('Y', strtotime($perkara->date));
        $year_now       = date('Y');
        // kondisi data update
        if($year_perkara == $year_now){
            return Redirect::action('admin\PerkaraController@thisYear', compact('perkara'))->with('flash-update','Data berhasil dilimpahkan.');
        }else{
            return Redirect::action('admin\PerkaraController@lastYear', compact('perkara'))->with('flash-update','Data berhasil dilimpahkan.');
        }
    }
}
