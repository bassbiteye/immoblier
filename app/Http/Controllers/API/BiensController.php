<?php

namespace App\Http\Controllers\API;

use App\Biens;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BiensController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
            return Biens::latest()->paginate(10);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'details' => 'required|string|max:191',
            'prix' => 'required|string|max:191',
            'proprietaire' => 'required|string|max:191',
            'type' => 'required|string|max:191'
        ]);

        return Biens::create([
            'details' => $request['details'],
            'prix' => $request['prix'],
            'proprietaire' => $request['proprietaire'],
            'type' => $request['type']


        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $Biens = Biens::findOrFail($id);
        $this->validate($request, [
            'details' => 'required|string|max:191',
            'prix' => 'required|string|max:191',
            'proprietaire' => 'required|string|max:191',
            'type' => 'required|string|max:191'
        ]);
        $Biens->update($request->all());
        return ['message' => 'Biens has been updated'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Biens = Biens::findOrFail($id);
        $Biens->delete();
        return ['message' => 'Biens has been deleted'];
    }
}
