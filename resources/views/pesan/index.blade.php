@extends('layouts.app')

@section('content')

<div class="container">
 <div class="row">
    <div class="col-md-12 mb-3">
        <a href="{{url('home')}}" class="btn btn-primary">Kembali</a>
    </div>
    <div class="col-md-12">
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $barang->nama_barang}}</li>
    </ol>
    </nav>
    </div>
    <div class="col-md-12 mt-1">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mt-5">
                        <img src="{{url('upload') }}/{{$barang->gambar}}" width="350"alt="">
                    </div>
                    <div class="col-md-6">
                    <h3>{{ $barang->nama_barang}}</h3>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Harga</td>
                                    <td>:</td>
                                    <td>Rp. {{ number_format ($barang->harga)}} </td>
                                </tr>
                                <tr>
                                    <td>Stok</td>
                                    <td>:</td>
                                    <td>{{  number_format ($barang->stok)}} </td>
                                </tr>
                                <tr>
                                    <td>Keterangan</td>
                                    <td>:</td>
                                    <td>{{ $barang->keterangan}} </td>
                                </tr>
                            
                                <tr>
                                    <td>Jumlah Pesan</td> 
                                    <td>:</td>
                                    <td>
                                      <form action="" method="post" action="{{url('pesan') }}/{{$barang->id}}">
                                      @csrf
                                        <input type="text" name="jumlah_pesan" class="form-control" require="">
                                        <button type="submit" class="btn btn-primary mt-2"> Masukan Keranjang</button>
                                        </form>
                                    </td>
                                </tr>
                               
                            </tbody>
                        </table>
                    </div>
                </div>  
            </div>
        </div>
     </div>
 </div>
</div>
@endsection
