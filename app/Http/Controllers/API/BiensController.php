<?php

namespace App\Http\Controllers\API;

use App\Biens;
use App\Equipements;
use App\Lieuxes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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
    {        $user = auth('api')->user();

        // if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
        //return Biens::where('bailleur',$user->id)->paginate(10);
        return DB::table('biens')
        ->where('bailleur',$user->id)
        ->leftJoin('typebiens', 'biens.type', '=', 'typebiens.typebien_id')
        ->select('biens.*', 'typebiens.*')->paginate(10);
        //}
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
            'type' => 'required|int|max:191',
            'adresse' => 'required|string|max:191',
            'etat' => 'required|string|max:191'

        ]);
        // $Typebiens = Typebiens::findOrFail($request->type);
        $Biens = new Biens();
        $user = auth('api')->user();

        $Biens->details = $request['details'];
        $Biens->prix = $request['prix'];
        $Biens->bailleur = $user->id;
        $Biens->etat = $request['etat'];
        $Biens->adresse = $request['adresse'];
        $Biens->type = $request['type'];
        $Biens->save();
        if($request['etatLieux']){

            $lieux = new Lieuxes();
            $lieux->etat = $request['etatLieux'];
            $lieux->murs = $request['murs'];
            $lieux->sols = $request['sols'];
            $lieux->ouverture = $request['ouverture'];
            $lieux->circuit = $request['circuit'];
            $lieux->divers = $request['divers'];
            $lieux->biens=$Biens->bien_id;
             $lieux->save();  
        } 
        return $Biens;
    }

    public function addEquip(Request $request)
    {

        $this->validate($request, [
            'typeEquipement' => 'required|string|max:191',
            'nombre' => 'required|string|max:191',
            'etatEquipement' => 'required|string|max:191',
            'commentaire' => 'required|string|max:191'

        ]);
        // $Typebiens = Typebiens::findOrFail($request->type);
        $id=$request['bien_id'];
        $Bien = DB::table('biens')->where('bien_id', $id);
            if($Bien){
        $Equipement = new Equipements();
          
        $Equipement->typeEquipement = $request['typeEquipement'];
        $Equipement->nombreEquipement = $request['nombre'];
        $Equipement->etatEquipement = $request['etatEquipement'];
        $Equipement->commentaireEquipement = $request['commentaire'];
        $Equipement->bien = $request['bien_id'];

        $Equipement->save();
    }
        return $Equipement;
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
        $Biens = DB::table('biens')->where('bien_id', $id);

        $this->validate($request, [
            'details' => 'required|string|max:191',
            'prix' => 'required|string|max:191',
            'etat' => 'required|string|max:191',
            'adresse' => 'required|string|max:191',
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
        $Biens = DB::table('biens')->where('bien_id', $id);
        $Biens->delete();
        return ['message' => 'Biens has been deleted'];
    }
    public function countbiens()
    {
        return Biens::count();
    }
}
