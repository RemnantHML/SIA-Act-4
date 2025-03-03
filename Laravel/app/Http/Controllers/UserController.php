<?php
namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\User;

Class UserController extends Controller {
    private $request;
    public function __construct(Request $request){
        $this->request = $request;
    }
    public function getUsers(){
     $users = User::all();
     return response()->json(['data' => $users], 200);
    }
}