<?php

namespace App\Http\Controllers\API;

use App\Clients;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        if(\Gate::allows('isAdmin')||\Gate::allows('isAuthor')){
        return Clients::latest()->paginate(10);
        }
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
            'nationalite' => 'required|string|max:191',
            'profession' => 'required|string|max:191',
            'tel' => 'required|string|tel|max:191|unique:clients',
            'tel' => 'required|string|min:6'
        ]);
        $client = Clients::where('tel', $request->tel)->first();

        if (isset($client->id)) {
            return response()->json(["error" => "telephone already exists"], 401);
        }
        return Clients::create([
            'nom' => $request['nom'],
            'prenom' => $request['prenom'],
            'adresse' => $request['adresse'],
            'tel' => $request['tel'],
            'profession' => $request['profession'],
            'nationalite' => $request['nationalite']


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
        $client = clients::findOrFail($id);
        $this->validate($request, [
            'nom' => 'required|string|max:191',
            'prenom' => 'required|string|max:191',
            'tel' => 'required|string|max:191',
            'nationalite' => 'required|string|max:191',
            'profession' => 'required|string|max:191',
            'tel' => 'required|string|tel|max:191|unique:clients',
            'tel' => 'required|string|min:6'
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
        $client = clients::findOrFail($id);
        $client->delete();
        return ['message' => 'client has been deleted'];
    }
}
