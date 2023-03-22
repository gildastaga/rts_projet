<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use app\Models\Professeurs;
use Illuminate\Http\Request;
use Illuminate\http\JsonResponse;
use DateTime;
use DatePeriod;
use DateInterval;

class Disponibilites extends Model
{
    use HasFactory;

    protected $table = 'disponibilites';

    static $rules=[
        'jour'=>'required',
        'debut'=>'required',
        'fin'=>'required'
    ];
    protected $fillable =['jour','debut','fin',];

    public function professeur(){
        return $this->belongsTo(Professeurs::class,'professeur_id');
    }
    // recoir l'id, le debut ,la fin d'une disponibilite  d'un professeur en parametre et revoir vrai elle n'existe pas
    public function getdisponibiliteByProf(int $id,$debut,$fin){
        return empty( Disponibilites::where('professeur_id', $id)
                                ->where('Debut',$debut)
                                ->where('Fin',$fin)->get());
    }
    //recoir l'id d'un professeur en parametre et revoir ses disponibilite sur une semaine 
    public static function getdisponibiliteProfsur_semaine(int $id){
        $t=[];
       for($i=1; $i<8;$i++){
        array_push($t, Disponibilites::where('professeur_id', $id)
                                       ->where('jour',$i)
                                       ->get());
       }
        return $t;
    }
    // recoir l'id d'un prof et une plage de date en parametre et revoir ses diponibilites sur cette plage 
    public static function getDis(int $idProf,Request $request){ 
        $disponibilite_dates =[];
        $debut = new DateTime($request->query('debut'));
        $fin =  new DateTime($request->query('fin'));
        $array=['Monday','Tuesday','Wednesday','Jeudi','Friday','Saturday','Sunday']; 
        $interval = DateInterval::createFromDateString('1440 min');
        $periods = new DatePeriod($debut, $interval, $fin->add(new DateInterval('P1D'))) ;
        foreach ($periods as $dt) {
            $i = 1;
            foreach($array as $arra){
                if(strcmp($arra ,$dt->format("l"))==0){
                    $indexJour =$i;
                    $dispo_jours = Disponibilites ::getdisponibiliteProfsur_semaine($idProf);
                    foreach($dispo_jours as $dispo_jour){
                        foreach($dispo_jour as $dispo){
                            if($indexJour== $dispo->jour)
                                array_push($disponibilite_dates, ["debut"=>$dt->format("l Y-m-d ").$dispo->Debut,"fin"=>$dt->format("l Y-m-d ").$dispo->Fin]);
                            }
                        }
                    }
                    $i++;
                }
            }
        return $disponibilite_dates;
    }

     // renvoie tous les rendez-vous d'un prof et un eleves precis reponce json
     // la meme se trouve dans le model rendeVous
    public static function getRendezVousByProfEleve(Request $request){
        $rdvs= RendezVous ::where('professeur_id',$request->query('professeur_id'))
                            ->orwhere('eleve_id',$request->query('eleve_id'))
                            ->get();
        $resul=[];
        foreach($rdvs as $rd){
            array_push($resul,["debut"=>$rd->Debut,"fin"=>$rd->Fin]);
        }
        return $resul;
    }
//recoir une disponibilite la sauve si le jour de la disponibilite est compriser entre 1=lundi et 7= dimanche 
//et renvoir tous les disponibilite du prof par semaine ou un message erreur  
    public static function addDisponibilite ($dispo){
        if($dispo->jour>0 || $dispo->jour <8){
            $dispo->save(); 
            $resul =Disponibilites::getAlldisponibiltesProf($dispo->professeur_id);
        }else{
            $resul = "choisir un jour entre 1 et 7";
        }
        return $resul;
    }
//recoir l'identifiant d'un profs et  renvoir tous les disponibilite du prof par semaine 
    public static function getAlldisponibiltesProf($professeur_id){
        $resul=[];
        for($i=1; $i<8;$i++){
            array_push($resul,Disponibilites::where('professeur_id',$professeur_id)
            ->where('jour',$i)
            ->get());
        } 
        return $resul;
    }
     //recoir l'indentifiant d'un prof , une heure de debut et fin  et revoir vrai s'il est disponible
     public function estDispoProf(int $professeur_id,$debut,$fin ){
        return empty(Disponibilites :: where('professeur_id',$professeur_id)
                                                ->where('Debut',$debut)
                                                ->where('Fin',$fin)
                                                ->get());
    }


     /**
     * Delete a disponibilite by ID.
     */
    public function deleteById(int $id){
        $dispo = Disponibilites::findOrFail($id);
        $dispo->delete();
        $resul = Disponibilites::all();
        return $resul;
    }

    // recoir l'identifia,t d'un prof et le numero du jour de la semaine  et revoir un tableau de disponiilite 

    public static function getdisponibiliteJourProf(int $i, int $professeur_id){
       return $dispos = Disponibilites ::where('jour',$i)
                                        ->where('professeur_id',$professeur_id)
                                        ->get();
    }

    //recoir un rendez-vous et revoir le jour de la semaine corespondant 

    public static function getJourDeLaSemainePourLeRendezVous($dispo){
        echo"je suis la ";
        $arrays=['Monday','Tuesday','Wednesday','Jeudi','Friday','Saturday','Sunday']; 
        $i = 1;
        foreach($arrays as $array){
            if(strcmp($array , $dispo->format("l"))==0){
                return $i;               
            }
            $i++;
        }
    }
}
