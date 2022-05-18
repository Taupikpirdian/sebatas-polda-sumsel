<div class="form-group">
  <label class="form-label-required">Jenis Narkoba</label>
  <select wire:model='material' class="form-control">
    <option value="" selected> Pilih Satker </option>
    @foreach($type_narkoba as $key=>$data)
    <option value="{{ $data->id }}">{{ $data->name }}</option>
    @endforeach
  </select>
  @error('material') <span class="error color-red">{{ $message }} <i class="fas fa-exclamation"></i></span> @enderror
</div>

<div class="form-group">
  <label class="form-label-required">Berat (gram)</label>
  <input type="number" class="form-control" wire:model='qty' placeholder="Masukan Berat Narkoba">
  @error('qty') <span class="error color-red">{{ $message }} <i class="fas fa-exclamation"></i></span> @enderror
</div>