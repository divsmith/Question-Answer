<?php
/**
 * Created by PhpStorm.
 * User: parker
 * Date: 12/15/17
 * Time: 2:14 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answers';
    protected $fillable = ['uuid', 'question_uuid', 'text', 'user_email', 'upvotes'];
}