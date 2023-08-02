<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommandeRequest;
use App\Http\Requests\UpdateCommandeRequest;
use App\Models\Article;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Lcommande;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function __construct(public Model $model = new Commande())
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vdata = $this->vdata();

        return view('components.commande.index', compact('vdata'));
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
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $this->authorize('create', $this->model::class);

        $vdata = $this->vdata();
        $client_id = $request->get('client_id') ?? null;
        return response()->json([
            "template" => view('components.commande.create', compact('vdata', 'client_id'))->render(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommandeRequest $request)
    {
        $this->authorize('create', $this->model::class);
        try {
            $_prm =  $this->model::Create($request->only($this->model->fillable));

            foreach ($request->articles ?? [] as $key => $ligne) {

                $_article = Article::Grid(['id', $ligne['id']])->first();

                if ($ligne['id'] && $_article && $ligne['qty'] > 0) {
                    Lcommande::create([
                        'commande_id' => $_prm->id,
                        'article_id' => $ligne['id'],
                        'qty' => $ligne['qty'],
                        'pu' =>  $_article->puht,
                    ]);
                }
            }

            return response()->json([
                "ok" => "Commande $_prm->id est bien enregistré",
                "_new" => ".commandes.datatable",
            ], 200);
        } catch (\Throwable $th) {
            if ($_prm) {
                $_prm->delete();
            }
            return response()->json([
                "error" => "Error lors de enregister la commande",
                "message" => $th
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Commande $commande)
    {
        $this->authorize('access', $this->model::class);
        $vdata = $this->vdata();
        if ($request->has('tab')) {
            $tab = $request->tab;
            return view("components.commande.tabs.$tab", compact('commande', 'vdata'))->render();
        }
        $tabs = [
            ["name" => 'cgeneral', "title" => 'Infos générales', 'color' => "aliceblue"],
            ["name" => 'lignes', "title" => 'Articles', 'color' => "cornflowerblue"],
        ];
        return response()->json(['child' => view('components.commande.show', compact('commande', 'vdata', 'tabs'))->render()], 200);
    }

    /**
     * Display the specified resource.
     */
    public function fields(Client $client)
    {
        $vdata = $this->vdata();
        $client_id = $client->id;
        return view('components.commande.fields', compact('vdata', 'client_id'))->render();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commande $commande)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCommandeRequest $request, Commande $commande)
    {
        $this->authorize('update', [$this->model::class, $commande]);

        $_data = $request->only($this->model->fillable);

        $commande->update($_data);

        $_resp = [
            "ok" => "la commande mise à jour avec succès",
            "list" => "commandes",
        ];

        if ($request->has('statut_id') && $request->has('suivi')) {
            $_resp['_drow'] = "#tr_commandes_$commande->id";
        } else {
            $_resp['_row'] = $this->model::Grid(['id' => $commande->id])->first();
        }

        return response()->json($_resp, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commande $commande)
    {
        $this->authorize('create', $this->model::class);

        $commande->delete();

        $e_resp = [
            "ok" => "la commande N° ($commande->id) est supprimée",
            "_drow" => "#tr_commandes_$commande->id",
        ];

        return response()->json($e_resp, 200);
    }
}
