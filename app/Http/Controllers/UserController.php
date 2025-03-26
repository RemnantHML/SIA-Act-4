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
    public function add(Request $request ){
        $rules = [
            'username' => 'required|max:20',
            'password' => 'required|max:20',
        
        ];

        $this->validate($request, $rules);

        $user = User::create($request->all());
        
        return $this->successResponse($user, Response::HTTP_CREATED);


    }
    public function updateUser(Request $request) {
        // Get username, new username, and password from request body
        $username = $request->input('username'); // Existing username
        $newUsername = $request->input('new_username'); // New username (optional)
        $password = $request->input('password'); // New password (optional)
    
        // Validate input
        if (!$username || (!$newUsername && !$password)) {
            return response()->json(['error' => 'Provide username and at least one field to update'], 400);
        }
    
        // Find the user by the current username
        $user = User::where('username', $username)->first();
    
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
    
        // Check if new username is taken
        if ($newUsername && User::where('username', $newUsername)->exists()) {
            return response()->json(['error' => 'New username already taken'], 400);
        }
    
        // Update username if provided
        if ($newUsername) {
            $user->username = $newUsername;
        }
    
        // Update password if provided
        if ($password) {
            $user->password = bcrypt($password); // Hash password
        }
    
        $user->save(); // Save changes
    
        return response()->json(['message' => 'User updated successfully'], 200);
        
        $user = User::where('username', $username)->first();
        dd($user);

    }
    
}