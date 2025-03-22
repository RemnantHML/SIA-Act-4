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
       $users = User::all();
       return response()->json($users, 200);
       return $this->successResponse($users);
    }

    public function index(){
        $users = User::all();
        return $this->successResponse($users);
    }
    public function add(Request $request ){
        $rules = [
            'username' => 'required|max:20',
            'password' => 'required|max:20',
        
        ];

        $this->validate($request, $rules);

        $user = User::create($request->all());
        
        return $this->successResponse($user, Response::HTTP_CREATED);


    }
    public function updateUser(Request $request)
    {
        // Get username and password from query parameters
        $username = $request->query('username');
        $password = $request->query('password');

        // Validate input
        if (!$username || !$password) {
            return response()->json(['error' => 'Username and password are required'], 400);
        }

        // Find the user by username
        $user = User::where('username', $username)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Update user password
        $user->password = bcrypt($password); // Hash password
        $user->save();

        return response()->json(['message' => 'User updated successfully'], 200);
    }
}