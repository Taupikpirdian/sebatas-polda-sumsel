<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Services\TotalKejahatanService;
use App\Services\TunggakanKejahatanService;
use App\Services\TahunIniKejahatanService;
use App\Services\SelesaiKejahatanService;
use App\Services\ProgressKejahatanService;
use Livewire\WithPagination;

class PerkaraModal extends Component
{
    use WithPagination;

    public $mode, $role, $satker, $divisi, $jenis_kasus, $tahun, $bulan;

    public $perPage;
    public $query_no_lp     = '';
    public $query_tgl_lp    = '';
    public $query_satker    = '';
    public $query_petugas   = '';
    public $query_korban    = '';
    public $query_bukti     = '';
    public $query_kejadian  = '';
    public $query_pidana    = '';
    public $query_status    = '';
    public $query_daterange = '';

    public function mount($params)
    {
      $this->mode         = $params['mode'];
      $this->role         = $params['role'];
      $this->satker       = $params['satker'];
      $this->divisi       = $params['divisi'];
      $this->jenis_kasus  = $params['jenis_kasus'];
      $this->tahun        = $params['tahun'];
      $this->bulan        = $params['bulan'];

      $this->perPage   = 10;
    }

    public function render()
    {
      // filter data
      $param = [
        'query_no_lp'       => $this->query_no_lp,
        'query_tgl_lp'      => $this->query_tgl_lp,
        'query_satker'      => $this->query_satker,
        'query_petugas'     => $this->query_petugas,
        'query_korban'      => $this->query_korban,
        'query_bukti'       => $this->query_bukti,
        'query_kejadian'    => $this->query_kejadian,
        'query_pidana'      => $this->query_pidana,
        'query_status'      => $this->query_status,
        'query_daterange'   => $this->query_daterange,
        'satker'            => $this->satker,
        'divisi'            => $this->divisi,
        'jenis_kasus'       => $this->jenis_kasus,
        'tahun'             => $this->tahun,
        'bulan'             => $this->bulan
      ];

      if($this->mode == 'total'){
        if($this->role == 'Admin'){
          $datas = (new TotalKejahatanService())->roleAdmin($this->perPage, $param);
        }else{
          $datas = (new TotalKejahatanService())->roleNotAdmin($this->perPage, $param);
        }
      }elseif($this->mode == 'tunggakan'){
        if($this->role == 'Admin'){
          $datas = (new TunggakanKejahatanService())->roleAdmin($this->perPage, $param);
        }else{
          $datas = (new TunggakanKejahatanService())->roleNotAdmin($this->perPage, $param);
        }
      }elseif($this->mode == 'perkara-tahun-ini'){
        if($this->role == 'Admin'){
          $datas = (new TahunIniKejahatanService())->roleAdmin($this->perPage, $param);
        }else{
          $datas = (new TahunIniKejahatanService())->roleNotAdmin($this->perPage, $param);
        }
      }elseif($this->mode == 'perkara-selesai'){
        if($this->role == 'Admin'){
          $datas = (new SelesaiKejahatanService())->roleAdmin($this->perPage, $param);
        }else{
          $datas = (new SelesaiKejahatanService())->roleNotAdmin($this->perPage, $param);
        }
      }elseif($this->mode == 'perkara-progress'){
        if($this->role == 'Admin'){
          $datas = (new ProgressKejahatanService())->roleAdmin($this->perPage, $param);
        }else{
          $datas = (new ProgressKejahatanService())->roleNotAdmin($this->perPage, $param);
        }
      }

      $this->page > $datas->lastPage() ? $this->page = $datas->lastPage() : true;
      $count  = $datas->count();
      // for calculate the current display of paginated content
      $limit  = $datas->perPage();
      $page   = $datas->currentPage();
      $total  = $datas->total();

      $upper = min( $total, $page * $limit);
      if($count == 0){
          $lower = 0;
      }else{
          $lower = ($page - 1) * $limit + 1;
      }
      $paginate_content = "Showing $lower to $upper of $total";
      
      return view('livewire.dashboard.perkara-modal', compact('datas', 'paginate_content'));
    }
}
