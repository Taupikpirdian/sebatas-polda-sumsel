<div class="form-group">
  <label class="form-label">Korban</label>
  <input type="text" class="form-control" wire:model='nama_korban' id="nama_korban" placeholder="Masukan Nama Korban">
  <input type="number" class="form-control" wire:model='umur_korban' id="umur_korban" placeholder="Masukan Umur Korban">
  <select class="form-control" wire:model='pendidikan_korban'>
        <option value="">=== Pilih Salah Satu Pendidikan ===</option>
        <option value="SD/Sederajat" @if(old('pendidikan_korban') == 'SD/Sederajat') selected @endif>SD/Sederajat</option>
        <option value="SMP/Sederajat" @if(old('pendidikan_korban') == 'SMP/Sederajat') selected @endif>SMP/Sederajat</option>
        <option value="SMA/SMK/Sederajat" @if(old('pendidikan_korban') == 'SMA/SMK/Sederajat') selected @endif>SMA/SMK/Sederajat</option>
        <option value="D3/Sarjana Muda/Sederajat" @if(old('pendidikan_korban') == 'D3/Sarjana Muda/Sederajat') selected @endif>D3/Sarjana Muda/Sederajat</option>
        <option value="S1/Sarjana" @if(old('pendidikan_korban') == 'S1/Sarjana') selected @endif>S1/Sarjana</option>
        <option value="S2/Master" @if(old('pendidikan_korban') == 'S2/Master') selected @endif>S2/Master</option>
        <option value="S3/Doktor" @if(old('pendidikan_korban') == 'S3/Doktor') selected @endif>S3/Doktor</option>
        <option value="Lainnya" @if(old('pendidikan_korban') == 'Lainnya') selected @endif>Lainnya</option>
  </select>
  <select class="form-control" wire:model='pekerjaan_korban'>
        <option value="">=== Pilih Salah Satu Pekerjaan ===</option>
        <option value="Pegawai Negeri Sipil" @if(old('pekerjaan_korban') == 'Pegawai Negeri Sipil') selected @endif>1. Pegawai Negeri Sipil</option>
        <option value="Karyawan Swasta" @if(old('pekerjaan_korban') == 'Karyawan Swasta') selected @endif>2. Karyawan Swasta</option>
        <option value="Mahasiswa / Pelajar" @if(old('pekerjaan_korban') == 'Mahasiswa / Pelajar') selected @endif>3. Mahasiswa / Pelajar</option>
        <option value="TNI" @if(old('pekerjaan_korban') == 'TNI') selected @endif>4. TNI</option>
        <option value="Polri" @if(old('pekerjaan_korban') == 'Polri') selected @endif>5. Polri</option>
        <option value="Pengangguran" @if(old('pekerjaan_korban') == 'Pengangguran') selected @endif>6. Pengangguran</option>
        <option value="Lain - lain" @if(old('pekerjaan_korban') == 'Lain - lain') selected @endif>7. Lain - lain</option>
  </select>
  <input type="text" class="form-control" wire:model='asal_korban' id="asal_korban" placeholder="Masukan Tempat Asal Korban">
</div>