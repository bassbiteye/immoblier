<?php

namespace App\Http\Controllers\API;

use App\Biens;
use App\Clients;
use App\Lieuxes;
use App\Operations;
use App\Equipements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OperationsController extends Controller
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
    public function listebiens()
    {

        return DB::table('biens')
            ->where('louer', false)
            ->leftJoin('typebiens', 'biens.type', '=', 'typebiens.typebien_id')
            ->select('biens.*', 'typebiens.*')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function louer(Request $request)
    {

        $this->validate($request, [
            'details' => 'required|string|max:191',
            'caution' => 'required|string|max:191',
            'montantPaye' => 'required|string|max:191',
            'dateEntre' => 'required|string|max:191',
            'client' => 'required|string|max:191',
            'numero' => 'required|string|max:191'

           
        ]);
        $client =  DB::table('clients')->where('tel', $request['numero'])->first();
        $bien = DB::table('biens')->where('bien_id', $request['bien_id'])->first();    
        $Operation = new Operations();

        $Operation->caution = $request['caution'];
        $Operation->montantPaye = $request['montantPaye'];
        $Operation->dateEntre = $request['dateEntre'];
        $Operation->clients = $client->client_id;
        $Operation->biens = $bien->bien_id;
        $Operation->ref=rand(0,1000000);
        $bien->louer= true;
        //dd($bien);
         DB::table('biens')
              ->where('bien_id', $bien->bien_id)
              ->update(['louer' => true]);
        
        $Operation->save();
          
        return Response()->json(['Operation' => $Operation,'bien'=>$bien,'client'=>$client ]);

    }





    public function findclient(Request $request)
    {
        return Clients::where('tel', $request['numero'])->first();
        
    }
}
