<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Traits\ApiResponser;
use DB;

class UserController extends Controller
{
    use ApiResponser;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    // Fetch all users
    public function getUsers()
    {
        $users = DB::connection('mysql')->select("SELECT * FROM tbl_user");
        return $this->successResponse($users);
    }

    public function index()
    {
        $users = User::all();
        return $this->successResponse($users);
    }

    // Add a new user
    public function add(Request $request)
    {
        $rules = [
            'username' => 'required|max:20|unique:users,username',
            'password' => 'required|max:20',
        ];

        $this->validate($request, $rules);

        $user = User::create([
            'username' => $request->input('username'),
            'password' => bcrypt($request->input('password')) // Encrypt password
        ]);

        return $this->successResponse($user, Response::HTTP_CREATED);
    }

    // Update an existing user
    public function updateUser(Request $request)
    {
        $username = $request->input('username'); // Current username
        $newUsername = $request->input('new_username'); // New username (optional)
        $password = $request->input('password'); // New password (optional)

        // Validate input
        if (!$username || (!$newUsername && !$password)) {
            return $this->errorResponse('Provide username and at least one field to update', 400);
        }

        // Find user by existing username
        $user = User::where('username', $username)->first();
        if (!$user) {
            return $this->errorResponse('User not found', 404);
        }

        // Check if new username is already taken
        if ($newUsername && User::where('username', $newUsername)->exists()) {
            return $this->errorResponse('New username already taken', 400);
        }

        // Prepare update data
        $updateData = [];
        if ($newUsername) {
            $updateData['username'] = $newUsername;
        }
        if ($password) {
            $updateData['password'] = bcrypt($password); // Encrypt password
        }

        // Update user in database
        $updated = User::where('username', $username)->update($updateData);

        if ($updated) {
            return $this->successResponse(['message' => 'User updated successfully', 'data' => $updateData], 200);
        } else {
            return $this->errorResponse('Update failed', 500);
        }
    }
}
