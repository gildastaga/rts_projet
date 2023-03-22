<?php

namespace App\Models;
use App\Models\RendezVous;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eleves extends Model
{
    use HasFactory;
    protected $table ="eleves";
    protected $fillable =['Nom','Prenom','rendezvousList'];

       /**
     * Get the comments for the blog post.
     */
    public function rendezvous()
    {
        return $this->hasMany(RendezVous::class,'eleve_id');
    }
}
