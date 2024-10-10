<?php

namespace App\Http\Controllers;

use App\Models\cities;
use App\Models\Payment;
use App\Models\Province;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        // Eager load 'user' relation to reduce database queries
        $payment = Payment::with('user')->get();
        $paymentcount = Payment::count();

        return view('Payment/payment', compact('payment', 'paymentcount'));
    }

    public function success(Request $request)
    {
        // Eager load 'user', 'profile', 'province', dan 'city'
        $query = Payment::with(['user.profile.province', 'user.profile.city'])
            ->where('status', 'success'); // Menambahkan filter status

        // Ambil data provinsi untuk dropdown
        $provinces = Province::all();
        $cities = cities::all();

        // Filter berdasarkan province_id jika ada request filter
        if ($request->filled('province_id')) {
            $query->whereHas('user.profile', function ($q) use ($request) {
                $q->where('province_id', $request->province_id);
            });
        }

        // Filter berdasarkan city_id jika ada request filter
        if ($request->filled('city_id')) {
            $query->whereHas('user.profile', function ($q) use ($request) {
                $q->where('city_id', $request->city_id);
            });
        }

        // Filter berdasarkan tanggal jika ada
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $payment = $query->get();
        $paymentcount = $payment->count();

        return view('Payment/paymentsuccess', compact('payment', 'paymentcount', 'provinces', 'cities'));
    }
}