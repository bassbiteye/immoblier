<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Biens;
use App\Divers;
use App\Clients;
use App\Lieuxes;
use App\Paiements;
use App\Operations;
use App\Equipements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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
            ->Join('typeetats', 'biens.etat', '=', 'typeetats.id')
            ->select('biens.*', 'typebiens.*', 'typeetats.*')->paginate(10);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function revoque()
    {

        return DB::table('operations')
            ->where('statut', 'louer')
            ->leftJoin('clients', 'operations.clients', '=', 'clients.client_id')
            ->Join('biens', 'operations.biens', '=', 'biens.bien_id')
            ->select('operations.*', 'clients.*', 'biens.*')->paginate(10);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function divers()
    {
        //->leftJoin('operations', 'divers.operations', '=', 'operations.operation_id')

        return DB::table('operations')
            ->leftJoin('clients', 'operations.clients', '=', 'clients.client_id')
            ->Join('biens', 'operations.biens', '=', 'biens.bien_id')
            ->Join('divers', 'operations.operation_id', '=', 'divers.divers_id')
            ->select('operations.montantPaye','operations.ref', 'clients.nom', 'clients.prenom', 'clients.tel', 'biens.*','divers.commentaire','divers.fichier','divers.divers_id')->paginate(10);
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
            'numero' => 'required|string|max:191',
            'commission' => 'required',
            //'taxes' => 'required',
            'durée' => 'required',


        ]);
        if ($request->piece) {
            $name = time() . '3' . '.' . explode('/', explode(':', substr($request->piece, 0, strpos($request->piece, ';')))[1])[1];

            \Image::make($request->piece)->save(public_path('img/profile/') . $name);

            $request->merge(['piece' => $name]);
        }
        if ($request->dernierelevé) {
            $name = time() . '.' . explode('/', explode(':', substr($request->dernierelevé, 0, strpos($request->dernierelevé, ';')))[1])[1];

            \Image::make($request->dernierelevé)->save(public_path('img/profile/') . $name);

            $request->merge(['dernierelevé' => $name]);
        }

        $client =  DB::table('clients')->where('tel', $request['numero'])->first();
        $bien = DB::table('biens')->where('bien_id', $request['bien_id'])->first();
        $Operation = new Operations();

        $Operation->caution = $request['caution'];
        $Operation->montantPaye = $request['montantPaye'];
        $Operation->dateEntre = date("H:i:s", strtotime(request('dateEntre')));
        $Operation->commission = $request['commission'];
        $Operation->taxes = $request['taxes'];
        $Operation->durée = $request['durée'];
        $Operation->dateEntre = $request['dateEntre'];
        $Operation->dernierelevé = $request['dernierelevé'];
        $Operation->piece = $request['piece'];
        $Operation->commentaire = $request['commentaire'];

        $Operation->clients = $client->client_id;
        $Operation->biens = $bien->bien_id;
        $Operation->ref = rand(0, 1000000);
        $bien->louer = true;
        DB::table('biens')
            ->where('bien_id', $bien->bien_id)
            ->update(['louer' => true]);
        $user = User::findOrFail($bien->bailleur);
        $solde = $user->solde + $request['montantPaye'];

        $soldeCli = $request['montantPaye'] + $client->solde;
        DB::table('clients')
            ->where('client_id', $client->client_id)
            ->update(['solde' => $soldeCli]);

        DB::table('users')
            ->where('id', $bien->bailleur)
            ->update(['solde' => $solde]);
        $Operation->save();

        return Response()->json(['Operation' => $Operation, 'bien' => $bien, 'client' => $client]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addRevoque(Request $request)
    {



        DB::table('operations')
            ->where('operation_id', $request['operation_id'])
            ->update(['statut' => 'revoquer']);
        $bien =  DB::table('biens')
            ->where('bien_id', $request['biens'])
            ->update(['louer' => false]);
        return Response()->json(['etat' => $bien]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function paiement(Request $request)
    {


        $this->validate($request, [

            'montant' => 'required',
            'date' => 'required',

        ]);

        $Operation = DB::table('operations')
            ->where('operation_id', $request['operation_id'])->first();

        $paie = DB::table('paiements')->where([
            ['operations', '=', $request['operation_id']],
            ['date', '=', $request['date']],
        ])->get();

        if ($paie) {
            return Response()->json(["status"=>500,
            'message' => "paiement déja enregistré"]);
        }
        $paiement = new Paiements();
        $paiement->montant = $request['montant'];
        $paiement->date = $request['date'];
        $paiement->commission = $Operation->commission;
        $paiement->ref = rand(0, 1000000);
        $paiement->operations = $Operation->operation_id;

        $paiement->save();

        return Response()->json(["status"=>200,'message' => "paiement effectué avec succes"]);
    }

    public function findclient(Request $request)
    {
        return Clients::where('tel', $request['numero'])->first();
    }
       /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function findoperation(Request $request)
    {
        return DB::table('operations')
        ->where('ref', $request['ref'])
        ->leftJoin('clients', 'operations.clients', '=', 'clients.client_id')
        ->Join('biens', 'operations.biens', '=', 'biens.bien_id')
        ->select('operations.montantPaye','operations.operation_id', 'clients.nom','clients.prenom', 'biens.details')->paginate(1);
    }
         /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addDivers(Request $request)
    {
       
           $this->validate($request, [

            //'fichier'  => 'required|mimes:doc,docx,pdf,txt|max:2048',
            'commentaire' => 'required',
  

        ]);
        $divers = new Divers();

       if ($request->fichier) {
           $name = time() . '.' . explode('/', explode(':', substr($request->fichier, 0, strpos($request->fichier, ';')))[1])[1];
       

          \Image::make($request->fichier)->save(public_path('img/profile/') . $name);
        
           $request->merge(['fichier' => $name]);
       }
       
//        $file = $request->file('fichier');
      
// //Display File Name
// echo 'File Name: '.$file->getClientOriginalName();
// echo '
// ';
// //Display File Extension
// echo 'File Extension: '.$file->getClientOriginalExtension();
// echo '
// ';
// //Display File Real Path
// echo 'File Real Path: '.$file->getRealPath();
// echo '
// ';
// //Display File Size
// echo 'File Size: '.$file->getSize();
// echo '
// ';
// //Display File Mime Type
// echo 'File Mime Type: '.$file->getMimeType();
// //Move Uploaded File
// $destinationPath = 'img/profile/';
// $file->move($destinationPath,$file->getClientOriginalName());
       
$divers->commentaire=$request['commentaire'];
        $divers->operations=$request['operations'];
        $divers->fichier= $request['fichier'];
        $divers->save();
        
        return Response()->json(["status"=>200,'message' => "succes"]);

    }
    
}
