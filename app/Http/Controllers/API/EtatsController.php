<?php

namespace App\Http\Controllers\API;

use App\Lieuxes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class EtatsController extends Controller
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = $request['biens'];
        $lieux = new Lieuxes();
        $lieux->etat = $request['etat'];
        $lieux->murs = $request['murs'];
        $lieux->sols = $request['sols'];
        $lieux->ouverture = $request['ouverture'];
        $lieux->circuit = $request['circuit'];
        $lieux->divers = $request['divers'];
        $lieux->commentaire = $request['commentaire'];
        $lieux->plafonds = $request['plafonds'];
        $lieux->cuisine = $request['cuisine'];
        $lieux->salledebain = $request['salledebain'];
        $lieux->biens = $id;
        $lieux->save();

        return $lieux;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        return DB::table('lieuxes')->where('biens', '=', $id)->get();
        
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
        $lieux = DB::table('lieuxes')->where('lieux_id', $id);


        $lieux->update($request->all());
        return ['message' => 'lieux has been updated'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lieux = DB::table('lieuxes')->where('lieux_id', $id);
        $lieux->delete();
        return ['message' => 'lieux has been deleted'];
    }
}
