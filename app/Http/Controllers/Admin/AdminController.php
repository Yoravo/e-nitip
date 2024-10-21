<?php

namespace App\Http\Controllers\Admin;

use App\Models\Locker;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;

class AdminController extends Controller
{
    public function index()
    {
        $lockers = Locker::all();
        $reservations = \App\Models\Reservation::all();
        return view('admin.dashboard', compact('lockers', 'reservations'));
    }
    public function activity()
    {
        $lockers = Locker::all();
        $reservations = Reservation::all();
        foreach ($reservations as $reservation) {
            $startTime = Carbon::parse($reservation->deposit_time);
            $endTime = Carbon::parse($reservation->pickup_time);
            $reservation->total_price = $this->calculateDeposit($startTime, $endTime);
        }

        return view('admin.activity', compact('lockers', 'reservations'));
    }
    public function reserveLockers(Request $request)
    {
        $request->validate([
            'lockers' => 'required|array|max:5',
            'name' => 'required|string',
            'item_name' => 'required|string',
            'phone_number' => 'required|string',
            'deposit_time' => 'required',
            'pickup_time' => 'required',
        ]);

        $depositTime = strtotime($request->deposit_time);
        $pickupTime = strtotime($request->pickup_time);

        if ($pickupTime < $depositTime) {
            return redirect()->route('admin.activity')->with('alert', 'Waktu pengambilan tidak bisa lebih awal dari waktu penyimpanan.');
        }

        foreach ($request->lockers as $lockerCode) {
            Locker::where('locker_code', $lockerCode)->update(['is_available' => 0]);
        }

        \App\Models\Reservation::create([
            'name' => $request->name,
            'item_name' => $request->item_name,
            'phone_number' => $request->phone_number,
            'locker_codes' => $request->lockers,
            'deposit_time' => $request->deposit_time,
            'pickup_time' => $request->pickup_time,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Lockers reserved successfully.');
    }

    public function confirmPickup(Request $request)
    {
        $request->validate([
            'lockers' => 'required|array',
        ]);

        foreach ($request->lockers as $lockerCode) {
            Locker::where('locker_code', $lockerCode)->update(['is_available' => 1]);
            $reservation = Reservation::whereJsonContains('locker_codes', $lockerCode)->first();

            if ($reservation) {
                $updatedLockerCodes = array_diff($reservation->locker_codes, [$lockerCode]);
                if (!empty($updatedLockerCodes)) {
                    $reservation->update(['locker_codes' => array_values($updatedLockerCodes)]);
                } else {
                    $reservation->delete();
                }
            }
        }
        return redirect()->route('admin.activity')->with('success', 'Selected lockers confirmed. Reservation updated.');
    }
    public function finishConfirm(Request $request, $id)
{
    $reservation = Reservation::find($id);
    $pickupTime = strtotime($request->pickup_time);
    $now = time();

    // Jika waktu pengambilan lebih awal, hitung sesuai durasi aktual
    if ($now < $pickupTime) {
        // Waktu pengambilan lebih cepat
        $totalMinutes = ($now - strtotime($request->deposit_time)) / 60;
        $totalHours = ceil($totalMinutes / 60);

        if ($totalMinutes <= 30) {
            $totalCost = 2500; // Biaya setengah jam
        } elseif ($totalMinutes > 30 && $totalMinutes <= 60) {
            $totalCost = 5000; // Biaya satu jam
        } else {
            $totalCost = $totalHours * 5000; // Biaya per jam
        }

        $reservation->total_price = $totalCost;

        // Mark lockers as available and delete reservation
        foreach ($reservation->locker_codes as $lockerCode) {
            Locker::where('locker_code', $lockerCode)->update(['is_available' => 1]);
        }

        $reservation->delete();

        return redirect()->route('admin.activity')->with('success', 'Reservasi selesai lebih cepat. Total biaya: Rp. ' . number_format($totalCost, 2, ',', '.'));
    } else {
        // Waktu pengambilan sesuai atau lebih lama
        $totalMinutesLate = ($now - $pickupTime) / 60;
        if ($totalMinutesLate > 0) {
            // Hitung denda jika terlambat
            $penalty = ceil($totalMinutesLate / 120) * 5000; // Denda tambahan setiap 2 jam
            $reservation->penalty = $penalty;
        }

        // Jika tepat waktu atau terlambat, mark lockers as available and delete reservation
        foreach ($reservation->locker_codes as $lockerCode) {
            Locker::where('locker_code', $lockerCode)->update(['is_available' => 1]);
        }

        $reservation->delete();
        
        return redirect()->route('admin.activity')->with('success', 'Reservasi selesai. Total biaya: Rp. ' . number_format($reservation->total_price + $reservation->penalty, 2, ',', '.'));
    }
}
    public function finish($id)
    {
        $reservation = Reservation::find($id);
        foreach ($reservation->locker_codes as $lockerCode) {
            Locker::where('locker_code', $lockerCode)->update(['is_available' => 1]);
        }
        $reservation->delete();
        return redirect()
            ->route('admin.activity')
            ->with([
                'alert' => 'Reservation has been deleted.',
                'alert_type' => 'success',
            ]);
    }

    public function calculateDeposit($startTime, $endTime)
    {
        $hourlyRate = 5000;

        $startTime = strtotime($startTime);
        $endTime = strtotime($endTime);

        if ($endTime < $startTime) {
            Session()->flash('alert', 'Waktu pengambilan tidak bisa lebih awal dari waktu penyimpanan.');
            return null;
        }

        $totalMinutes = ($endTime - $startTime) / 60;

        $totalHours = ceil($totalMinutes / 60);

        if ($totalMinutes <= 30) {
            return 2500;
        } elseif ($totalMinutes > 30 && $totalMinutes <= 60) {
            return $hourlyRate;
        } elseif ($totalMinutes > 60) {
            $depositCost = $totalHours * $hourlyRate;
            return $depositCost;
        }
    }
}
