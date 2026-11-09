<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Room;

use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        if(Auth::id()){
            $usertype = Auth()->user()->usertype; 
            if ($usertype == 'user') {
                $rooms = Room::all();
                return view('home.index', compact('rooms'));
            }
            else if($usertype=='admin'){
                return view('admin.index');
            }
            else{
                return redirect()->back();
            }
        }

    }

    public function home()
    {
        $rooms = Room::all();
        return view('home.index', compact('rooms'));
    }
}
