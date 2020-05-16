<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Comptes;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Console\Helper\Table;

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
            //return User::latest()->paginate(10);

            return User::where('type','bailleurs')->paginate(10);
    
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
            'name' => 'required|string|max:191',
            'adresse' => 'required|string|max:191',
            'telephone' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,',
            'password' => 'sometimes|required|min:6',
            'email' => 'sometimes|min:6',
            'profession'=> 'required|string|max:191',
            'nationalite'=> 'required|string|max:191',
            'typecomptes_id'=> 'required|int',

            
        ]);
        $bailleur = User::where('email', $request->email)->first();

        if (isset($bailleur->id)) {
            return response()->json(["error" => "email already exists"], 401);
        }
       
        $date = (154263);
        $min_epoch = strtotime($date);
        $var = rand($min_epoch,1000);
        $strval ='FR_401';
        $items = ($strval.$var); 
        $bailleur = new User();
        $bailleur->name = $request['name'];
        $bailleur->adresse = $request['adresse'];
        $bailleur->telephone = $request['telephone'];
        $bailleur->email = $request['email'];
        $bailleur->type = $request['type'];
        $bailleur->numero= $items;
        $bailleur->solde= 0; 
        $bailleur->profession=$request['profession'];
        $bailleur->bp=$request['bp'];
        $bailleur->nationalite=$request['nationalite'];
        $bailleur->password = Hash::make($request['password']);
        $bailleur->save();
        return $bailleur;

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
        $bailleur = User::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'adresse' => 'required|string|max:191',
            'telephone' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,' . $bailleur->id,
            'email' => 'sometimes|min:6',
            'profession'=> 'required|string|max:191',
            'nationalite'=> 'required|string|max:191',
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
        $bailleur = User::findOrFail($id);
        $bailleur->delete();
        return ['message' => 'bailleur has been deleted'];
    }
    public function countbailleurs(){
        return User::where('type', 'bailleurs')->count();
    }
}
