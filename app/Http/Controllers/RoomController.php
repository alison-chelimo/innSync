<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'check_in'  => ['nullable', 'date', 'after_or_equal:today'],
            'check_out' => ['nullable', 'date', 'after:check_in'],
            'guests'    => ['nullable', 'integer', 'min:1', 'max:10'],
            'type'      => ['nullable', 'string'],
            'max_price' => ['nullable', 'numeric', 'min:0'],
        ]);

        $rooms = Room::available()
            ->when($request->filled('type'), fn ($q) => $q->where('type', $request->type))
            ->when($request->filled('guests'), fn ($q) => $q->where('capacity', '>=', $request->guests))
            ->when($request->filled('max_price'), fn ($q) => $q->where('price_per_night', '<=', $request->max_price))
            ->when(
                $request->filled('check_in') && $request->filled('check_out'),
                fn ($q) => $q->freeBetween($request->check_in, $request->check_out)
            )
            ->orderBy('price_per_night')
            ->paginate(9)
            ->withQueryString();

        $types = Room::available()->select('type')->distinct()->pluck('type');

        return view('rooms.index', compact('rooms', 'types'));
    }

    public function show(Room $room)
    {
        return view('rooms.show', compact('room'));
    }
}
