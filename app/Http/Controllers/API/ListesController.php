<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;


class ListesController extends Controller
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
    public function biensnonlouer()
    {
        //return User::latest()->paginate(10);

        return DB::table('biens')
            ->where('louer', false)
            ->join('users', 'biens.bailleur', '=', 'users.id')
            ->leftJoin('typebiens', 'biens.type', '=', 'typebiens.typebien_id')
            ->Join('typeetats', 'biens.etat', '=', 'typeetats.id')
            ->Join('operations', 'biens.bien_id', '=', 'operations.biens')
            ->Join('clients', 'clients.client_id', '=', 'operations.clients')
            ->select('biens.*', 'typebiens.*', 'users.name', 'typeetats.*','clients.nom')->paginate(10);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function bienslouer()
    {
        //return User::latest()->paginate(10);

        return DB::table('biens')
            ->where('louer', true)
            ->join('users', 'biens.bailleur', '=', 'users.id')
            ->leftJoin('typebiens', 'biens.type', '=', 'typebiens.typebien_id')
            ->Join('typeetats', 'biens.etat', '=', 'typeetats.id')
            ->select('biens.*', 'typebiens.*', 'users.name', 'typeetats.*')->paginate(10);
    }

    public function clientpaye(Request $request)
    {

            $date= $request->date;
        return DB::select("SELECT * FROM `clients`,`operations`,`biens`,`paiements`
        WHERE clients.client_id=operations.clients
         AND biens.bien_id=operations.biens
         AND operations.statut='louer'
          AND operations.operation_id IN 
          (SELECT paiements.operations FROM `paiements`
           WHERE paiements.date= '{$date}')");
    }
    public function clientnonpaye(Request $request)
    {
        $date= $request->date;
           return DB::select("SELECT * FROM `clients`,`operations`,`biens`
            WHERE clients.client_id=operations.clients
             AND biens.bien_id=operations.biens
             AND operations.statut='louer'
              AND operations.operation_id not IN 
              (SELECT paiements.operations FROM`paiements`
               WHERE paiements.date= '{$date}')");
      
           

    }

    public function commission(){

    }
    public function soldealawa(){

    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function soldebailleur(){
        return User::where('type','bailleurs');
      
    }
}
