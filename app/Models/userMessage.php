<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usermessage extends Model
{
    use HasFactory;

        // define table in database
        protected $table = 'user_messages';

        protected $fillable = [
            'user_name', 'email', 'subject', 'discription',
        ];
}
