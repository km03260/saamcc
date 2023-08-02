<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{

    public function __construct(public Model $model = new Client())
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('access', $this->model::class);

        $vdata = $this->vdata();
        $client = null;
        if (Auth::user()->Profil == 8) {
            $client = Auth::user()->clients()->first();
        }

        return view('components.client.index', compact('vdata', 'client'));
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
        if ($request->has('varticles')) {
            return  $this->model::Grid($request->all())->paginate(25);
        }
        return $this->_dataTable($request, $this->model);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vdata = $this->vdata();

        return response()->json([
            "template" => view('components.client.create', compact('vdata'))->render(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        $_prm =  $this->model::Create($request->only($this->model->fillable));

        return response()->json([
            "ok" => "$_prm->raison_sociale est bien enregistré",
            "_new" => ".clients.datatable",
        ], 200);
    }

    /**
     * Display the specified resource.
     * 
     * @param Client $client
     * @return \Illuminate\Http\JsonResponse|mixed|string
     */
    public function show(Request $request, Client $client)
    {
        $this->authorize('access', $this->model::class);
        $vdata = $this->vdata();
        if ($request->has('tab')) {
            $tab = $request->tab;
            return view("components.client.tabs.$tab", compact('client', 'vdata'))->render();
        }
        $tabs = [
            ["name" => 'general', "title" => 'Infos générales', 'color' => "aliceblue"],
            ["name" => 'articles', "title" => 'Articles', 'color' => "cornflowerblue"],
            ["name" => 'stocks', "title" => 'Stock', 'color' => "springgreen"],
            ["name" => 'commandes', "title" => 'Commandes', 'color' => "#ffff0a"],
            ["name" => 'users', "title" => 'Utilisateurs', 'color' => "darkgray"],
        ];
        return response()->json(['child' => view('components.client.show', compact('client', 'vdata', 'tabs'))->render()], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        $client->update($request->only($this->model->fillable));

        return response()->json([
            "ok" => "Information du client ($client->raison_sociale) est mis à jour",
            "_row" => $this->model::Grid(["id" => $client->id])->first(),
            "list" => "clients",
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return response()->json([
            "ok" => "La fiche de client ($client->raison_sociale) est supprimée",
            "_drow" => "#tr_clients_$client->id",
        ], 200);
    }
}
