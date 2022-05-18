{{-- Modal data kriminal --}}
<div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">PERHATIAN!</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah anda akan mengakses data periode LP sebelum tahun {{ $now->year }}?</p>
            </div>
            <div class="modal-footer">
                <a href="{{URL::to('/perkara/last-year')}}" class="btn btn-danger light">Ya, sebelum tahun {{ $now->year }}</a>
                <a href="{{URL::to('/perkara/this-year')}}" class="btn btn-primary">Tidak, tahun ini</a>
            </div>
        </div>
    </div>
</div>

{{-- Modal Polda --}}
<div class="modal fade" id="modal-polda">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">PERHATIAN!</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            {!! Form::open(['method'=>'GET','url'=>'/rekapitulasi-polda','role'=>'search'])  !!}
            <div class="modal-body">
                <p>Pilih Divisi Polda</p>
                <div class="col-sm-12" style="margin-bottom: 12px">
                    <select class="form-control" name="divisi" id="divisi" required>
                        <option value="">Pilih Divisi</option>
                        <option value="Ditresnarkoba">Ditresnarkoba</option>
                        <option value="Ditreskrimsus">Ditreskrimsus</option>
                        <option value="Ditreskrimum">Ditreskrimum</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success light">Lihat</button>
                <a href="#" class="btn btn-primary" data-dismiss="modal">Cancel</a>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

{{-- Modal Polres --}}
<div class="modal fade" id="modal-polres">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">PERHATIAN!</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            {!! Form::open(['method'=>'GET','url'=>'/lihat-polres','role'=>'search'])  !!}
            <div class="modal-body">
                <div class="col-sm-12">
                    <label>Pilih Polres</label>
                    <select class="form-control" name="polres" id="polres" required>
                        <option value="">Pilih Polres</option>
                        @foreach($polres_list as $key=>$polres)
                        <option value="{{ $polres->id }}">{{ $polres->name }}</option>
                        @endforeach
                    </select>
                </div>
                <hr>
                <div class="col-sm-12">
                    <label>Pilih Divisi Polres</label>
                    <select class="form-control" name="divisi" id="divisi2" required>
                        <option value="">Pilih Divisi</option>
                        <option value="Satnarkoba">Satnarkoba</option>
                        <option value="Satreskrim">Satreskrim</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success light">Lihat</button>
                <a href="#" class="btn btn-primary" data-dismiss="modal">Cancel</a>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>