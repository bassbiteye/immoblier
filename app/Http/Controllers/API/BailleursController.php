<?php

namespace App\Http\Controllers\API;

use App\Bailleurs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BailleursController extends Controller
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
        return Bailleurs::latest()->paginate(10);
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
            'nomComplet' => 'required|string|max:191',
            'adresse' => 'required|string|max:191',
            'telephone' => 'required|string|max:191'

        ]);
      
        return Bailleurs::create([
            'nomComplet' => $request['nomComplet'],
            'adresse' => $request['adresse'],
            'telephone' => $request['telephone'],
    

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
        $bailleur = Bailleurs::findOrFail($id);
        $this->validate($request, [
            'nomComplet' => 'required|string|max:191',
            'adresse' => 'required|string|max:191',
            'telephone' => 'required|string|max:191'
        ]);
        $bailleur->update($request->all());
        return ['message' => 'bailleur has been updated'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bailleur = Bailleurs::findOrFail($id);
        $bailleur->delete();
        return ['message' => 'bailleur has been deleted'];
    }
    public function countbailleurs(){
        return Bailleurs::count();
    }
}
