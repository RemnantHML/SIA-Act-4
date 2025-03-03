<?php
namespace App\Models;



use Illuminate\Database\Eloquent\Model;
 class User extends Model{
     protected $table = 'tbl_user';
// column sa table
     protected $fillable = [
     'username', 'password'
   ];
}