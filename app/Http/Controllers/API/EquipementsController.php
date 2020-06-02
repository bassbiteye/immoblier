<?php

namespace App\Http\Controllers\API;

use App\Equipements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class EquipementsController extends Controller
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

        return DB::table('biens')
            ->join('users', 'biens.bailleur', '=', 'users.id')
            ->leftJoin('typebiens', 'biens.type', '=', 'typebiens.typebien_id')
            ->select('biens.*', 'typebiens.*', 'users.*')->paginate(10);
    
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
            'typeEquipement' => 'required|string|max:191',
            'nombre' => 'required|string|max:191',
            'etatEquipement' => 'required|string|max:191',


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
        $Equipement = DB::table('equipements')->where('equipements_id', $id);

        $this->validate($request, [
            'typeEquipement' => 'required|string|max:191',
            'nombreEquipement' => 'required|string|max:191',
            'etatEquipement' => 'required|string|max:191',

        ]);
        $Equipement->update($request->all());
        return ['message' => 'equipement has been updated'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Equipement = DB::table('equipements')->where('equipements_id', $id);
        $Equipement->delete();
        return ['message' => 'Equipement has been deleted'];
    }



}
