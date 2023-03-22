<?php

namespace App\Models;
use App\Models\Disponibilite;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Professeurs extends Model
{
    use HasFactory;
    //public ArrayList<Disponibilites> $dispoList = new ArrayList<Disponibilites>();
    static $rules=[
        'Nom'=>'required',
        'Prenom'=>'required',
    ];
    protected $fillable =['Nom','Prenom',];
    protected $table = 'professeurs';
    
       /**
     * Get the disponibilite for the blog post.
     */
    public  function disponibilites()
    {
        return $this->hasMany(Disponibilite::class,'professeur_id');
    }


        /**
     * Get the rendezvous for the blog post.
     */
    public function rendezvous()
    {
        return $this->hasMany(RendezVous::class,'professeur_id');
    }
    public function addProf(){
        //
    }

    public function getDispoProf(){
        $dispos =Professeurs:: find(1)->disponibiltes;
        foreach ($dispos as $dispo) {

        }
    }
   

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $visible = [
        'id', 'Nom', 'Prenom','dispoList','rendezvousList'
    ];

    /**
     * Validation rules for the model.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            '*' => [
                'Nom' => 'required',
                'Prenom'=>'required',
            ],
            'CREATE' => [
                'Nom' => 'required|min:4',
                'Prenom'=>'required|min:4',
            ],
            'UPDATE' => [
                'Nom' => 'required|min:4',
                'Prenom'=>'required|min:4',
            ],
        ];
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }


}
