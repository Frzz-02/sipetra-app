<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
    try {
        $pesanan = Pesanan::findOrFail($id_pesanan);

        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');

        $params = [
            'transaction_details' => [
                'order_id' => 'SIPETRA-' . $pesanan->id . '-' . uniqid(),
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
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Gagal mendapatkan Snap Token: ' . $e->getMessage()
        ], 500);
    }
}


    public function callback(Request $request)
    {
        try {
            $notif = new \Midtrans\Notification();

            $transactionStatus = $notif->transaction_status;
            $orderId = $notif->order_id; // Format: SIPETRA-123
            $realId = str_replace('SIPETRA-', '', $orderId);

            if ($transactionStatus === 'settlement') {
                $pesanan = Pesanan::find($realId);
                if ($pesanan) {
                    $pesanan->status = 'menunggu diproses';
                    $pesanan->save();
                    return response()->json(['message' => 'Status pesanan diperbarui.']);
                } else {
                    return response()->json(['error' => 'Pesanan tidak ditemukan.'], 404);
                }
            }

            return response()->json(['message' => 'Tidak ada aksi untuk status ini.']);
        } catch (\Exception $e) {
            Log::error('Callback Midtrans error: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal memproses callback.'], 500);
        }
    }

}
