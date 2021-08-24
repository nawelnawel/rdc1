<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'prenom',
      
        'email',
        'telephone',
        'adresse',
        
        'pieceIdentite',
        'numeroPieceIdentite',
        'structure_id',
        
        
    ];

    public function Structure(){
        return $this->belongsTo(Structure::class);
    }
   

}
