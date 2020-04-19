<?php

namespace App\Http\Controllers\API;

use App\Typecomptes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TypecomptesController extends Controller
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
        // if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
        return Typecomptes::latest()->paginate(10);
        // }
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

        return Typecomptes::create([
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
        $Typecomptes = DB::table('typecomptes')->where('typecompte_id', $id);
        $this->validate($request, [
            'libelle' => 'required|string|max:191',
        ]);
        $Typecomptes->update($request->all());
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
        $Typecomptes = DB::table('typecomptes')->where('typecompte_id', $id);

        $Typecomptes->delete();
        return ['message' => 'Type de Biens has been deleted'];
    }
}
