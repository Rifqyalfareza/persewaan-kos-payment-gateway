<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::id())->get();
        $rooms = Room::all();
        return view('transaction', compact('transactions', 'rooms'));
    }

    public function createTransaction(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'user_id' => 'required|exists:users,id',
            'duration' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'total_price' => 'required|integer|min:0',
        ]);

        // Buat transaksi di DB
        $transaction = Transaction::create([
            // 'id'          => rand(), 
            'user_id'     => $request->user_id,
            'rooms_id'    => $request->room_id,
            'duration'    => $request->duration,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'total_price' => $request->total_price,
            'status'      => 'pending',
        ]);

        // Midtrans config
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id'     => $transaction->id, // pakai ID transaction di DB
                'gross_amount' => (int) $request->total_price,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email'      => Auth::user()->email,
            ],
            'callbacks' => [
                'finish' => route('payment.finish'), // nanti kita buat route ini
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $transaction->snap_token = $snapToken;
        $transaction->save();

        return response()->json(['snap_token' => $snapToken]);
    }

    public function finish(Request $request)
    {
        // Ketika user selesai pembayaran dan diarahkan balik
        if ($request->transaction_status === 'capture' || $request->transaction_status === 'settlement') {
            $transaction = Transaction::find($request->order_id);
            if ($transaction) {
                $transaction->status = 'confirmed';
                $transaction->save();
            }
        }

        return redirect('/')->with('success', 'Pembayaran berhasil dan status sudah dikonfirmasi!');
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed === $request->signature_key) {
            if (in_array($request->transaction_status, ['capture', 'settlement'])) {
                $transaction = Transaction::find($request->order_id);
                if ($transaction) {
                    $transaction->update(['status' => 'confirmed']);
                }
            }
        }
    }
}
