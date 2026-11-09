<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['user_id', 'room_id', 'check_in', 'check_out', 'guests', 'total_price', 'status'];

    protected $casts = ['check_in' => 'date', 'check_out' => 'date'];

    public function room() { return $this->belongsTo(Room::class); }
    public function user() { return $this->belongsTo(User::class); }
}