<?php

namespace App\Models;
use App\Models\Eleves;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Professeurs;

class RendezVous extends Model
{
    use HasFactory;
    static $rules=[
        'debut'=>'required',
        'fin'=>'required'
    ];
    protected $fillable =['debut','fin',];
    protected $table ="rendez_vous";

    public function professeur(){
        return $this->belongsTo(Professeurs :: class,'professeur_id');
    }
    public function eleve(){
        return $this->belongsTo(Eleves :: class,'eleve_id');
    }

    // renvoie tous les rendez-vous d'un prof et un eleves precis reponce json
     // la meme se trouve dans le model rendeVous
     public static function getRendezVousByProfEleve($professeur_id,$eleve_id){
        $rdvs= RendezVous ::where('professeur_id',$professeur_id)
                            ->orwhere('eleve_id',$eleve_id)
                            ->get();
        $resul=[];
        foreach($rdvs as $rdv){
            array_push($resul,["debut"=>$rdv->Debut,"fin"=>$rdv->Fin]);
        }
        return $resul;
    }
    // renvoie tous les rendez-vous d'un prof avec  un eleves precis reponce json
     // la meme se trouve dans le model rendeVous
     public static function getRendezProfEleve($professeur_id,$eleve_id){
        $rdvs= RendezVous ::where('professeur_id',$professeur_id)
                            ->where('eleve_id',$eleve_id)
                            ->get();
        $resul=[];
        foreach($rdvs as $rdv){
            array_push($resul,["debut"=>$rdv->Debut,"fin"=>$rdv->Fin]);
        }
        return $resul;
    }

    // ajouter en rendez-vous la disponibilite exsite si non renvoir suis pas disponible
    public static function addRendezVous( $rendezVous){
        $num_jour = RendezVous::getJourDeLaSemainePourLeRendezVous($rendezVous);
        echo'test';
        echo "\n ";
        $dispos = Disponibilites::getdisponibiliteJourProf($num_jour, $rendezVous->professeur_id);               
        if(count($dispos) == 0){
            return " je ne suis pas disponible  if";
        }else{
            $rdv= $rendezVous->save();
            return $rdv;
         }  
    }

    //recoir un rendez-vous et revoir le jour de la semaine corespondant 

    public static function getJourDeLaSemainePourLeRendezVous($rendezVous){
        $arrays=['Monday','Tuesday','Wednesday','Jeudi','Friday','Saturday','Sunday']; 
        $i = 1;
        foreach($arrays as $array){
            if(strcmp($array , $rendezVous->Debut->format("l"))==0){
                return $i;               
            }
            $i++;
        }
    }

}
