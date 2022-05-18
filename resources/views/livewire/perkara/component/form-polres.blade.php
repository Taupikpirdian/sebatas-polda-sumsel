<div class="form-group">
  <label class="form-label-required">Satker</label>
  <select wire:model='satker_id' class="form-control" wire:ignore>
    <option value="" selected> Pilih Satker </option>
    @foreach($satker_not_admin as $key=>$satker)
    <option value="{{ $satker->id }}">{{ $satker->name }}</option>
    @endforeach
  </select>
  @error('satker_id') <span class="error color-red">{{ $message }} <i class="fas fa-exclamation"></i></span> @enderror
</div>