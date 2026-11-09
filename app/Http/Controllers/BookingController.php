<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('room')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    public function store(Request $request, Room $room)
    {
        $data = $request->validate([
            'check_in'  => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'guests'    => 'required|integer|min:1|max:' . $room->capacity,
        ]);

        // Reject if another active booking overlaps these dates
        $taken = Booking::where('room_id', $room->id)
            ->where('status', '!=', 'cancelled')
            ->where('check_in', '<', $data['check_out'])
            ->where('check_out', '>', $data['check_in'])
            ->exists();

        if ($taken) {
            return back()->withInput()->withErrors([
                'check_in' => 'Sorry, this room is already booked for those dates.',
            ]);
        }

        $nights = (int) Carbon::parse($data['check_in'])->diffInDays(Carbon::parse($data['check_out']));

        Booking::create([
            'user_id'     => auth()->id(),
            'room_id'     => $room->id,
            'check_in'    => $data['check_in'],
            'check_out'   => $data['check_out'],
            'guests'      => $data['guests'],
            'total_price' => $nights * $room->price_per_night, // computed server-side, never trusted from the form
            'status'      => 'pending',
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking received! We will confirm it shortly.');
    }
}