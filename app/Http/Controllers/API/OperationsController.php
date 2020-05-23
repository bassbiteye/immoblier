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
            ->leftJoin('clients', 'operations.clients', '=', 'clients.client_id')
            ->Join('biens', 'operations.biens', '=', 'biens.bien_id')
            ->Join('typeetats', 'typeetats.id', '=', 'biens.etat')
            ->select('operations.*', 'clients.*', 'biens.*', 'typeetats.libelleE')->paginate(10);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paiementactif()
    {

        return DB::table('operations')
            ->where('statut', 'louer')
            ->leftJoin('clients', 'operations.clients', '=', 'clients.client_id')
            ->Join('biens', 'operations.biens', '=', 'biens.bien_id')
            ->Join('typeetats', 'typeetats.id', '=', 'biens.etat')
            ->select('operations.*', 'clients.*', 'biens.*', 'typeetats.libelleE')->paginate(10);
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
            ->select('operations.montantPaye', 'operations.ref', 'operations.operation_id', 'clients.nom', 'clients.prenom', 'clients.tel', 'biens.*', 'divers.commentaire', 'divers.fichier', 'divers.divers_id')->paginate(10);
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



        $client =  DB::table('clients')->where('tel', $request['numero'])->first();
        $bien = DB::table('biens')->where('bien_id', $request['bien_id'])->first();

        $caution = $bien->prix * 5;

        if ($request['caution'] > $caution) {
            return Response()->json([
                "status" => 500,
                'message' => "la caution ne doit etre supérieur 5 fois au prix du location"
            ]);
        }
        if ($request['montantPaye'] > $caution) {
            return Response()->json([
                "status" => 500,
                'message' => "le montant payé ne doit etre supérieur 5 fois au prix du location"
            ]);
        }
        $montant =    $request['montantPaye'] * $request['taxes'] / 100;
        $montantttc = $montant - $request['commission'];

        $Operation = new Operations();

        if ($request->dernierelevé != []) {
            $dernierelevé = $this->upload($request->dernierelevé);
            $Operation->dernierelevé = $dernierelevé;
        }
        if ($request->piece != []) {
            $piece = $this->upload($request->piece);
            $Operation->piece = $piece;
        }

        $Operation->caution = $request['caution'];
        $Operation->montantPaye = $montantttc;
        $Operation->dateEntre = date("H:i:s", strtotime(request('dateEntre')));
        $Operation->commission = $request['commission'];
        $Operation->taxes = $request['taxes'];
        $Operation->durée = $request['durée'];
        $Operation->dateEntre = $request['dateEntre'];
        $Operation->commentaire = $request['commentaire'];

        $Operation->clients = $client->client_id;
        $Operation->biens = $bien->bien_id;
        $Operation->ref = rand(0, 1000000);
        //update bien
        $soleBien = $bien->solde + $request['montantPaye'];

        DB::table('biens')
            ->where('bien_id', $bien->bien_id)
            ->update(['louer' => true, 'solde' => $soleBien]);
        //update client
        $soldeCli = $request['montantPaye'] + $client->solde;
        DB::table('clients')
            ->where('client_id', $client->client_id)
            ->update(['solde' => $soldeCli]);
        if ($bien->bailleur == 1) {
            //update propriétaire
            $prop = User::findOrFail(1);
            $soldeP = $prop->solde + $montant;
            DB::table('users')
                ->where('id',  1)
                ->update(['solde' => $soldeP]);
        } else {
            //update bailleur
            $bailleur = User::findOrFail($bien->bailleur);
            $solde = $bailleur->solde + $montantttc;
            DB::table('users')
                ->where('id', $bien->bailleur)
                ->update(['solde' => $solde]);
            //update propriétaire
            $prop = User::findOrFail(1);
            $commission = $prop->commission + $request['commission'];
            $soldeP = $prop->solde + $commission;
            DB::table('users')
                ->where('id',  1)
                ->update(['solde' => $soldeP, 'commission' => $commission]);
        }


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



        $Operation = DB::table('operations')
            ->where('operation_id', $request['operation_id'])
            ->update(['statut' => 'revoquer']);

        DB::table('biens')
            ->where('bien_id', $request['bien_id'])
            ->update(['louer' => false]);
        return Response()->json(['operation' => $Operation]);
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

        $client =  DB::table('clients')->where('tel', $request['tel'])->first();
        $bien = DB::table('biens')->where('bien_id', $request['bien_id'])->first();

        $prix = $request['prix'];
        $montant = $request['montant'];
        $soleBien = $bien->solde + $montant;
        if ($montant < $prix) {
            return Response()->json([
                "status" => 500,
                'message' => "le montant payé ne doit etre inférieur  au prix du location"
            ]);
        } else
            if ($montant > $prix) {
            return Response()->json([
                "status" => 500,
                'message' => "le montant payé ne doit etre supérieur  au prix du location"
            ]);
        } else {
            DB::table('biens')
                ->where('bien_id', $bien->bien_id)
                ->update(['louer' => true, 'solde' => $soleBien]);
            //update client

            $soldeCli = $montant + $client->solde;
            DB::table('clients')
                ->where('client_id', $client->client_id)
                ->update(['solde' => $soldeCli]);
            if ($bien->bailleur == 1) {
                //update propriétaire
                $prop = User::findOrFail(1);
                $soldeP = $prop->solde + $montant;
                DB::table('users')
                    ->where('id',  1)
                    ->update(['solde' => $soldeP]);
            } else {
                //update bailleur
                $bailleur = User::findOrFail($bien->bailleur);
                $solde = $bailleur->solde + $montant;
                DB::table('users')
                    ->where('id', $bien->bailleur)
                    ->update(['solde' => $solde]);
                //update propriétaire
                $prop = User::findOrFail(1);
                $commission = $prop->commission + $request['commission'];
                $soldeP = $prop->solde + $commission;
                DB::table('users')
                    ->where('id',  1)
                    ->update(['solde' => $soldeP, 'commission' => $commission]);
            }

            $Operation = DB::table('operations')
                ->where('operation_id', $request['operation_id'])->first();

            $paie = DB::table('paiements')->where([
                ['operations', '=', $request['operation_id']],
                ['date', '=', $request['date']],
            ])->get();

            if ($paie == []) {
                return Response()->json([
                    "status" => 500,
                    'message' => "paiement déja enregistré"
                ]);
            }
            $paiement = new Paiements();
            $paiement->montant = $request['montant'];
            $paiement->date = $request['date'];
            $paiement->commission = $Operation->commission;
            $paiement->ref = rand(0, 1000000);
            $paiement->operations = $Operation->operation_id;

            $paiement->save();

            return Response()->json(["status" => 200, 'message' => "paiement effectué avec succes"]);
        }
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
            ->select('operations.montantPaye', 'operations.operation_id', 'clients.nom', 'clients.prenom', 'biens.details')->paginate(1);
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
        $fichier = $this->upload($request->fichier);

        $divers = new Divers();




        $divers->commentaire = $request['commentaire'];
        $divers->operations = $request['operations'];
        $divers->fichier = $fichier;
        $divers->save();

        return Response()->json(["status" => 200, 'message' => "succes"]);
    }

    public function upload($var)
    {


        $file = $var;



        //Display File Name
        echo 'File Name: ' . $file->getClientOriginalName();
        echo '';
        //Display File Extension
        echo 'File Extension: ' . $file->getClientOriginalExtension();
        echo '';
        //Display File Real Path
        echo 'File Real Path: ' . $file->getRealPath();
        echo '
        ';
        //Display File Size
        echo 'File Size: ' . $file->getSize();
        echo '
        ';
        //Display File Mime Type
        echo 'File Mime Type: ' . $file->getMimeType();
        //Move Uploaded File
        $destinationPath = 'img/profile/';
        $file->move($destinationPath, $file->getClientOriginalName());
        return $file->getClientOriginalName();
    }
}
