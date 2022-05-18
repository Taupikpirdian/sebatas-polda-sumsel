<div>
  <div class="container-fluid">
    <form action="#" method="post" wire:submit.prevent="validateData">
      @csrf
      <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-header">
                    Data Petugas
                </div>
                <div class="card-body content-scroll">
                    @if(Auth::user()->groups()->where("name", "=", "Admin")->first())
                      {{-- tidak dipakai lagi --}}
                    @endif

                    @if(Auth::user()->groups()->where("name", "=", "Polres")->first())
                      @include('livewire.perkara.component.form-polres')
                    @endif

                    @if(Auth::user()->groups()->where("name", "=", "Polsek")->first())
                      @include('livewire.perkara.component.form-polsek')
                    @endif

                    <div class="form-group">
                        <label class="form-label-required">Nama Petugas</label>
                        <input type="text" class="form-control" wire:model='nama_petugas' placeholder="Masukan Nama Petugas">
                        @error('nama_petugas') <span class="error color-red">{{ $message }} <i class="fas fa-exclamation"></i></span> @enderror
                    </div>

                    <div class="form-group">
                      <label class="form-label-required">Pangkat dan NRP</label>
                      <input type="text" class="form-control" wire:model='pangkat' placeholder="Masukan Pangkat dan NRP">
                      @error('pangkat') <span class="error color-red">{{ $message }} <i class="fas fa-exclamation"></i></span> @enderror
                    </div>

                    <div class="form-group">
                      <label class="form-label-required">No Telphone</label>
                      <input type="text" class="form-control" wire:model='no_tlp' placeholder="Masukan No Telphone Petugas">
                      @error('no_tlp') <span class="error color-red">{{ $message }} <i class="fas fa-exclamation"></i></span> @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm">
            <div class="card">
                <div class="card-header">
                    Data Kasus
                </div>
                <div class="card-body content-scroll">
                    <div class="form-group">
                        <label class="form-label-required">Nomer LP</label>
                        <input type="text" class="form-control" wire:model='no_lp' placeholder="Masukan Nomer LP">
                        @error('no_lp') <span class="error color-red">{{ $message }} <i class="fas fa-exclamation"></i></span> @enderror
                      </div>

                    <div class="form-group">
                      <label class="form-label-required">Tanggal Nomer LP</label>
                      <input type="date" class="form-control" wire:model='date_no_lp'/>
                      @error('date_no_lp') <span class="error color-red">{{ $message }} <i class="fas fa-exclamation"></i></span> @enderror
                    </div>

                    <div class="form-group">
                      <label class="form-label-required">Jenis Tindak Pidana</label>
                      <select wire:model='jenis_pidana' class="form-control">
                        <option value="" selected> Pilih Satker </option>
                        @foreach($jenis_pidanas as $key=>$jenis_pidana)
                        <option value="{{ $jenis_pidana->id }}">{{ $jenis_pidana->name }}</option>
                        @endforeach
                      </select>
                      @error('jenis_pidana') <span class="error color-red">{{ $message }} <i class="fas fa-exclamation"></i></span> @enderror
                    </div>

                    @if($is_narkoba == 1)
                      @include('livewire.perkara.component.form-drugs')
                    @endif

                    <div class="form-group">
                      <label class="form-label-required">Uraian Singkat Kejadian</label>
                      <textarea class="form-control" rows="3" wire:model='desc' placeholder="Masukan Uraian Singkat Kejadian"></textarea>
                      @error('desc') <span class="error color-red">{{ $message }} <i class="fas fa-exclamation"></i></span> @enderror
                    </div>

                    <div class="form-group">
                      <label class="form-label-required">Modus Operasi</label>
                      <textarea class="form-control" rows="3" wire:model='modus' placeholder="Masukan Modus Operasi"></textarea>
                      @error('modus') <span class="error color-red">{{ $message }} <i class="fas fa-exclamation"></i></span> @enderror
                    </div>

                    <div class="form-group">
                      <label class="form-label-required">Barang Bukti</label>
                      <input type="text" class="form-control" wire:model='barang_bukti' id="barang_bukti" placeholder="Masukan Barang Bukti">
                      @error('barang_bukti') <span class="error color-red">{{ $message }} <i class="fas fa-exclamation"></i></span> @enderror
                    </div>

                    <div class="form-group">
                      <label class="form-label-required">Tanggal Kejadian</label>
                      <input type="date" class="form-control" wire:model='date'/>
                      @error('date') <span class="error color-red">{{ $message }} <i class="fas fa-exclamation"></i></span> @enderror
                    </div>
      
                    <div class="form-group">
                      <label class="form-label-required">Waktu Kejadian</label>
                      <div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
                        <input type="time" class="form-control" id="time" wire:model='time' placeholder="Masukan Waktu Kejadian" autocomplete="off"> <span class="input-group-append"><span class="input-group-text"><i class="fa fa-clock-o"></i></span></span>
                      </div>
                      @error('time') <span class="error color-red">{{ $message }} <i class="fas fa-exclamation"></i></span> @enderror
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm">
          <div class="card">
              <div class="card-header form-label-required">
                  Data Pelaku
              </div>
              <div class="card-body content-scroll">
                  <div class="form-group">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pelakuModal" style="border-radius: 10px"><i class="fa fa-plus" aria-hidden="true"></i> Tambah</button>
                  </div>

                  @if(!$is_available_pelaku)
                  <label style="color: red"><i class="fas fa-exclamation-triangle"></i> Minimal terdapat satu data pelaku!</label>
                  @endif

                  <div class="form-group">
                    <table id="tech-companies-1" class="table table-striped">
                      <thead>
                        <tr>
                          <th style="width: 10px">#</th>
                          <th>Nama</th>
                          <th>Umur</th>
                          <th>Pendidikan</th>
                          <th>Pekerjaan</th>
                          <th>Asal</th>
                          <th style="width: 20px">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($array_pelaku as $key=>$value)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $value['name'] }}</td>
                            <td>{{ $value['umur'] }}</td>
                            <td>{{ $value['pendidikan'] }}</td>
                            <td>{{ $value['pekerjaan'] }}</td>
                            <td>{{ $value['asal'] }}</td>
                            <td>
                              <a type="button" wire:click.prevent="removePelaku({{ $key }})"><i style="color:red" class="fa fa-trash" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
              </div>
          </div>
        </div>

        <div class="col-sm">
          <div class="card">
              <div class="card-header">
                  Data Korban dan Saksi
              </div>
              <div class="card-body content-scroll">
                  @if($is_narkoba != 1)
                    @include('livewire.perkara.component.form-except-drugs')
                  @endif

                  <div class="form-group">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#saksiModal" style="border-radius: 10px"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Saksi</button>
                  </div>
                  <div class="form-group">
                    <table id="tech-companies-1" class="table table-striped">
                      <thead>
                        <tr>
                          <th style="width: 10px">#</th>
                          <th>Nama</th>
                          <th style="width: 20px">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($array_saksi as $key=>$value)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $value['name'] }}</td>
                            <td>
                              <a type="button" wire:click.prevent="removeSaksi({{ $key }})"><i style="color:red" class="fa fa-trash" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
              </div>
          </div>
        </div>
      </div>
      <!-- Row-->
      <div class="row">
          <div class="col-sm">
              <div class="card">
                  <div class="card-header">
                      Lokasi
                  </div>
                  <div class="card-body content-scroll-file">
                      <div class="row">
                          <div class="col-sm-12" wire:ignore>
                            <div id="map_create" style="width:100%;height:380px;"></div>
                            <p class="text-info mt-2" style="font-size:13"><i class="fas fa-exclamation-triangle"></i> Klik lokasi yang diinginkan pada maps untuk mendapatkan titik koordinat (Akan secara otomatis terisi pada form lat dan long)</p>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label for="lat" class="form-label-required">Latitude</label>
                              <input type="text" class="form-control" wire:model='lat' id="lat" placeholder="Masukan Latitude" readonly="readonly">
                              @error('lat') <span class="error color-red">{{ $message }} <i class="fas fa-exclamation"></i></span> @enderror
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label for="long" class="form-label-required">Longitude</label>
                              <input type="text" class="form-control" wire:model='long' id="long" placeholder="Masukan Longitude" readonly="readonly">
                              @error('long') <span class="error color-red">{{ $message }} <i class="fas fa-exclamation"></i></span> @enderror
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label class="form-label-required">Klasifikasi TKP</label>
                              <div class="input-group">
                                <select class="form-control" wire:model='tkp'>
                                    <option value="">=== Pilih Salah Satu ===</option>
                                    <option value="Rumah / Pemukiman" @if(old('tkp') == 'Rumah / Pemukiman') selected @endif>1. Rumah / Pemukiman</option>
                                    <option value="Perkantoran" @if(old('tkp') == 'Perkantoran') selected @endif>2. Perkantoran</option>
                                    <option value="Pasar / Pertokoan" @if(old('tkp') == 'Pasar / Pertokoan') selected @endif>3. Pasar / Pertokoan</option>
                                    <option value="Restoran" @if(old('tkp') == 'Restoran') selected @endif>4. Restoran</option>
                                    <option value="Sekolah / Universitas" @if(old('tkp') == 'Sekolah') selected @endif>5. Sekolah / Universitas</option>
                                    <option value="Tempat Ibadah" @if(old('tkp') == 'Tempat Ibadah') selected @endif>6. Tempat Ibadah</option>
                                    <option value="Lain - lain" @if(old('tkp') == 'Lain - lain') selected @endif>7. Lain - lain</option>
                                </select>
                              </div>
                              @error('tkp') <span class="error color-red">{{ $message }} <i class="fas fa-exclamation"></i></span> @enderror
                            </div>
                          </div>
                      </div>
                  </div>
                  <div class="card-header">
                      <div class="row">
                          <div class="col-sm">
                              <a href="{{ url()->previous() }}" class="btn btn-warning btn-icon text-white">
                                  <span>
                                      <i class="fe fe-log-in"></i>
                                  </span> Kembali
                              </a>
                              <button type="submit" class="btn btn-success btn-icon text-white me-2"><i class="fe fe-plus"></i> Submit</button>
                          </div>
                      </div>
                      @if (count($errors) > 0)
                      <div class="row mt-2">
                        <div class="col-sm">
                          <span class="error color-red"><i class="fas fa-exclamation-triangle"></i> Terdapat kesalahan input data, harap cek kembali form isian!</span>
                        </div>
                      </div>
                      @endif
                  </div>
              </div>
          </div>
      </div>
      {{-- modal --}}
    @include('livewire.perkara.component.modal-pelaku')
    @include('livewire.perkara.component.modal-saksi')
    </form>
    <!-- end row -->
  </div>
</div>
@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYiwleTNi8Ww0Un6Jna9LuQyWGvdFYEcI&callback=initMapStore"
async defer></script>
<script>
  function initMapStore(){
      // Map options
      var options = {
          zoom:8,
          center:{lat:-2.974166680534421,lng:104.76982727107811}
      }
      // New Map
      var peta = new 
      google.maps.Map(document.getElementById('map_create'), options);
      google.maps.event.addListener(peta, 'click', function( event ){
        var lat = function() {
          return event.latLng.lat();    
        };
        var long = function() {
          return event.latLng.lng();    
        };
        document.getElementById('lat').value = lat();
        document.getElementById('long').value = long();
        @this.set('lat', lat());
        @this.set('long', long());
      });
  }

  $(function(){
      $('#date_no_lp').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayHighlight: true,
        }).on('change', function(e){
        @this.set('date_no_lp', $('#date_no_lp').val());
      });
  });

  $(function(){
      $('#date').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayHighlight: true,
        }).on('change', function(e){
        @this.set('date', $('#date').val());
      });
  });

  $(document).ready(function() {
      var max_fields_limit      = 8; //set limit for maximum input fields
      var x = 1; //initialize counter for text box
      $('#qty').hide();
      $('#jenis_narkoba').hide();
      $('.add_more_button').click(function(e){ //click event on add more fields button having class add_more_button
          e.preventDefault();
          if(x < max_fields_limit){ //check conditions
              x++; //counter increment
              $('.input_fields_container_part').append('<div><input type="text" class="form-control" wire:model="saksi.name" placeholder="Masukan Nama Saksi Lain" required><a href="#" class="remove_field" style="margin-left:10px;">Remove</a></div>'); //add input field
          }
      });  
      $('.input_fields_container_part').on("click",".remove_field", function(e){ //user click on remove text links
          e.preventDefault(); $(this).parent('div').remove(); x--;
      })
  });

  $(document).ready(function() {
      var max_fields_limit      = 8; //set limit for maximum input fields
      var x = 1; //initialize counter for text box
      $('.add_more_button_2').click(function(e){ //click event on add more fields button having class add_more_button
          e.preventDefault();
          if(x < max_fields_limit){ //check conditions
              x++; //counter increment
              $('.input_fields_container_part_2').append('<div><input type="text" class="form-control" name="pelaku[][Nama]" placeholder="Masukan Nama Pelaku Lain" required><input type="number" class="form-control" name="pelaku[][Umur]" placeholder="Masukan Umur Pelaku Lain" required><select class="form-control" name="pelaku[][Pendidikan]" required><option value="">=== Pilih Salah Satu Pendidikan ===</option><option value="SD/Sederajat">SD/Sederajat</option><option value="SMP/Sederajat">SMP/Sederajat</option><option value="SMA/SMK/Sederajat">SMA/SMK/Sederajat</option><option value="D3/Sarjana Muda/Sederajat">D3/Sarjana Muda/Sederajat</option><option value="S1/Sarjana">S1/Sarjana</option><option value="S2/Master">S2/Master</option><option value="S3/Doktor">S3/Doktor</option><option value="Lainnya">Lainnya</option></select><select class="form-control" name="pelaku[][Pekerjaan]" required><option value="">=== Pilih Salah Satu Pekerjaan ===</option><option value="Pegawai Negeri Sipil">1. Pegawai Negeri Sipil</option><option value="Karyawan Swasta">2. Karyawan Swasta</option><option value="Mahasiswa / Pelajar">3. Mahasiswa / Pelajar</option><option value="TNI">4. TNI</option><option value="Polri">5. Polri</option><option value="Pengangguran">6. Pengangguran</option><option value="Lain - lain">7. Lain - lain</option></select><input type="text" class="form-control" name="pelaku[][Asal]" placeholder="Masukan Tempat Asal Pelaku Lain" required><a href="#" class="remove_field" style="margin-left:10px;">Remove</a></div>'); //add input field
          }
      });  
      $('.input_fields_container_part_2').on("click",".remove_field", function(e){ //user click on remove text links
          e.preventDefault(); $(this).parent('div').remove(); x--;
      })
  });

  function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $('#blah')
            .attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
      }
  }

  setTimeout(function() {
      $('#alert-danger').fadeOut('fast');
  }, 7000);

  setTimeout(function() {
      $('#alert-warning').fadeOut('fast');
  }, 7000);

  $("#jenis_pidana").change(function() {
    if ($(this).val() == "32") {
      console.log($(this).val());
      $('#jenis_narkoba').show();
      $('#qty').show();
    } else {
      $('#jenis_narkoba').hide();
      $('#qty').hide();
    }
  });

  document.addEventListener('DOMContentLoaded', function () {
    window.livewire.on('closeModal', ($modal) => {
      $($modal).modal('hide');
    });

    window.livewire.on('sweetAlert', ($params) => {
      setTimeout(function(){
        Swal.fire({
          icon: $params.icon,
          title: $params.title,
          text: $params.text,
          confirmButtonClass: 'btn btn-primary',
          buttonsStyling: false,
        })
      }, 1000);
    });

    window.livewire.on('sweetAlertRedirect', ($params) => {
      Swal.fire({
        icon: $params.icon,
        title: $params.title,
        text: $params.text,
        confirmButtonClass: 'btn btn-primary',
        buttonsStyling: false,
      }).then(function() {
          window.location = $params.url;
      });
    });

    window.livewire.on('confirmSubmit', () => {
      setTimeout(function(){
        Swal.fire({
          title: 'Apakah Anda yakin akan menyimpan data ini?',
          text: "Harap cek kembali sampai Anda yakin!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya Simpan!',
          confirmButtonClass: 'btn btn-primary',
          cancelButtonClass: 'btn btn-danger ml-1',
          cancelButtonText: 'Cek Dahulu',
          buttonsStyling: false,
        }).then(function (result) {
          if (result.value) {
            window.livewire.emit('store');
          }
        });

      }, 1000);
    });

  });
</script>
@endpush