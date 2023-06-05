@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-3">
                <a href="{{url('history')}}" class="btn btn-primary">Kembali</a>
            </div>
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                 <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{url('history')}}">Riwayat pemesanan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Pesanan</li>
                </ol>
              </nav>
            </div>
    <div class ="col-md-12">
        <div class="card">
            <div class="card-body">
            <h3>Sukses Check Out</h3>
            <p>Pesanan anda berhasil di checkout silahkan untuk selanjutnya lakukan pembayaran ke rekening <strong> Bank BCA : 763 0414 673</strong> dengan Nominal <strong>Rp. {{number_format($pesanan->jumlah_harga)}}</strong></p>
        </div>
    </div>
    <div class="card mt-2">
        <div class="card-body">
            <h3><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-check" viewBox="0 0 16 16">
                <path d="M11.354 6.354a.5.5 0 0 0-.708-.708L8 8.293 6.854 7.146a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"/>
                <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                </svg> Detail Pesanan</h3>
                @if(!empty($pesanan))
                <p align="right">Tanggal Pesan : {{$pesanan->tanggal}}</p>
                <table class="table table-hover responsive">
                    <thead>
                        <tr>
                           <th>No</th>
                           <th>Nama Barang</th>
                           <th>Jumlah</th>
                           <th>Harga</th>
                           <th>Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        @foreach($pesanan_details as $pesanan_detail)
                        <tr>
                            <td>{{ $no++}}</td>
                            <td>{{ $pesanan_detail->barang->nama_barang }}</td>
                            <td>{{ $pesanan_detail->jumlah}} Pcs</td>
                            <td align="right">Rp.{{ number_format($pesanan_detail->barang->harga)}}</td>
                            <td align="right">Rp.{{ number_format($pesanan_detail->jumlah_harga)}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" align="right"><strong> Total Harga :</strong></td>
                        <td align="right">Rp. {{number_format($pesanan->jumlah_harga)}}</td>
                    </tr> <tr>
                        <td colspan="4" align="right"><strong> Total Yang harus di Bayar :</strong></td>
                        <td align="right">Rp. {{number_format($pesanan->jumlah_harga)}}</td>
                    </tr>
                    </tbody>
                </table>
            @endif
        </div>
    </div>
   </div>
    </div>
 </div>
</div>
@endsection
