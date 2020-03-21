<?php

namespace App\Http\Controllers\API;

use App\Typebiens;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TypebiensController extends Controller
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
            return Typebiens::latest()->paginate(5);
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
            'libelle' => 'required|string|max:191'

        ]);

        return Typebiens::create([
            'libelle' => $request['libelle']
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
        $Typebiens = Typebiens::findOrFail($id);
        $this->validate($request, [
            'libelle' => 'required|string|max:191',
        ]);
        $Typebiens->update($request->all());
        return ['message' => 'Type de Biens has been updated'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Typebiens = Typebiens::findOrFail($id);
        $Typebiens->delete();
        return ['message' => 'Type de Biens has been deleted'];
    }
}
