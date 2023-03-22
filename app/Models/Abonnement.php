<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Abonnement extends Model
{
    use HasFactory;
    protected $table ="Abonnements";
    protected $fillable =['debut','fin','petienId'];

       /**
     * Get the comments for the blog post.
     */
    public function abonnement()
    {
        return $this->hasMany(abonnement::class,'eleve_id petienId');
    }
}
