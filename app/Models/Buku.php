<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buku extends Model
{
    use HasFactory;


    protected $table = 'buku';
    protected $primarykey = 'id';
    protected $fillable = ['judul','penulis','harga', 'filename', 'filepath', 'rating','create_at','update_at', 'rating'];
    protected $dates = ['tgl_terbit'];

    public function galleries() : HasMany
    {
        return $this -> hasMany(Gallery::class);
    }

    
    public function photos() {
        return $this -> hasMany('App\Buku', 'id_buku', 'id');
    }

    public function ratings(){
        return $this->hasMany(Rating::class, 'buku_id', 'id');
    }

    public function ratingCount(){
        return Rating::count();
    }

    public function calculateAverageRating($id){

        $ratings = Rating::all();

        $total = 0;
        $count = 0;

        foreach ($ratings as $rating) {
            $total += $rating->rating;
            $count++;
        }

        return $count > 0 ? $total / $count : 0;
    }

}
