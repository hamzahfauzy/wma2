@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Data Perlengkapan</div>

                <div class="panel-body">
                    <a href="{{route('barang.create')}}" class="btn btn-primary">+ Buat Data</a>
                    <a href="javascript:void(0)" class="btn btn-success" data-toggle="modal" data-target="#myModal">+ Tambah Barang Masuk</a>
                    <p></p>
                    <!-- Modal -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <form method="post" action="{{route('barang.masuk')}}">
                      {{csrf_field()}}
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Tambah Barang Masuk</h4>
                          </div>
                          <div class="modal-body">
                            <div class="form-group">
                                <label>Pilih Barang</label>
                                <select id="barang" class="form-control" name="barang" required="">
                                    <option value="">Pilih Barang</option>
                                    @foreach($model as $b)
                                    <option value="{{$b->id}}">{{$b->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Jumlah</label>
                                <input type="number" name="jumlah" class="form-control">
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                          </div>
                        </div>
                      </div>
                      </form>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Stok</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(empty($model) || count($model) == 0)
                            <tr>
                                <td colspan="4"><i>Tidak ada data</i></td>
                            </tr>
                            @endif

                            @foreach($model as $key => $data)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{$data->nama}}</td>
                                <td>{{$data->stok}}</td>
                                <td>
                                    <a href="{{route('barang.edit',$data->id)}}">Edit</a> | 
                                    <a href="{{route('barang.delete',$data->id)}}">Hapus</a>
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
@endsection
