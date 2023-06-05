<?php

namespace App\Http\Controllers;
use App\Barang;
use App\Pesanan;
use App\user;
use App\PesananDetail;
use Auth;
use Alert;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PesanController extends Controller
{
        public function __construct()
        {
            $this->middleware('auth');
        }

        //FUNCTION DETAIL

        public function index($id)
        {
            $barang = Barang::where('id', $id)->first();

            return view('pesan.index' , compact('barang'));
        }

        public function pesan(Request $request, $id)
        {
            $barang = Barang::where('id', $id)->first();
            $tanggal = Carbon::now();

        //   validasi Melebihi stok
        if($request->jumlah_pesan > $barang->stok)
        {
            return redirect('pesan/' .$id);
        }

        //   cek validasi
        $cek_pesanan =  Pesanan::where('user_id', Auth::user()->id)->where('status',0)->first();
    // simpan ke database pesanan
    if(empty($cek_pesanan))
        {
            $pesanan = new Pesanan;
            $pesanan->user_id = Auth::user()->id;
            $pesanan->tanggal = $tanggal;
            $pesanan->status = 0;
            $pesanan->jumlah_harga = 0;
            $pesanan->save();
        }

        //simpan ke database pesanan
            $pesanan = new Pesanan;
            $pesanan->user_id = Auth::user()->id;
            $pesanan->tanggal = $tanggal;
            $pesanan->status = 0;
            $pesanan->jumlah_harga =  $barang->harga*$request->jumlah_pesan;
            $pesanan->save();

        //simpan ke database pesanan detail
            $pesanan_baru = Pesanan::where('user_id', Auth::user()->id)->where('status',0)->first();

        // cek pesanan detail
        $cek_pesanan_detail = PesananDetail::where('barang_id', $barang->id)->where('pesanan_id', $pesanan_baru->id)->first();
        if(empty($cek_pesanan_detail))
        {
            $pesanan_detail = new PesananDetail;
            $pesanan_detail->barang_id = $barang->id;
            $pesanan_detail->pesanan_id =  $pesanan_baru->id;
            $pesanan_detail->jumlah =  $request ->jumlah_pesan;
            $pesanan_detail->jumlah_harga =  $barang->harga*$request->jumlah_pesan;
            $pesanan_detail->save();
        }else
        {
            $pesanan_detail = PesananDetail::where('barang_id', $barang->id)->where('pesanan_id', $pesanan_baru->id)->first();
            $pesanan_detail->jumlah =  $pesanan_detail->jumlah+$request ->jumlah_pesan;

            // harga sekarang
            $harga_pesanan_detail_baru =   $barang->harga*$request->jumlah_pesan;
            $pesanan_detail->jumlah_harga =  $pesanan_detail->jumlah_harga+$harga_pesanan_detail_baru ;
            $pesanan_detail->update();
        }
    
        // jumlah total
                
            $pesanan= Pesanan::where('user_id', Auth::user()->id)->where('status',0)->first();
            $pesanan->jumlah_harga =  $pesanan->jumlah_harga+$barang->harga*$request->jumlah_pesan;
            $pesanan->update();

            return redirect('check_out')->with('success', 'Pesanan Masuk Keranjang!');;

        }


        //FUNCTION CHECK OUT 

        public function check_out()
            {
                $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->first();
                $pesanan_details = [];
            
                if (!empty($pesanan)) {
                    $pesanan_details = PesananDetail::where('pesanan_id', $pesanan->id)->get();
                }
            
                return view('pesan.check_out', compact('pesanan', 'pesanan_details'));
            }
            
            // FUNCTION HAPUS PRODUK DI HALAMAN CHECK OUT
        
        public function delete($id)
            {
                $pesanan_detail = PesananDetail::where('id', $id)->first();
            
                $pesanan = Pesanan::where('id', $pesanan_detail->pesanan_id)->first();  
                $pesanan->jumlah_harga = $pesanan->jumlah_harga - $pesanan_detail->jumlah_harga;
            
                $pesanan->update();
            
                $pesanan_detail->delete();
            
                return redirect('check_out')->with('error', 'Pesanan Dihapus');
            }

            // FUNCTION KONFIRMASI
        
        public function konfirmasi()
            {
                $user = User::where('id', Auth::user()->id)->first();

                if(empty($user->alamat))
                {
                    return redirect('profile')->with('error', 'Lengkapi Identitas terlebih dahulu');
                }
                    $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->first();

                if(empty($user->nohp))
                {
                    return redirect('profile')->with('error', 'Lengkapi Identitas terlebih dahulu');
                }
                    $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->first();
                
                if ($pesanan) {
                $pesanan->status = 1;
                $pesanan->update();
            
                $pesanan_details = PesananDetail::where('pesanan_id', $pesanan->id)->get();
                
                    foreach ($pesanan_details as $pesanan_detail) {
                    $barang = Barang::where('id', $pesanan_detail->barang_id)->first();
                    $barang->stok = $barang->stok - $pesanan_detail->jumlah;
                    $barang->update();
                    }
                
                    return redirect('history')->with('success', 'Berhasil Check Out');
                }
            }

}

