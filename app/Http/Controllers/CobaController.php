<?php

namespace App\Http\Controllers;

use App\Models\Friends;

use Illuminate\Http\Request;

class CobaController extends Controller
{
    public function index()
    {
        $friends = Friends::paginate(3);

        return view('index', compact('friends'));
    }
    public function create()
    {
        return view('create');
    }
    public function store(Request $request)
    {
        // Validate the request...

        $friends = new Friends;

        $friends->Nama = $request->nama;
        $friends->No_tlp = $request->no_tlp;
        $friends->Alamat = $request->alamat;

        $friends->save();
    }
}