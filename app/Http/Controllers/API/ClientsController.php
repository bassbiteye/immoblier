<?php

namespace App\Http\Controllers\API;

use App\Clients;
use App\Typeclients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ClientsController extends Controller
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
        //  $this->authorize('isAdmin');
        //if(\Gate::allows('isAdmin')||\Gate::allows('isAuthor')){
        //return Clients::latest()->paginate(10);
        return DB::table('clients')
            ->leftJoin('typeclients', 'clients.type', '=', 'typeclients.typeclients_id')
            ->select('clients.*', 'typeclients.libelle', 'typeclients.typeclients_id')->paginate(10);

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
            'nom' => 'required|string|max:191',
            'prenom' => 'required|string|max:191',
            'tel' => 'required|string|max:191',
            'sexe' => 'required|string|max:10',
            'nationalite' => 'required|string|max:191',
            'tel' => 'required|string|tel|max:191|unique:clients',
            'tel' => 'required|string|min:6'
            
        ]);
        $client = Clients::where('tel', $request->tel)->first();

        if (isset($client->id)) {
            return response()->json(["error" => "telephone already exists"], 401);
        }
        $typeclient = Typeclients::where('typeclients_id', $request->type)->first();;
      
        $date = (154263);
        $min_epoch = strtotime($date);
        $var = rand($min_epoch, 1000);
        $strval = 'FR_401';
        $items = ($strval . $var);

        if ($typeclient) {
            return Clients::create([
                'nom' => $request['nom'],
                'prenom' => $request['prenom'],
                'adresse' => $request['adresse'],
                'tel' => $request['tel'],
                'sexe' => $request['sexe'],
                'profession' => $request['profession'],
                'nationalite' => $request['nationalite'],
                'commentaire'=> $request['commentaire'],
                'entreprise'=> $request['entreprise'],
                'type' => $typeclient->typeclients_id,
                'numero' => $items,
                    'solde' => 0
            ]);
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
        $client = DB::table('clients')->where('client_id', $id);
        $this->validate($request, [
            'nom' => 'required|string|max:191',
            'prenom' => 'required|string|max:191',
            'tel' => 'required|string|max:191',
            'nationalite' => 'required|string|max:191',
            'profession' => 'required|string|max:191',
            'tel' => 'required|string|tel|max:191|unique:clients',
            'tel' => 'required|string|min:6',
            'sexe' => 'required|string|max:10',

        ]);
        $client->update($request->all());
        return ['message' => 'client has been updated'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = DB::table('clients')->where('client_id', $id);

        $client->delete();
        return ['message' => 'client has been deleted'];
    }
    public function countclients()
    {
        return clients::count();
    }
}
