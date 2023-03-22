<?php

namespace App\Http\Controllers;
use App\Accounts;
use App\Models\Disponibilites;
use Illuminate\http\Response;
use App\Models\RendezVous;
use App\Transformers\profTransformer;
use Illuminate\Validation\ValidationException;
use Illuminate\http\JsonResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;
use Ramsey\Uuid\Type\Time;

class RendezVousController extends Controller
{
     /**
     * Controller constructor.
     *
     * @param  \App\RendezVous  $rendezVous
     */
    public function __construct(RendezVous $rendezVous)
    {
        $this->rendezVous = $rendezVous;
    }
    /**
     * Get all the RendezVous.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $rendezVous = RendezVous::all();

        return response()->json($rendezVous, 200);
    }
    /**
     * Store a RendezVous.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function add(Request $request): JsonResponse
    {
        $rendezVous = new RendezVous();
        $rendezVous->professeur_id = $request->professeur_id;
        $rendezVous->eleve_id = $request->eleve_id;
        $rendezVous->Debut =new DateTime($request->Debut);
        $rendezVous->Fin =new DateTime($request->Fin);
        return response()->json( RendezVous::addRendezVous($rendezVous));
    }
    // recoir l'heure de debut et fin revoir les rendez-vous si trouve 
    public function getRendezVousbyPlageHoraire($debut,$fin){
        return RendezVous::where('Debut',$debut)
        ->where('Fin',$fin)
        ->get();
    }

    /**
     * Store a RendezVous.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(Request $request){
        $rendezVous = new RendezVous();
        $rendezVous->professeur_id = $request->professeur_id;
        $rendezVous->eleve_id = $request->eleve_id;
        $rendezVous->jour_semaine = $request->jour_semaine;
        $rendezVous->Debut =$request->Debut;
        $rendezVous->Fin =$request->Fin;
        $resul =RendezVous::addRendezVous($rendezVous);
        return response()->json($resul, 200);
    }

    /**
     * Update a RendezVous.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse{

        $rendezVous = RendezVous::findOrFail($id);
        $rendezVous->professeur_id = $request->professeur_id;
        $rendezVous->eleve_id = $request->eleve_id;
        $rendezVous->Debut =$request->Debut;
        $rendezVous->Fin =$request->Fin;
        $changes = $rendezVous->getDirty();
        $rendezVous->save();
        $resul = RendezVous::getRendezProfEleve($request->professeur_id,$request->eleve_id);
        return response()->json($resul, 200);
    }

     /**
     * Delete a RendezVous by ID.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteById(int $id): JsonResponse
    {
        $rendezVous = RendezVous::findOrFail($id);
        $rendezVous->delete();
        $resul = RendezVous::all();
        return response()->json($resul,200 ) ;
    }
// return  tous les rendez-vous d'un eleve de la db 
    public function getRendezVousByeleve(int $id){
        $t = RendezVous::where('eleve_id', $id)->get();
        return response()->json($t, 200);
    }
//return tous les rendez-vous d'un prof de la db 
    public function getRendezVousByProf(int $id){
        $t = RendezVous::where('professeur_id', $id)->get();
        return response()->json($t, 200);
    }
//boolean methode true si 
    public function compareto(){
        for($jour=1;$jour<8 ; $jour++){
            for($heures =0; $heures < 23; $heures ++){
                for ( $minutes = 0 ; $minutes <= 30 ; $minutes += 30 ){
           
            }
        }
    }

    }
   // recoir l'identifiant d'un prof et d'un élèves en parametre et renvoir toute leurs disponibilites 
    public function getRendezVousByProfElevejson(Request $request){
        $rdvs = Rendezvous::getRendezVousByProfEleve($request->query('professeur_id'),$request->query('eleve_id'));
        return response()->json($rdvs, 200);
    }
}