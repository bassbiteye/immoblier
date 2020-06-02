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
    {
        $user = auth('api')->user();

        return DB::table('biens')
            ->join('users', 'biens.bailleur', '=', 'users.id')
            ->leftJoin('typebiens', 'biens.type', '=', 'typebiens.typebien_id')
            ->Join('typeetats', 'biens.etat', '=', 'typeetats.id')
            ->select('biens.*', 'typebiens.*', 'users.name','typeetats.*')->paginate(10);

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
            'etat' => 'required|int|max:191',
            'bailleur' => 'required'


        ]);
        $Biens = new Biens();

        $Biens->details = $request['details'];
        $Biens->prix = $request['prix'];
        $Biens->bailleur = $request['bailleur'];
        $Biens->etat = $request['etat'];
        $Biens->adresse = $request['adresse'];
        $Biens->type = $request['type'];
        $Biens->louer = false;
        $Biens->save();
    
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
        $id = $request['bien_id'];
        $Bien = DB::table('biens')->where('bien_id', $id);
        if ($Bien) {
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
      
        $Equipement = DB::table('equipements')->where('bien', '=', $id)->get();
        return Response()->json(['equipement' => $Equipement]);
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
            'adresse' => 'required|string|max:191',
            'etat' => 'required|int|max:191',
            'bailleur' => 'required|string|max:191',
            'type' => 'required|int|max:191',

        ]);
        $Biens->update($request->all());
        return ['message' => 'Biens has been updated'];
    }
      /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatEquip(Request $request, $id){
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
