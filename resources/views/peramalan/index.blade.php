@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Barang dan Bobot</div>

                <div class="panel-body">
                    <form>
                    <div class="form-group">
                        <label>Pilih Barang</label>
                        <select id="barang" class="form-control" name="barang" required="">
                            <option value="">Pilih Barang</option>
                            @foreach($barang as $b)
                            <option value="{{$b->id}}" {{isset($_GET['barang']) && $_GET['barang'] == $b->id ? 'selected=""' : ''}}>{{$b->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Bobot</label>
                        <select id="bobot" class="form-control" name="bobot" required="">
                            <option value="">Pilih Bobot</option>
                            @foreach([1,2,3,4,5] as $b)
                            <option value="{{$b}}" {{isset($_GET['bobot']) && $_GET['bobot'] == $b ? 'selected=""' : ''}}>{{$b}}</option>
                            @endforeach
                        </select>
                        <!-- <input type="number" class="form-control" name="bobot" value="{{isset($_GET['bobot']) ? $_GET['bobot'] : ''}}"> -->
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary">Hitung</button>
                    </div>
                    </form>
                </div>
            </div>

            @if(!empty($barangTampil))
            <div class="cetak">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="judul">Peramalan</span>
                    <a href="#" class="btn-cetak btn btn-warning pull-right" onclick="cetak()">Cetak</a>
                    <div class="clearfix"></div>
                </div>

                <div class="panel-body">
                    <div>
                        <table class="table table-bordered">
                            <tr>
                                <td>No</td>
                                <td>Bulan</td>
                                <td>Tahun</td>
                                <td>Jumlah Keluar</td>
                                <td>Forecast {{$_GET['bobot']}}</td>
                            </tr>
                            @php
                            $total_bobot = 0;
                            $bobot_periode = [];
                            $i = $_GET['bobot'];
                            while($i>0)
                            {
                                $total_bobot += $i;
                                $i--;
                            }
                            $last_jumlah = 0;
                            @endphp
                            @foreach($barangTampil->keluars()->orderby('bulan','asc')->get() as $key => $value)
                                @if($key < $_GET['bobot'])
                                    @php
                                    $bobot_periode[] = $value->jumlah_keluar; 
                                    @endphp
                                @elseif($key == $_GET['bobot'])
                                    @php
                                    $bobot_periode[] = $value->jumlah_keluar; 
                                    @endphp
                                @else
                                    @php 
                                    array_shift($bobot_periode);
                                    $bobot_periode[] = $value->jumlah_keluar; 
                                    @endphp
                                @endif
                                @php $last_jumlah = $value->jumlah_keluar @endphp
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{$bulan[$value->bulan]}}</td>
                                <td>{{$value->tahun}}</td>
                                <td>{{$value->jumlah_keluar}}</td>
                                @if($key <= $_GET['bobot'])
                                <td></td>
                                @else
                                @php
                                $forecast = 0;
                                $forecast_label = "";
                                for($i = $_GET['bobot']-1; $i>=0; $i--)
                                {
                                    $forecast_label .= "($bobot_periode[$i] * ".($i+1).")";
                                    $forecast += ($bobot_periode[$i] * ($i+1));
                                }
                                $forecast = $forecast/$total_bobot
                                @endphp
                                <td>{{round($forecast)}}</td>
                                @endif
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">ERROR MAPE</div>

                <div class="panel-body">
                    <div>
                        <table class="table table-bordered">
                            <tr>
                                <td>No</td>
                                <td>Tahun</td>
                                <td>Bulan</td>
                                <td>Barang Keluar (Ft)</td>
                                <td>Forecast {{$_GET['bobot']}}</td>
                                <td>ERROR</td>
                                <td>|ERROR|</td>
                                <td>MAPE</td>
                            </tr>
                            @php
                            $total_bobot = 0;
                            $bobot_periode = [];
                            $i = $_GET['bobot'];
                            $total_error = 0;
                            while($i>0)
                            {
                                $total_bobot += $i;
                                $i--;
                            }
                            $last_jumlah = 0;
                            @endphp
                            @foreach($barangTampil->keluars()->orderby('bulan','asc')->get() as $key => $value)
                                @if($key < $_GET['bobot'])
                                    @php
                                    $bobot_periode[] = $value->jumlah_keluar; 
                                    @endphp
                                @elseif($key == $_GET['bobot'])
                                    @php
                                    $bobot_periode[] = $value->jumlah_keluar; 
                                    @endphp
                                @else
                                    @php 
                                    array_shift($bobot_periode);
                                    $bobot_periode[] = $value->jumlah_keluar; 
                                    @endphp
                                @endif
                                @php $last_jumlah = $value->jumlah_keluar @endphp
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{$value->tahun}}</td>
                                <td>{{$bulan[$value->bulan]}}</td>
                                <td>{{$value->jumlah_keluar}}</td>
                                @if($key <= $_GET['bobot'])
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                @else
                                @php
                                $forecast = 0;
                                $forecast_label = "";
                                for($i = $_GET['bobot']-1; $i>=0; $i--)
                                {
                                    $forecast_label .= "($bobot_periode[$i] * ".($i+1).")";
                                    $forecast += ($bobot_periode[$i] * ($i+1));
                                }
                                $forecast = round($forecast/$total_bobot);
                                $err = $value->jumlah_keluar-$forecast;
                                $abs_err = abs($err);
                                $mape = round(100*($abs_err/$value->jumlah_keluar));
                                @endphp
                                <td>{{$forecast}}</td>
                                <td>{{$err}}</td>
                                <td>{{$abs_err}}</td>
                                <td>{{$mape}}</td>
                                @php $total_error += $mape @endphp
                                @endif
                            </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{round($total_error/$barangTampil->keluars()->orderby('bulan','asc')->count())}}</td>
                            </tr>
                        </table>
                        <p>Error adalah {{round($total_error/$barangTampil->keluars()->orderby('bulan','asc')->count())}}%</p>
                    </div>
                </div>
            </div>
            </div>
            @endif
        </div>
    </div>
</div>
@if(isset($_GET['barang']))
<script type="text/javascript">
function cetak()
{
    var bodyOld = document.body.innerHTML;
    var printTag = document.querySelector('.cetak').innerHTML;
    document.body.innerHTML = printTag
    document.querySelector('.btn-cetak').style.display = "none"
    document.querySelector('.judul').innerHTML = "<center>Laporan Peramalan {{$barang->where('id',$_GET['barang'])->first()->nama}}</center>"
    window.print()
    document.body.innerHTML = bodyOld
}
</script>
@endif
@endsection
