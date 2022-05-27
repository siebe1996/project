<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Game_User extends Pivot
{
    public function games(){
        return $this->belongsTo(Game::class);
    }
}
