<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\permission\Action;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UserController extends Controller
{


    public function __construct(public Model $model = new User())
    {
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return mixed
     */
    public function grid(Request $request)
    {
        $this->authorize('access', $this->model::class);

        if ($request->has('header')) {
            return  $this->GET_HEADER($request, $this->model::gridColumns($request->all()));
        }
        return $this->_dataTable($request, $this->model);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vdata = $this->vdata();

        return view('components.user.index', compact('vdata'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $this->authorize('create', $this->model::class);

        $vdata = $this->vdata();

        $client_id = $request->get('client_id');

        return response()->json([
            "template" => view('components.user.create', compact('vdata', 'client_id'))->render(),
        ], 200);
    }

    /**
     * Show the form for update password .
     */
    public function reset(Request $request, User $user)
    {
        $this->authorize('delete', [$this->model::class, $user]);

        $vdata = $this->vdata();

        return response()->json([
            "template" => view('components.user.reset', compact('vdata', 'user'))->render(),
        ], 200);
    }

    /**
     * Update  password .
     * 
     * @param ResetPasswordRequest $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $request, User $user)
    {
        $this->authorize('delete', [$this->model::class, $user]);

        $user->update(["Mdp" => $request->password]);

        return response()->json([
            "ok" => "Mot de passe réinitialisé avec succès.",
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', $this->model::class);

        $_data = $request->only($this->model->fillable);

        if ($request->has('client_id')) {
            $_data['Profil'] = 8;
        }
        $_prm =  $this->model::Create($_data);
        if ($request->has('client_id')) {
            $_prm->clients()->attach($request->client_id);
        }

        /**
         * Authorize new user to Access
         */
        $_action = Action::where('code', '3_view')->value('id');

        $_profile_id = Profile::whereCode($_prm->Profil)->value('id');

        $_prm->actions()->syncWithoutDetaching([$_action]);

        $_prm->actions()->updateExistingPivot($_action, ['module_id' => 3, 'profile_id' => $_profile_id]);

        return response()->json([
            "ok" => "L'utilisateur $_prm->Prenom est bien enregistré",
            "_new" => ".users.datatable",
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(UserController $userController)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserController $userController)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserController $userController)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', [$this->model::class, $user]);
        $client = $user->clients()->first()?->id;
        if ($client) {
            $user->clients()->detach($client);
        }
        $user->delete();

        $e_resp = [
            "ok" => "l'utilisateur $user->Prenom est supprimée",
            "_drow" => "#tr_users_$user->id",
        ];

        return response()->json($e_resp, 200);
    }
}
