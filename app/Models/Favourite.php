<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favourite extends Model
{
    use HasFactory;
    protected $table = 'favourite';
    protected $guarded = [];

    public function addToFavourite() : BelongsTo{
        return $this -> belongsTo(User::class);
    }
}
