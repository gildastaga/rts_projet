<?php

namespace App\Http\Controllers;
use App\Accounts;
use App\Models\Disponibilite;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\Professeurs;
use App\Transformers\profTransformer;
use Illuminate\Validation\ValidationException;

class ProfesseursController extends Controller
{

    /**
     * Controller constructor.
     *
     * @param  \App\Professeurs  $prof
     */
    public function __construct(Professeurs $Prof)
    {
        $this->Prof = $Prof;
    }

    /**
     * Get all the Profs.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $Profs = Professeurs::all();
        return response()->json($Profs, 200);
    }


    public function getDisponiblitesByProf(int $id){
        $prof = new Professeurs();
        $t = $prof->find($id)->disponibilites;
        return response()->json($t, 200);
    }

    public function getRendezVousByProf(int $id){
        $prof = new Professeurs();
        $t = $prof->find($id)->rendezvous;
        return response()->json($t, 200);
    }


    /**
     * Store a profs.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        $prof = new Professeurs();
        $prof->Nom = $request->Nom;
        $prof->Prenom = $request->Prenom;
        $prof->save();
        $resul = Professeurs::all();
        return response()->json($resul, Response::HTTP_CREATED);
    }


    /**
     * Store a proflist.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(Request $request){
            $prof = new Professeurs();
            $prof->Nom = $request->Nom;
            $prof->Prenom = $request->Prenom;
            $prof->save();
            $resul = Professeurs::all();
            return response()->json($resul, 200);
    }

    /**
     * Update a prof.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse{
        
        $prof = Professeurs::findOrFail($id);
        $prof->Nom = $request->Nom;
        $prof->Prenom = $request->Prenom;
        // if (!$prof->isValidFor('CREATE')) {
        //     throw new ValidationException($prof->validator());
        // }
        $changes = $prof->getDirty();
        $prof->save();
        $resul = Professeurs::all();
       // return fractal($prof, new profTransformer())->toArray();
        return response()->json($resul, 200);
    }

    /**
     * Delete a prof by ID.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteprofById(int $id): JsonResponse
    {
        $prof = Professeurs::findOrFail($id);
        $prof->delete();
        $resul = Professeurs::all();
        return response()->json($resul,200 ) ;
    }


    /**
     * Controller constructor.
     *
     * @param  \App\Accounts  $accounts
     */
    // public function __construct(Accounts $accounts)
    // {
    //     $this->accounts = $accounts;
    // }

    // /**
    //  * Get all the profd.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function index(Request $request): JsonResponse
    // {

    //     $Profs = $this->accounts->getProfs($request);

    //     return response()->json($Profs, 200);
    // }

    // /**
    //  * Store a profs.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function store(Request $request): JsonResponse
    // {
    //     $Profs = $this->accounts->storeprof($request->all());

    //     return response()->json($Profs, Response::HTTP_CREATED);
    // }

    // /**
    //  * Get a Prof.
    //  *
    //  * @param  int  $id
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function show(int $id): JsonResponse
    // {
    //     $Prof = $this->accounts->getProfById($id);

    //     return response()->json($Prof, 200);
    // }

    // /**
    //  * Update a Prof.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int                       $id
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function update(Request $request, int $id): JsonResponse
    // {
    //     $Prof = $this->accounts->updateProfById($id, $request->all());

    //     return response()->json($Prof, 200);
    // }

    // /**
    //  * Delete a Prof.
    //  *
    //  * @param  int  $id
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function destroy(int $id): JsonResponse
    // {
    //     $this->accounts->deleteProfById($id);

    //     return response()->json(null, Response::HTTP_NO_CONTENT);
    // }
}
