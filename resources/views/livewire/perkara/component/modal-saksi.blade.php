<div wire:ignore.self class="modal fade" id="saksiModal" tabindex="-1" role="dialog" aria-labelledby="saksiModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="saksiModalLabel">Tambah Data Saksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
           <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Nama</label>
                        <input type="text" class="form-control" wire:model='nama_saksi' placeholder="Masukan Nama Saksi">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                <button type="button" wire:click.prevent="addSaksi()" class="btn btn-primary close-modal">Tambah</button>
            </div>
        </div>
    </div>
</div>