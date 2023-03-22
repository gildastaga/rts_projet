<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use app\Accounts;
use Illuminate\http\JsonResponse;
use Illuminate\http\Response;
use App\Models\Eleves;
use App\Transformers\profTransformer;
use Illuminate\Validation\ValidationException;

class ElevesController extends Controller
{


    /**
     * Controller constructor.
     *
     * @param  \App\Eleves  $eleve
     */
    public function __construct(Eleves $eleve)
    {
        $this->eleve = $eleve;
    }
    /**
     * Get all the eleves.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $eleves = Eleves::all();

        return response()->json($eleves, 200);
    }



    public function getRendezVousByeleve(int $id){
        $eleve = new Eleves();
        $t = $eleve->find($id)->rendezvous;
        return response()->json($t, 200);
    }


    /**
     * Store a eleves.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        $eleve = new Eleves();
        $eleve->Nom = $request->Nom;
        $eleve->Prenom = $request->Prenom;
        $eleve->save();
        $resul = Eleves::all();
        $resul = Eleves::all();
        return response()->json($resul, 200);
    }


    /**
     * Store a elevelist.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(Request $request){
            $eleve = new Eleves();
            $eleve->Nom = $request->Nom;
            $eleve->Prenom = $request->Prenom;
            $eleve->save();
            $resul = Eleves::all();
            return response()->json($resul, 200);
    }

    /**
     * Update a eleve.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                       $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse{

        $eleve = Eleves::findOrFail($id);
        $eleve->Nom = $request->Nom;
        $eleve->Prenom = $request->Prenom;
        // if (!$eleve->isValidFor('CREATE')) {
        //     throw new ValidationException($eleve->validator());
        // }
        $changes = $eleve->getDirty();
        $eleve->save();
        $resul = Eleves::all();
       // return fractal($eleve, new eleveTransformer())->toArray();
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
    public function deleteeleveById(int $id): JsonResponse
    {
        $eleve = Eleves::findOrFail($id);
        $eleve->delete();
        $resul = Eleves::all();
        return response()->json($resul,200 ) ;
    }
   
   
   
    //   /**
    //  * Controller constructor.
    //  *
    //  * @param  \App\Accounts  $accounts
    //  */
    // public function __construct(Accounts $accounts)
    // {
    //     $this->accounts = $accounts;
    // }

    // /**
    //  * Get all the eleved.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function index(Request $request): JsonResponse
    // {

    //     $eleves = $this->accounts->geteleves($request);

    //     return response()->json($eleves, 200);
    // }

    // /**
    //  * Store a eleve.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function store(Request $request): JsonResponse
    // {
    //     $eleve = $this->accounts->storeUser($request->all());

    //     return response()->json($eleve, Response::HTTP_CREATED);
    // }

    // /**
    //  * Get a eleve.
    //  *
    //  * @param  int  $id
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function show(int $id): JsonResponse
    // {
    //     $eleve = $this->accounts->geteleveById($id);

    //     return response()->json($eleve, 200);
    // }

    // /**
    //  * Update a eleve.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int                       $id
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function update(Request $request, int $id): JsonResponse
    // {
    //     $eleve = $this->accounts->updateeleveById($id, $request->all());

    //     return response()->json($eleve, 200);
    // }

    // /**
    //  * Delete a eleve.
    //  *
    //  * @param  int  $id
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function destroy(int $id): JsonResponse
    // {
    //     $this->accounts->deleteeleveById($id);

    //     return response()->json(null, Response::HTTP_NO_CONTENT);
    // }
}
