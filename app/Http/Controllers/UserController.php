<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\ApiResponser;
use DB;

class UserController extends Controller
{
    use ApiResponser;
    private $request;

    public function __construct(Request $request){
        $this->request = $request;
    }
    public function getUsers(){
        
        $users = DB::connection('mysql')
        ->select("Select * from tbl_user");
        //$users = User::all();  before 3a
       // return response()->json($users, 200);
       return $this->successResponse($users);
    }

    public function index(){
        $users = User::all();
        return $this->successResponse($users);
    }
}