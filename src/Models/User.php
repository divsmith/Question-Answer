<?php
/**
 * 20171011User: stringhamdb
 * Date: 10/11/17
 * Time: 2:50 PM
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password', 'upvoted'];
    protected $primaryKey = 'email';
    protected $keyType = 'string';
}