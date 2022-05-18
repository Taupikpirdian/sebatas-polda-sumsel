<div class="form-group">
    <label class="form-label-required">Satker</label>
    <select wire:model='satker_id' class="form-control">
      <option value="" selected> Pilih Satker </option>
      @foreach($satker as $key=>$satker_data)
      <option value="{{ $satker_data->id }}">{{ $satker_data->name }}</option>
      @endforeach
    </select>
</div>
<div class="form-group">
  <label class="form-label">Divisi</label>
  <select class="form-control selectpicker" wire:model='divisi' data-live-search="true" required>
    <option value="">=== Pilih Salah Satu ===</option>
    <option value="Ditreskrimsus" @if(old('divisi') == 'Ditreskrimsus') selected @endif>Ditreskrimsus</option>
    <option value="Ditreskrimum" @if(old('divisi') == 'Ditreskrimum') selected @endif>Ditreskrimum</option>
    <option value="Ditresnarkoba" @if(old('divisi') == 'Ditresnarkoba') selected @endif>Ditresnarkoba</option>
    <option value="Satreskrim" @if(old('divisi') == 'Satreskrim') selected @endif>Satreskrim</option>
    <option value="Satnarkoba" @if(old('divisi') == 'Satnarkoba') selected @endif>Satnarkoba</option>
    <option value="Unit Reskrim" @if(old('divisi') == 'Unit Reskrim') selected @endif>Unit Reskrim</option>
  </select>
</div>