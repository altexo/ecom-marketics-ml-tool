<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    //
    protected $table = 'messages';
    
    protected $casts = [
        'conversation' => 'array',
        'conversation_status' => 'array'
      ];


}
