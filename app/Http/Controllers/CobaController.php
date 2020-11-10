<?php

namespace App\Http\Controllers;
use App\Models\Friends;
use Illuminate\Http\Request;

class cobaController extends Controller
{
   
    public function index()
     {
        $friends= Friends::orderBy('id', 'desc')->paginate(3);
        return view('friends.index', compact('friends'));

     }

     public function create()
     {
       
        return view('friends.create');

     }

     public function store(Request $request)
    {
        // Validate the request...
        $request->validate([
            'nama' => 'required|unique:friends|max:225',
            'no_tlp' =>'required|numeric',
            'alamat' =>'required',
        ]);

        $friends = new Friends;

        $friends->nama = $request->nama;
        $friends->no_tlp = $request->no_tlp;
        $friends->alamat = $request->alamat;

        $friends->save();

        return redirect('/');
    }

     public function show($id)
     {
         $friend = Friends::where('id', $id) ->first();
         return view('friends.show', ['friend' => $friend]);
     }
         public function edit($id)
     {
         $friend = Friends::where('id', $id) ->first();
         return view('friends.edit', ['friend' => $friend]);
     }
     public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|unique:friends|max:225',
            'no_tlp' =>'required|numeric',
            'alamat' =>'required',
        ]);
      Friends::find($id)->update([
          'nama' => $request->nama,
          'no_tlp' => $request->no_tlp,
          'alamat' => $request->alamat
      ]);
        return redirect('/');
}
   public function destroy($id)
   {
       Friends::find($id)->delete();
       return redirect('/');
   }
}