<h4>KEPOLISIAN REPUBLIK INDONESIA</h4>
<h4>DAERAH SUMATERA SELATAN</h4>
<h4>STAFF PRIBADI PIMPINAN</h4>
<br>
<h4>REKAP KEAKTIFAN PENGINPUTAN DATA KRIMINALITAS PADA APLIKASI MAPPING CRIME</h4>
<table class="table table-bordered" style="font-size:14px;">
  <thead >                  
    <tr>
      <th rowspan="2" style="width: 10px; text-align: center;">#</th>
      <th rowspan="2" style="width: 50px; text-align: center;">SATKER/SATWIL/DIVISI</th>
      <th colspan="4" style="width: 50px; text-align: center;">JUMLAH LAPORAN POLISI</th>
    </tr>
    <tr>
      <th style="width: 20px; text-align: center;">Kasus Selesai</th>
      <th style="width: 20px; text-align: center;">Kasus Belum Selesai</th>
      <th style="width: 20px; text-align: center;">Jumlah Kasus</th>
      <th style="width: 20px; text-align: center;">Persentase Selesai</th>
    </tr>
  </thead>
  <tbody>
    @foreach($rekaps as $i=>$rekap)
      <tr>
        <td>{{ $i + 1 }}</td>
        <td>{{ $rekap->name }}</td>
        <td><span class="badge bg-danger">{{ $rekap->kasus_selesai }}</span></td>
        <td><span class="badge bg-danger">{{ $rekap->kasus_progress }}</span></td>
        <td><span class="badge bg-danger">{{ $rekap->total }}</span></td>
        <td><span class="badge bg-danger">{{ $rekap->kasus_selesai > 0 ? number_format(($rekap->kasus_selesai/$rekap->total)*100) : 0 }}%</span></td>
      </tr>
    @endforeach
  </tbody>
</table>