<?php

namespace App\Http\Controllers;
use app\Accounts;
use Illuminate\http\Response;
use App\Models\Disponibilites;
use App\Models\RendezVous;
use App\Transformers\profTransformer;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\http\JsonResponse;
use DateTime;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use Carbon\Doctrine\CarbonType;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\Date;
use phpDocumentor\Reflection\Types\Boolean;

class DisponibilitesController extends Controller
{

    /**
     * Controller constructor.
     *
     * @param  \App\Disponibilites  $disponibilite
     */
    public function __construct(Disponibilites $disponibilite)
    {
        $this->disponibilite = $disponibilite;
    }
    /**
     * Get all  disponibilites.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $disponibilites = Disponibilites::all();

        return response()->json($disponibilites, 200);
    }
    /**
     * Store a dispo.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */

     //ajoute une disponibilite .a pour parametre(jour,heure de debut ,heure de fin,professeur_id)
     //et renvoir les disponibilites de  se prof
    public function add(Request $request): JsonResponse
    {  
        $dispo = new Disponibilites();
        $dispo->professeur_id = $request->professeur_id;
        $dispo->jour = $request->jour;
        $dispo->Debut =$request->Debut;
        $dispo->Fin =$request->Fin;
        $resul = Disponibilites::addDisponibilite($dispo);
        return response()->json($resul, 200);
    }
    //renvoir sur une semaine les plage d'une heure   
    public function getAgendar_sur_semainejson(){
        $disponibilite_sur_semaine = [];
        for($i=1; $i<=7;$i++){
            $interval = DateInterval::createFromDateString('60 min');
            $periods = new DatePeriod(new DateTime("00:00:00"), $interval, new DateTime("24:00:00")) ;
            foreach ($periods as $dt) {
               array_push($disponibilite_sur_semaine, $i ,$dt->format(" H:i:s"));
            }
        }
        return response()->json($disponibilite_sur_semaine, 200);
    }

    //recoisr l'indentifiant d'un prof , une heure de debut et fin  et revoir vrai s'il est disponible
    public function estDispoProfjson(int $professeur_id,$debut,$fin ){
        return response()->json(empty(Disponibilites ::estDispoProf( $professeur_id,$debut,$fin)));
    }

// modifier une disponibilite 
    /**
     * Update a disponibilite.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse{
        $dispo = Disponibilites::findOrFail($id);
        $dispo->professeur_id = $request->professeur_id;
        $dispo->jour = $request->jour;
        $dispo->Debut = $request->Debut;
        $dispo->Fin = $request->Fin;
        $changes = $dispo->getDirty();
        $resul = $dispo->save();
       Disponibilites::all();
        return response()->json($resul, 200);
    }

     /**
     * Delete a eleve by ID.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteByIdjson(int $id): JsonResponse {
        $dispo = Disponibilites::findOrFail($id);
        $dispo->delete();
        $resul = Disponibilites::all();
        return response()->json($resul,200 ) ;
    }

    public function deleteById(int $id) {
        $dispo = Disponibilites::findOrFail($id);
        $dispo->delete();
        $resul = Disponibilites::all();
        return $resul;
    }

    /**
     * Store a disponiblite.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
// recoir en param les donnee une dispo  la sauve et revoir la plage en morceau de 1h json 
public function disponibilite_datesjson(Request $request){
    $disponibilite_dates = [];
    $dispo = new Disponibilites();
    $dispo->jour = $request->jour;
    $dispo->professeur_id = $request->professeur_id;
    $debut = new DateTime($request->debut);
    $dispo->Debut =$debut->format("H:i:s");
    $fin = new DateTime($request->fin);
    $dispo->Fin =$fin->format("H:i:s");
    $interval = DateInterval::createFromDateString('60 min');
    $periods = new DatePeriod($debut, $interval,$fin->add($interval)) ;
    foreach ($periods as $dt) {
        array_push($disponibilite_dates, $dt->format("l Y-m-d H:i:s"));
    }
    if($dispo->jour>0|| $dispo->jour<8){
        $dispo->save();
        return response()->json($disponibilite_dates, 200);
    }else{
        return response()->json("choisir un jour de la semaine entre 1 et 7 exp lundi =1 dimanche = 7 ", 200);
    }
    
}
//recoir en param une dispo  la sauve et revoir la plage en morceau de 30 min
public function disponibilite_dates(Request $request){
    $disponibilite_dates = [];
    $debut = $request->Debut;
    $fin = $request->Fin;
    $interval = DateInterval::createFromDateString('30 min');
    $periods = new DatePeriod(new DateTime($debut), $interval, new DateTime($fin)) ;
    foreach ($periods as $dt) {
        array_push($disponibilite_dates, $dt->format("l Y-m-d H:i:s"));
    }
    $dispo = new Disponibilites();
        $dispo->jour = $dt->format("l  Y-m-d");
        $dispo->professeur_id = $request->professeur_id;
        $dispo->Debut = new DateTime($debut);
        $dispo->Fin =new DateTime($fin);
        $dispo->save();
        $resul = Disponibilites::all();
    return response()->json( $disponibilite_dates,200);
}



// recoir l'id, le debut ,la fin d'une disponibilite  d'un professeur en parametre et revoir vrai elle n'existe pas
    public function getdisponibiliteByProfjson(int $id,$debut,$fin){
        $t = Disponibilites::where('professeur_id', $id)
                            ->where('Debut',$debut)
                            ->where('Fin',$fin)->get();
        return response()->json(empty($t), 200);
    }
// recoir l'id, le debut ,la fin d'une disponibilite  d'un professeur en parametre et revoir vrai elle n'existe pas
    public function getdisponibiliteByProf(int $id,$debut,$fin){
        return empty( Disponibilites::where('professeur_id', $id)
                                ->where('Debut',$debut)
                                ->where('Fin',$fin)->get());
    }

//recoir l'id d'un professeur en parametre et revoir ses disponibilite sur une semaine 
    public function getdisponibiliteProfsur_semainejson(int $id){
        $t=[];
       for($i=1; $i<8;$i++){
        array_push($t, Disponibilites::where('professeur_id', $id)
        ->where('jour',$i)
        ->get());
       }
        return response()->json($t, 200);
    }
    
    //recoir un rdv et une dispo en parametre et revoie vrai le rendez-vous est comprise entre
    //la disponoibilite (heure de debut de la dispo et fin de la dispo)

    public function  is_conflit( $dispo,  $dateRdv) {
        $dispo_Debut = new DateTime($dispo['debut']);
        $dispo_Fin = new DateTime($dispo['fin']);
        $dateRdv_debut = new DateTime($dateRdv['debut']);
        $dateRdv_fin = new DateTime($dateRdv['fin']);
        return (($dateRdv->Fin > $dispo_Debut)&&($dateRdv->Debut < $dispo_Fin));
    }
    //recoir un rdv et une dispo en parametre et revoie vrai le rendez-vous est comprise entre
    //la disponoibilite (heure de debut de la dispo et fin de la dispo)

    public function conflitjson($dispo,$dateRdv){
        $dispo_Debut = new DateTime($dispo['debut']);
        $dispo_Fin = new DateTime($dispo['fin']);
       return response()->json((  $dateRdv->Fin > $dispo_Debut)&&(  $dateRdv->Debut < $dispo_Fin));
    }

// recoir un rendez-vous et un array de disponibilite renvoir la diponibilite si conflit avce le rdv et false si non

    public function search_conflit($dispo_dates,$rdv ){
        foreach($dispo_dates as $dispo){
            if($this->is_conflit($dispo,$rdv)==true){
               return $dispo;
            }
       }
       return  false;
    }
   
// recoir une disponibilie et rendez-vous  et filtre les espase libre

    function split($dispo , $rdv){
        $disponible = [];
        $dispo_Debut = new DateTime($dispo['debut']);
        $dispo_Fin = new DateTime($dispo['fin']);
        if( $rdv->Debut < $dispo_Debut && $rdv->Fin>$dispo_Fin ){
             return $disponible;
        }else{
            if($rdv->Debut>=$dispo_Debut &&$dispo_Fin>= $rdv->Fin){
                if($dispo_Debut<$rdv->Debut){
                    array_push($disponible,["debut"=>$dispo_Debut->format("l Y-m-d H:i:s"),"fin"=>$rdv->Debut->format("l Y-m-d H:i:s")]);
                     array_push($disponible,["debut"=>$rdv->Fin->format("l Y-m-d H:i:s"),"fin"=>$dispo_Fin->format("l Y-m-d H:i:s")]);
                }else{
                    array_push($disponible,["debut"=>$rdv->Fin->format("l Y-m-d H:i:s"),"fin"=>$dispo_Fin->format("l Y-m-d H:i:s") ]);
                }
            }
            if($rdv->Fin < $dispo_Debut ||  $dispo_Fin < $rdv->Debut){
                array_push($disponible,["debut"=>$dispo_Debut->format("l Y-m-d H:i:s"),"fin"=>$dispo_Fin->format("l Y-m-d H:i:s")]);
            }
            if($rdv->Debut  <= $dispo_Fin&& $dispo_Fin  < $rdv->Fin ){
                    array_push($disponible,["debut"=>$dispo_Debut->format("l Y-m-d H:i:s"),"fin"=>$rdv->Debut->format("l Y-m-d H:i:s")]);
            }
            if( $dispo_Debut <= $rdv->Fin && $rdv->Fin  < $dispo_Fin){
              if($dispo_Debut>$rdv->Debut)  {
                  array_push($disponible,["debut"=>$rdv->Fin->format("l Y-m-d H:i:s"),"fin"=>$dispo_Fin->format("l Y-m-d H:i:s") ]);}
            }
           
            return $disponible;
        }    
        
    }
    //recoir un array de disponibilite et un rendez-vous cherche s'il y'a conflit 
    //si oui repar et revoir les disponibiliter possible encore 
     

    public function getdisponibilitepossibles  ($dispo_dates, $rdv){
        $dispo = $this->search_conflit($dispo_dates, $rdv);
        if($dispo!== false){
            $resul = $this->split($dispo,$rdv);
            unset($dispo_dates[array_search($dispo, $dispo_dates)]);
            $dispo_dates = array_merge( $dispo_dates,$resul);
        }
        return response()->json($dispo_dates,200);
    }
    // pour le test
    public function getdisponibilitepossible  (Request $request){
        $dispo_dates=Disponibilites::getDis($request->query('professeur_id'),$request);
        $rdvs =Disponibilites::getRendezVousByProfEleve($request);
        foreach($rdvs as $rdv){
            $rdv = new RendezVous();
            $rdv->Debut = new DateTime($rdv['debut']);
            $rdv->Fin = new DateTime($rdv['fin']);
            $dispo = $this->search_conflit($dispo_dates, $rdv);
            if($dispo!== false){
                $resul = $this->split($dispo,$rdv);
                unset($dispo_dates[array_search($dispo, $dispo_dates)]);
                $dispo_dates = array_merge( $dispo_dates,$resul);
            }
        }    
        return response()->json($dispo_dates,200);
    }   
}
