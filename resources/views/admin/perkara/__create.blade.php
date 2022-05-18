<div class="row">
  <div class="col-12">
      <div class="card">
        <div class="card-body">
            <div class="form-group">
            <label for="name">Nomer LP<label style="color: red">*</label></label>
              <input type="text" class="form-control" id="no_lp" name="no_lp" placeholder="Masukan Nomer LP" value="{{old('no_lp')}}" required>
              @error('no_lp')
                <div class="col-md-5 input-group mb-1" style="color:red">
                    {{ $message }}
                </div>
              @enderror
          </div>

          <div class="form-group">
            <label for="date">Tanggal Nomer LP<label style="color: red">*</label></label>
            <input type="text" class="form-control datepicker-here" data-language="en" id="date_no_lp" name="date_no_lp" value="{{old('date_no_lp')}}" readonly="readonly" required/>
            @error('date_no_lp')
              <div class="col-md-5 input-group mb-1" style="color:red">
                  {{ $message }}
              </div>
            @enderror
          </div> --}}

            @if(Auth::user()->groups()->where("name", "=", "Admin")->first())
          <div class="form-group">
            <label>Satker<label style="color: red">*</label></label>
            {{ Form::select('satker', $satker, null,['class' => 'form-control selectpicker', 'required' => 'required', 'data-live-search' => 'true']) }}
            <p style="color: red; font-size:13">Note: Jika satuan kerja yang anda maksud tidak tersedia, harap untuk menghubungi admin</p>
            @error('satker')
              <div class="col-md-5 input-group mb-1" style="color:red">
                  {{ $message }}
              </div>
            @enderror
          </div>

          <div class="form-group">
            <label>Divisi<label style="color: red">*</label></label>
            <div class="input-group">
              <select class="form-control selectpicker" name="divisi" data-live-search="true" required>
                  <option value="">=== Pilih Salah Satu ===</option>
                  <option value="Ditreskrimsus" @if(old('divisi') == 'Ditreskrimsus') selected @endif>Ditreskrimsus</option>
                  <option value="Ditreskrimum" @if(old('divisi') == 'Ditreskrimum') selected @endif>Ditreskrimum</option>
                  <option value="Ditresnarkoba" @if(old('divisi') == 'Ditresnarkoba') selected @endif>Ditresnarkoba</option>
                  <option value="Satreskrim" @if(old('divisi') == 'Satreskrim') selected @endif>Satreskrim</option>
                  <option value="Satnarkoba" @if(old('divisi') == 'Satnarkoba') selected @endif>Satnarkoba</option>
                  <option value="Unit Reskrim" @if(old('divisi') == 'Unit Reskrim') selected @endif>Unit Reskrim</option>
              </select>
              @error('divisi')
                <div class="col-md-5 input-group mb-1" style="color:red">
                    {{ $message }}
                </div>
              @enderror
            </div>
          </div>
          @endif

          @if(Auth::user()->groups()->where("name", "=", "Polres")->first())
          <div class="form-group">
            <label>Satker<label style="color: red">*</label></label>
            {{ Form::select('satker', $satker_not_admin, null,['class' => 'form-control selectpicker ', 'required' => 'required', 'data-live-search' => 'true']) }}
            <p style="color: red; font-size:13">Note: Jika satuan kerja yang anda maksud tidak tersedia, harap untuk menghubungi admin</p>
            @error('satker')
              <div class="col-md-5 input-group mb-1" style="color:red">
                  {{ $message }}
              </div>
            @enderror
          </div>
          @endif

          @if(Auth::user()->groups()->where("name", "=", "Polsek")->first())
          <div class="form-group">
            <label>Satker<label style="color: red">*</label></label>
            {{ Form::select('satker', $satker_not_admin, null,['class' => 'form-control selectpicker', 'required' => 'required', 'data-live-search' => 'true']) }}
            <p style="color: red; font-size:13">Note: Jika satuan kerja yang anda maksud tidak tersedia, harap untuk menghubungi admin</p>
            @error('satker')
              <div class="col-md-5 input-group mb-1" style="color:red">
                  {{ $message }}
              </div>
            @enderror
          </div>
          @endif --}}

            <div class="form-group">
            <label for="nama_petugas">Nama Petugas<label style="color: red">*</label></label>
            <input type="text" class="form-control" id="nama_petugas" name="nama_petugas" placeholder="Masukan Nama Petugas" value="{{old('nama_petugas')}}" required>
            @error('nama_petugas')
              <div class="col-md-5 input-group mb-1" style="color:red">
                  {{ $message }}
              </div>
            @enderror
          </div>

          <div class="form-group">
            <label for="pangkat">Pangkat dan NRP<label style="color: red">*</label></label>
            <input type="text" class="form-control" id="pangkat" name="pangkat" placeholder="Masukan Pangkat dan NRP" value="{{old('pangkat')}}" required>
            @error('pangkat')
              <div class="col-md-5 input-group mb-1" style="color:red">
                  {{ $message }}
              </div>
            @enderror
          </div> --}}

            <div class="form-group">
            <label for="no_tlp">No Telphone<label style="color: red">*</label></label>
            <input type="text" class="form-control" id="no_tlp" name="no_tlp" placeholder="Masukan No Telphone Petugas" value="{{old('no_tlp')}}" required>
            @error('no_tlp')
              <div class="col-md-5 input-group mb-1" style="color:red">
                  {{ $message }}
              </div>
            @enderror
          </div> --}}

            <div class="form-group">
            <label>Jenis Tindak Pidana<label style="color: red">*</label></label>
            {{ Form::select('jenis_pidana', $jenis_pidanas, null,['class' => 'form-control selectpicker', 'id' => 'jenis_pidana', 'required' => 'required', 'data-live-search' => 'true']) }}
            @error('jenis_pidana')
              <div class="col-md-5 input-group mb-1" style="color:red">
                  {{ $message }}
              </div>
            @enderror
          </div>
          
          @if($is_narkoba == 1)
          <div class="form-group">
            <label>Jenis Narkoba<label style="color: red">*</label></label>
            {{ Form::select('material', $type_narkoba, null,['class' => 'form-control selectpicker', 'data-live-search' => 'true', 'required' => 'required']) }}
            @error('material')
              <div class="col-md-5 input-group mb-1" style="color:red">
                  {{ $message }}
              </div>
            @enderror
          </div>

          <div class="form-group">
            <label>Berat (gram)<label style="color: red">*</label></label>
            <input type="number" class="form-control" name="qty" placeholder="Masukan Berat Narkoba" value="{{old('qty')}}" required>
            @error('qty')
              <div class="col-md-5 input-group mb-1" style="color:red">
                  {{ $message }}
              </div>
            @enderror
          </div>
          @endif

          <div class="form-group">
            <label>Uraian Singkat Kejadian<label style="color: red">*</label></label>
            <textarea class="form-control" rows="3" name="desc" placeholder="Masukan Uraian Singkat Kejadian" required>{{Request::old('desc')}}</textarea>
            @error('desc')
              <div class="col-md-5 input-group mb-1" style="color:red">
                  {{ $message }}
              </div>
            @enderror
          </div> --}}

            <div class="form-group">
            <label>Modus Operasi<label style="color: red">*</label></label>
            <textarea class="form-control" rows="3" name="modus" placeholder="Masukan Modus Operasi" required>{{Request::old('modus')}}</textarea>
            @error('modus')
              <div class="col-md-5 input-group mb-1" style="color:red">
                  {{ $message }}
              </div>
            @enderror
          </div> --}}

            <div class="form-group input_fields_container_part_2">
            <label for="saksi">Pelaku<label style="color: red">*</label></label>
            <input type="text" class="form-control" name="pelaku[][Nama]" placeholder="Masukan Nama Pelaku" required>
            <input type="number" class="form-control" name="pelaku[][Umur]" placeholder="Masukan Umur" required>
            <select class="form-control" name="pelaku[][Pendidikan]" required>
                <option value="">=== Pilih Salah Satu Pendidikan ===</option>
                <option value="SD/Sederajat">SD/Sederajat</option>
                <option value="SMP/Sederajat">SMP/Sederajat</option>
                <option value="SMA/SMK/Sederajat">SMA/SMK/Sederajat</option>
                <option value="D3/Sarjana Muda/Sederajat">D3/Sarjana Muda/Sederajat</option>
                <option value="S1/Sarjana">S1/Sarjana</option>
                <option value="S2/Master">S2/Master</option>
                <option value="S3/Doktor">S3/Doktor</option>
                <option value="Lainnya">Lainnya</option>
            </select>
            <select class="form-control" name="pelaku[][Pekerjaan]" required>
                <option value="">=== Pilih Salah Satu Pekerjaan ===</option>
                <option value="Pegawai Negeri Sipil">1. Pegawai Negeri Sipil</option>
                <option value="Karyawan Swasta">2. Karyawan Swasta</option>
                <option value="Mahasiswa / Pelajar">3. Mahasiswa / Pelajar</option>
                <option value="TNI">4. TNI</option>
                <option value="Polri">5. Polri</option>
                <option value="Pengangguran">6. Pengangguran</option>
                <option value="Lain - lain">7. Lain - lain</option>
            </select>

            <input type="text" class="form-control" name="pelaku[][Asal]" placeholder="Masukan Tempat Asal" required>
            <div class="btn btn-primary add_more_button_2">Tambah Pelaku</div>
          </div> --}}

            form untuk selain narkoba, get from kategori_jns_pidana --}}
            @if($is_narkoba != 1)
          <div class="form-group">
            <label for="nama_korban">Korban</label>
            <input type="text" class="form-control" id="nama_korban" name="nama_korban" placeholder="Masukan Nama Korban" value="{{old('nama_korban')}}">
            <input type="number" class="form-control" id="umur_korban" name="umur_korban" placeholder="Masukan Umur Korban" value="{{old('umur_korban')}}">
            <select class="form-control" name="pendidikan_korban">
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
            <select class="form-control" name="pekerjaan_korban">
                  <option value="">=== Pilih Salah Satu Pekerjaan ===</option>
                  <option value="Pegawai Negeri Sipil" @if(old('pekerjaan_korban') == 'Pegawai Negeri Sipil') selected @endif>1. Pegawai Negeri Sipil</option>
                  <option value="Karyawan Swasta" @if(old('pekerjaan_korban') == 'Karyawan Swasta') selected @endif>2. Karyawan Swasta</option>
                  <option value="Mahasiswa / Pelajar" @if(old('pekerjaan_korban') == 'Mahasiswa / Pelajar') selected @endif>3. Mahasiswa / Pelajar</option>
                  <option value="TNI" @if(old('pekerjaan_korban') == 'TNI') selected @endif>4. TNI</option>
                  <option value="Polri" @if(old('pekerjaan_korban') == 'Polri') selected @endif>5. Polri</option>
                  <option value="Pengangguran" @if(old('pekerjaan_korban') == 'Pengangguran') selected @endif>6. Pengangguran</option>
                  <option value="Lain - lain" @if(old('pekerjaan_korban') == 'Lain - lain') selected @endif>7. Lain - lain</option>
            </select>
            <input type="text" class="form-control" id="asal_korban" name="asal_korban" placeholder="Masukan Tempat Asal Korban" value="{{old('asal_korban')}}">
          </div>
          @endif --}}

            <div class="form-group input_fields_container_part">
              <label for="saksi">Saksi</label>
              <input type="text" class="form-control" name="saksi[]" placeholder="Masukan Nama Saksi">
              <div class="btn btn-primary add_more_button">Tambah Saksi</div>
          </div> --}}

            <div class="form-group">
            <label for="name">Barang Bukti<label style="color: red">*</label></label>
            <input type="text" class="form-control" id="barang_bukti" name="barang_bukti" placeholder="Masukan Barang Bukti" value="{{old('barang_bukti')}}" required>
            @error('barang_bukti')
              <div class="col-md-5 input-group mb-1" style="color:red">
                  {{ $message }}
              </div>
            @enderror
          </div> --}}

            <div class="form-group">
            <label>Klasifikasi TKP<label style="color: red">*</label></label>
            <div class="input-group">
              <select class="form-control" name="tkp" required>
                  <option value="">=== Pilih Salah Satu ===</option>
                  <option value="Rumah / Pemukiman" @if(old('tkp') == 'Rumah / Pemukiman') selected @endif>1. Rumah / Pemukiman</option>
                  <option value="Perkantoran" @if(old('tkp') == 'Perkantoran') selected @endif>2. Perkantoran</option>
                  <option value="Pasar / Pertokoan" @if(old('tkp') == 'Pasar / Pertokoan') selected @endif>3. Pasar / Pertokoan</option>
                  <option value="Restoran" @if(old('tkp') == 'Restoran') selected @endif>4. Restoran</option>
                  <option value="Sekolah / Universitas" @if(old('tkp') == 'Sekolah') selected @endif>5. Sekolah / Universitas</option>
                  <option value="Tempat Ibadah" @if(old('tkp') == 'Tempat Ibadah') selected @endif>6. Tempat Ibadah</option>
                  <option value="Lain - lain" @if(old('tkp') == 'Lain - lain') selected @endif>7. Lain - lain</option>
              </select>
              @error('tkp')
                <div class="col-md-5 input-group mb-1" style="color:red">
                    {{ $message }}
                </div>
              @enderror
            </div>
          </div> --}}

            <div id="map_create" style="width:100%;height:380px;"></div>
          <p style="color: red; font-size:13">Note: Klik lokasi yang diinginkan pada maps untuk mendapatkan titik koordinat (Akan secara otomatis terisi pada form lat dan long)</p>
          <div class="form-group">
            <label for="lat">Latitude<label style="color: red">*</label></label>
            <input type="text" class="form-control" id="lat" placeholder="Masukan Latitude" value="{{old('lat')}}" disabled>
            @error('lat')
              <div class="col-md-5 input-group mb-1" style="color:red">
                  {{ $message }}
              </div>
            @enderror
          </div>

          <div class="form-group">
            <label for="long">Longitude<label style="color: red">*</label></label>
            <input type="text" class="form-control" id="long" placeholder="Masukan Longitude" value="{{old('long')}}" disabled>
            @error('long')
                <div class="col-md-5 input-group mb-1" style="color:red">
                    {{ $message }}
                </div>
              @enderror
          </div>

          <div class="form-group" style="display: none;">
            <label for="lat">Latitude<label style="color: red">*</label></label>
            <input type="text" class="form-control" name="lat" id="latInput" placeholder="Masukan Latitude" value="{{old('lat')}}">
          </div>

          <div class="form-group" style="display: none;">
            <label for="long">Longitude<label style="color: red">*</label></label>
            <input type="text" class="form-control" name="long" id="longInput" placeholder="Masukan Longitude" value="{{old('long')}}">
          </div>

          <div class="form-group">
            <label for="date">Tanggal Kejadian<label style="color: red">*</label></label>
            <input type="text" class="form-control datepicker-here" data-language="en" id="date" name="date" value="{{old('date')}}" readonly="readonly" required/>
            @error('date')
              <div class="col-md-5 input-group mb-1" style="color:red">
                  {{ $message }}
              </div>
            @enderror
          </div>

          <div class="form-group">
            <label>Waktu Kejadian<label style="color: red">*</label></label>
            <div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
              <input type="time" class="form-control" id="time" name="time" placeholder="Masukan Waktu Kejadian" value="{{old('time')}}" autocomplete="off" required> <span class="input-group-append"><span class="input-group-text"><i class="fa fa-clock-o"></i></span></span>
              @error('time')
                <div class="col-md-5 input-group mb-1" style="color:red">
                    {{ $message }}
                </div>
              @enderror
            </div>
          </div>

          <div class="mt-4">
              <a title="Kembali" href="{{ url()->previous() }}" style="margin-right:20px;" class="btn btn-info waves-effect waves-light"><i class="fa fa-arrow-left" aria-hidden="true"></i>   Kembali</a>
              <button class="btn btn-primary waves-effect waves-light" type="submit">Submit</button>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
  </div>
  <!-- end col -->
</div>