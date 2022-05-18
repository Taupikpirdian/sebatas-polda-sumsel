<?php

namespace App\Http\Controllers\admin;

use Illuminate\Support\Facades\Auth;
use App\Perkara;
use App\JenisPidana;
use App\KategoriBagian;
use App\Group;
use App\Akses;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exports\PerkaraExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\DashboardService;
use App\Services\DashboardFilterService;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->year = date('Y');

        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            $login = Group::join('user_groups','user_groups.group_id','=','groups.id')
              ->where('user_groups.user_id', $this->user->id)
              ->select('groups.name AS group')
              ->first();

            $this->role = $login->group;
            return $next($request);
        });

        

        $data = Group::all();


        // $this->role = $login->group;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // Tahun
      $year = $this->year;
      /** hitung user login */
      $jenispidanas = JenisPidana::orderBy('name', 'asc')->get();

      $login = Group::join('user_groups','user_groups.group_id','=','groups.id')
                    ->where('user_groups.user_id', Auth::id())
                    ->select('groups.name AS group')
                    ->first();

      // Data untuk role selain admin
      if($login->group!='Admin')
      { // untuk user selain admin 
        $datas = (new DashboardService())->roleNotAdmin();

        /**
         * Row 1
         */
        $count_kasus = $datas['count_kasus'];
        $count_kasus_lama = $datas['count_kasus_lama'];
        $count_kasus_this_y = $datas['count_kasus_this_y'];
        $percent_done = $datas['percent_done'];

        /**
         * Row 2
         */
        $arr_month_progress = $datas['arrMonthProgress'];
        $arr_month_done = $datas['arrMonthDone'];

        /**
         * Row 3
         */
        $index_jenis_kejahatans = $datas['index_jenis_kejahatans'];
        $index_satker_polda     = $datas['index_satker_polda'];
        $indexsatker_polres     = $datas['index_satker_polres'];
        $index_satker_polsek    = $datas['index_satker_polsek'];
        
      }else{ // untuk user admin

        $datas = (new DashboardService())->roleAdmin();
        /**
         * Row 1
         */
        $count_kasus = $datas['count_kasus'];
        $count_kasus_lama = $datas['count_kasus_lama'];
        $count_kasus_this_y = $datas['count_kasus_this_y'];
        $percent_done = $datas['percent_done'];

        /**
         * Row 2
         */
        $arr_month_progress = $datas['arrMonthProgress'];
        $arr_month_done = $datas['arrMonthDone'];

        /**
         * Row 3
         */
        $index_jenis_kejahatans = $datas['index_jenis_kejahatans'];
        $index_satker_polda     = $datas['index_satker_polda'];
        $indexsatker_polres     = $datas['index_satker_polres'];
        $index_satker_polsek    = $datas['index_satker_polsek'];

      }

      // dd($arr_month_progress);

      return view('admin.admin', compact(
        'year',
        'count_kasus',
        'count_kasus_lama',
        'count_kasus_this_y',
        'percent_done',
        'arr_month_progress',
        'arr_month_done',
        'index_jenis_kejahatans',
        'index_satker_polda',
        'indexsatker_polres',
        'index_satker_polsek'
      ));
    }

    public function filter(Request $request)
    {
      $jenispidanas = JenisPidana::orderBy('name', 'asc')->get();

      $login = Group::join('user_groups','user_groups.group_id','=','groups.id')
        ->where('user_groups.user_id', Auth::id())
        ->select('groups.name AS group')
        ->first();

      // array bulan
      $month = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desmber',
      ];

      // Data untuk role selain admin
      if($login->group != 'Admin')
      { // untuk user selain admin 
        $kategori_bagians = Akses::select('kategori_bagians.id', 'kategori_bagians.name')
          ->leftJoin('kategori_bagians', 'kategori_bagians.id', '=', 'akses.sakter_id')
          ->where('akses.user_id', Auth::user()->id)
          ->get();
        $datas = (new DashboardFilterService())->roleNotAdmin($request);
      }else{ // untuk user admin
        /** kebutuhan filter */
        $kategori_bagians = KategoriBagian::orderBy('name', 'asc')->get();
        $datas = (new DashboardFilterService())->roleAdmin($request);
      }

      // filter
      $satker_param = $datas['satker_param'];
      $jenis_kasus_param = $datas['jenis_kasus_param'];
      $tahun_param = $datas['tahun_param'];
      $divisi_param = $datas['divisi_param'];
      $bulan_param = $datas['bulan_param'];

      /**
       * Row 3
       */
      $petas = $datas['petas'];
      $count_kasus_f_map = $datas['count_kasus_f_map'];
      $count_kasus_belum_f_map = $datas['count_kasus_belum_f_map'];
      $count_kasus_selesai_f_map = $datas['count_kasus_selesai_f_map'];
      $percent_done_f_map = $datas['percent_done_f_map'];

      /**
       * Row 4
       */
      $top_kasus_filter = $datas['top_kasus_filter'];
      $top_kasus_satker_polda_filter = $datas['top_kasus_satker_polda_filter'];
      $top_kasus_satker_polres_filter = $datas['top_kasus_satker_polres_filter'];
      $top_kasus_satker_polsek_filter = $datas['top_kasus_satker_polsek_filter'];
      $arr_month_progress = $datas['arrMonthProgress'];
      $arr_month_done = $datas['arrMonthDone'];

      return view('admin.admin-lihat-data', compact(
        'satker_param',
        'jenis_kasus_param',
        'tahun_param',
        'bulan_param',
        'divisi_param',
        'kategori_bagians',
        'jenispidanas',
        'count_kasus_f_map',
        'count_kasus_belum_f_map',
        'count_kasus_selesai_f_map',
        'percent_done_f_map',
        'petas',
        'top_kasus_filter',
        'top_kasus_satker_polda_filter',
        'top_kasus_satker_polres_filter',
        'top_kasus_satker_polsek_filter',
        'arr_month_progress',
        'arr_month_done'
      ));
    }

    public function export_excel(Request $request)
    {
      $arr = [$request->satker_selected, $request->pidana_selected, $request->mode];
      $b = implode(", ",$arr);

      return Excel::download(new PerkaraExport($b), 'rekapitulasi.xlsx');
    }

    public function profil(Request $request)
    {
      $count_kasus = Perkara::where('user_id', Auth::user()->id)->count();
      $count_kasus_selesai = Perkara::where('user_id', Auth::user()->id)->where('status_id', '!=', 1)->count();
      if($count_kasus > 0){
        $persentase = ($count_kasus_selesai / $count_kasus)*100;
        $english_format_number = number_format($persentase);
      }else{
        $english_format_number = 0;
      }

      $aktifitas = Perkara::orderBy('updated_at', 'desc')
                    ->leftJoin('jenis_pidanas', 'jenis_pidanas.id', '=', 'perkaras.jenis_pidana')
                    ->leftJoin('kategori_bagians', 'kategori_bagians.id', '=', 'perkaras.kategori_bagian_id')
                    ->leftJoin('korbans', 'korbans.no_lp', '=', 'perkaras.no_lp')
                    ->select(
                                'jenis_pidanas.name as pidana',
                                'kategori_bagians.name as satuan',
                                'korbans.nama',
                                'korbans.barang_bukti',
                                'perkaras.*'
                            )
                    ->where('user_id', Auth::user()->id)
                    ->paginate(10);

      // data group perbulan selesai
      $januari = Perkara::where('user_id', Auth::user()->id)
            ->whereYear('date', date('Y'))
            ->whereMonth('date', '=', '01')
            ->where('status_id', '!=', 1)
            ->count();

      $februari = Perkara::where('user_id', Auth::user()->id)
            ->whereYear('date', date('Y'))
            ->whereMonth('date', '=', '02')
            ->where('status_id', '!=', 1)
            ->count();

      $maret = Perkara::where('user_id', Auth::user()->id)
            ->whereYear('date', date('Y'))
            ->whereMonth('date', '=', '03')
            ->where('status_id', '!=', 1)
            ->count();

      $april = Perkara::where('user_id', Auth::user()->id)
            ->whereYear('date', date('Y'))
            ->whereMonth('date', '=', '04')
            ->where('status_id', '!=', 1)
            ->count();

      $mei = Perkara::where('user_id', Auth::user()->id)
            ->whereYear('date', date('Y'))
            ->whereMonth('date', '=', '05')
            ->where('status_id', '!=', 1)
            ->count();

      $juni = Perkara::where('user_id', Auth::user()->id)
            ->whereYear('date', date('Y'))
            ->whereMonth('date', '=', '06')
            ->where('status_id', '!=', 1)
            ->count();

      $juli = Perkara::where('user_id', Auth::user()->id)
            ->whereYear('date', date('Y'))
            ->whereMonth('date', '=', '07')
            ->where('status_id', '!=', 1)
            ->count();

      $agustus = Perkara::where('user_id', Auth::user()->id)
            ->whereYear('date', date('Y'))
            ->whereMonth('date', '=', '08')
            ->where('status_id', '!=', 1)
            ->count();

      $september = Perkara::where('user_id', Auth::user()->id)
            ->whereYear('date', date('Y'))
            ->whereMonth('date', '=', '09')
            ->where('status_id', '!=', 1)
            ->count();

      $oktober = Perkara::where('user_id', Auth::user()->id)
            ->whereYear('date', date('Y'))
            ->whereMonth('date', '=', '10')
            ->where('status_id', '!=', 1)
            ->count();

      $november = Perkara::where('user_id', Auth::user()->id)
            ->whereYear('date', date('Y'))
            ->whereMonth('date', '=', '11')
            ->where('status_id', '!=', 1)
            ->count();

      $desember = Perkara::where('user_id', Auth::user()->id)
            ->whereYear('date', date('Y'))
            ->whereMonth('date', '=', '12')
            ->where('status_id', '!=', 1)
            ->count();

      // data group perbulan blm selesai
      $belum_januari = Perkara::where('user_id', Auth::user()->id)
            ->whereYear('date', date('Y'))
            ->whereMonth('date', '=', '01')
            ->where('status_id', '=', 1)
            ->count();

      $belum_februari = Perkara::where('user_id', Auth::user()->id)
            ->whereYear('date', date('Y'))
            ->whereMonth('date', '=', '02')
            ->where('status_id', '=', 1)
            ->count();

      $belum_maret = Perkara::where('user_id', Auth::user()->id)
            ->whereYear('date', date('Y'))
            ->whereMonth('date', '=', '03')
            ->where('status_id', '=', 1)
            ->count();

      $belum_april = Perkara::where('user_id', Auth::user()->id)
            ->whereYear('date', date('Y'))
            ->whereMonth('date', '=', '04')
            ->where('status_id', '=', 1)
            ->count();

      $belum_mei = Perkara::where('user_id', Auth::user()->id)
            ->whereYear('date', date('Y'))
            ->whereMonth('date', '=', '05')
            ->where('status_id', '=', 1)
            ->count();

      $belum_juni = Perkara::where('user_id', Auth::user()->id)
            ->whereYear('date', date('Y'))
            ->whereMonth('date', '=', '06')
            ->where('status_id', '=', 1)
            ->count();

      $belum_juli = Perkara::where('user_id', Auth::user()->id)
            ->whereYear('date', date('Y'))
            ->whereMonth('date', '=', '07')
            ->where('status_id', '=', 1)
            ->count();

      $belum_agustus = Perkara::where('user_id', Auth::user()->id)
            ->whereYear('date', date('Y'))
            ->whereMonth('date', '=', '08')
            ->where('status_id', '=', 1)
            ->count();

      $belum_september = Perkara::where('user_id', Auth::user()->id)
            ->whereYear('date', date('Y'))
            ->whereMonth('date', '=', '09')
            ->where('status_id', '=', 1)
            ->count();

      $belum_oktober = Perkara::where('user_id', Auth::user()->id)
            ->whereYear('date', date('Y'))
            ->whereMonth('date', '=', '10')
            ->where('status_id', '=', 1)
            ->count();

      $belum_november = Perkara::where('user_id', Auth::user()->id)
            ->whereYear('date', date('Y'))
            ->whereMonth('date', '=', '11')
            ->where('status_id', '=', 1)
            ->count();

      $belum_desember = Perkara::where('user_id', Auth::user()->id)
            ->whereYear('date', date('Y'))
            ->whereMonth('date', '=', '12')
            ->where('status_id', '=', 1)
            ->count();


      return view('admin.profile', compact(
                                  'belum_januari',
                                  'belum_februari',
                                  'belum_maret',
                                  'belum_april',
                                  'belum_mei',
                                  'belum_juni',
                                  'belum_juli',
                                  'belum_agustus',
                                  'belum_september',
                                  'belum_oktober',
                                  'belum_november',
                                  'belum_desember',
                                  'januari', 
                                  'februari', 
                                  'maret', 
                                  'april', 
                                  'mei', 
                                  'juni', 
                                  'juli', 
                                  'agustus', 
                                  'september', 
                                  'oktober', 
                                  'november', 
                                  'desember', 
                                  'count_kasus', 
                                  'count_kasus_selesai', 
                                  'english_format_number', 
                                  'aktifitas'));
    }

    public function listData(Request $request)
    {
      // use livewire
      // mode
      $mode = $request->mode;
      $params = array(
        'mode'        => $mode,
        'role'        => $this->role,
        'satker'      => $request->satker,
        'divisi'      => $request->divisi,
        'jenis_kasus' => $request->jenis_kasus,
        'tahun'       => $request->tahun,
        'bulan'       => $request->bulan
      );

      if($mode == 'total'){
        $title = 'Semua Data Kasus';
      }elseif($mode == 'tunggakan'){
        $title = 'Tunggakan Data Kasus (Sudah lewat 6 bulan)';
      }elseif($mode == 'perkara-tahun-ini'){
        $title = 'Semua Data Kasus Tahun '. $this->year;
      }elseif($mode == 'perkara-selesai'){
        $title = 'Data Kasus Selesai';
      }elseif($mode == 'perkara-progress'){
        $title = 'Data Kasus Progress';
      }

      return view('admin.perkara.from-dashboard.index',compact('title', 'params'));
    }

    // Fetch divisi
    public function getDivisi($id){
    	// cek apa polda, polres atau polsek
      $kategori_bagian = KategoriBagian::select('kategori_id')->where('id', $id)->first();

      if($kategori_bagian->kategori_id == 1){
        $divisi = [
          'Ditreskrimsus',
          'Ditreskrimum',
          'Ditresnarkoba'
        ];
      }elseif($kategori_bagian->kategori_id == 2){
        $divisi = [
          'Satreskrim',
          'Satnarkoba'
        ];
      }elseif($kategori_bagian->kategori_id == 3){
        $divisi = [
          'Unit Reskrim'
        ];
      }

      // Fetch Divisi
      $list_divisi['data'] = $divisi;
      return response()->json($list_divisi);
    }

}
