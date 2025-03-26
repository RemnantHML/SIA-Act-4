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

    // Fetch all users
    public function getUsers(){
        $users = DB::connection('mysql')->select("SELECT * FROM tbl_user");
        return $this->successResponse($users);
    }

    // Fetch users using Eloquent
    public function index(){
        $users = User::all();
        return $this->successResponse($users);
    }

    // Add a new user
    public function add(Request $request) {
        $rules = [
            'username' => 'required|max:20|unique:users,username',
            'password' => 'required|max:255',
        ];

        $this->validate($request, $rules);

        // Hash password before storing
        $user = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        return $this->successResponse($user, Response::HTTP_CREATED);
    }

    // Update an existing user
    public function updateUser(Request $request) {
        $username = $request->input('username'); // Existing username
        $newUsername = $request->input('new_username'); // New username (optional)
        $password = $request->input('password'); // New password (optional)

        // Validate request
        if (!$username || (!$newUsername && !$password)) {
            return response()->json(['error' => 'Provide username and at least one field to update'], 400);
        }

        // Find user by current username
        $user = User::where('username', $username)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Check if the new username already exists
        if ($newUsername && User::where('username', $newUsername)->exists()) {
            return response()->json(['error' => 'New username already taken'], 400);
        }

        // Update username and password
        if ($newUsername) {
            $user->username = $newUsername;
        }

        if ($password) {
            $user->password = bcrypt($password); // Hash password
        }

        $user->save(); // Save changes to the database

        return response()->json(['message' => 'User updated successfully', 'updated_user' => $user], 200);
    }
}
