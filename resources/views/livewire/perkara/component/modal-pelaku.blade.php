<div wire:ignore.self class="modal fade" id="pelakuModal" tabindex="-1" role="dialog" aria-labelledby="pelakuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pelakuModalLabel">Tambah Data Pelaku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
           <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Nama</label>
                        <input type="text" class="form-control" wire:model='nama_pelaku' placeholder="Masukan Nama Pelaku">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Umur</label>
                        <input type="number" class="form-control" wire:model='umur_pelaku' placeholder="Masukan Umur">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Pendidikan</label>
                        <select class="form-control" wire:model='pendidikan_pelaku'>
                            <option value="">=== Pilih Salah Satu Pendidikan ===</option>
                            @foreach($pendidikans as $key=>$value)
                            <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Pekerjaan</label>
                        <select class="form-control" wire:model='pekerjaan_pelaku'>
                            <option value="">=== Pilih Salah Satu Pekerjaan ===</option>
                            @foreach($jobs as $key=>$value)
                            <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Asal</label>
                        <input type="text" class="form-control" wire:model='asal_pelaku' placeholder="Masukan Tempat Asal">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                <button type="button" wire:click.prevent="addPelaku()" class="btn btn-primary close-modal">Tambah</button>
            </div>
        </div>
    </div>
</div>