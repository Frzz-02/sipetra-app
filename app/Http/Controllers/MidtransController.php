<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class MidtransController extends Controller
{
    public function bayar($id_pesanan)
    {
        $pesanan = Pesanan::with(['details.hewan', 'details.layanan'])->findOrFail($id_pesanan);

        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');

        // Buat parameter transaksi
        $params = [
            'transaction_details' => [
                'order_id' => 'SIPETRA-' . $pesanan->id,
                'gross_amount' => $pesanan->total_biaya,
            ],
            'customer_details' => [
                'first_name' => auth::user()->username,
                'email' => auth::user()->email,
                'phone' => Auth::user()->no_telephone,
            ],
        ];

        // Buat Snap Token
        $snapToken = Snap::getSnapToken($params);

        return view('page.User.midtrans_bayar', compact('pesanan', 'snapToken'));
    }
    public function getSnapToken($id_pesanan)
    {
        $pesanan = Pesanan::findOrFail($id_pesanan);

        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => 'SIPETRA-' . $pesanan->id,
                'gross_amount' => $pesanan->total_biaya,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->username,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->no_telephone,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);
        return response()->json(['snap_token' => $snapToken]);
    }
}
