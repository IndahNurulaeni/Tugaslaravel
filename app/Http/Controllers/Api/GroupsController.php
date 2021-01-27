<?php

namespace App\Http\Controllers\Api;

Use App\Models\Groups;
Use App\Models\Friends;
use Illuminate\Http\Request;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Groups::orderBy('id','desc')->paginate(3);
    
        return response()->json([
            'success' =>true,
            'message' =>'Daftar data teman',
            'data' => $groups
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:groups|max:255',
            'description' => 'required',
        ]);
        $groups = Groups::create([
            'nama' => $request ->name,
            'description' => $request ->description
        ]);

        if($groups)
        {
            return response()->json([
            'success' =>true,
            'message' =>'Teman berhasil di tambahkan',
            'data' => $groups
        ],200);
        }else{
            return response()->json([
                'success' =>false,
                'message' =>'Teman gagal di tambahkan',
                'data' => $groups
            ],409);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group = Groups::where('id',$id)->first();

        return response()->json([
            'success' =>true,
            'message' =>'Detail Data Teman',
            'data' => $group
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|unique:friends|max:225',
            'description' => 'required'
        ]);

        Groups::find($id)->update([
            'name' => $request->name,
            'description' => $request->description
         ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Groups::find($id)->delete();
        return redirect ('/groups');
    }

    public function addmember($id)
    {
        $friend = Friends::where('groups_id', '=', 0)->get();
        $group = Groups::where('id',$id)->first();
      return view('groups.addmember', ['group' => $group,'friend'=> $friend]);
    }

    public function updateaddmember(Request $request, $id)
    {
        $friend = Friends::where('id',$request->friend_id)->first();
        Friends::find($friend->id)->update([
            'groups_id' => $id
         ]);
   
         return redirect ('/groups/addmember/'. $id);
    }

    public function deleteaddmember(Request $request, $id)
    {
        //dd($id);
        Friends::find($id)->update([
            'groups_id' => 0
         ]);
   
         return redirect ('/groups');
    }
}