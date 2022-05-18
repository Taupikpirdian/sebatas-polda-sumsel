<div class="form-group">
  <label class="form-label-required">Satker</label>
  <select wire:model='satker_id' class="form-control">
    <option value="" selected> Pilih Satker </option>
    @foreach($satker_not_admin as $key=>$satker)
    <option value="{{ $satker->id }}">{{ $satker->name }}</option>
    @endforeach
  </select>
  <p style="color: red; font-size:13">Note: Jika satuan kerja yang anda maksud tidak tersedia, harap untuk menghubungi admin</p>
</div>