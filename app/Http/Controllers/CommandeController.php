<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommandeRequest;
use App\Http\Requests\UpdateCommandeRequest;
use App\Models\Article;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Lcommande;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
        $client_id = Gate::allows('is_client', [App\Models\User::class]) ? Auth::user()->client  : ($request->get('client_id') ?? null);
        $client = $client_id ? Client::find($client_id) : null;
        return response()->json([
            "template" => view('components.commande.create', compact('vdata', 'client', 'client_id'))->render(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommandeRequest $request)
    {
        $this->authorize('create', $this->model::class);
        try {
            $request->request->add(['statut_id' => 1]);

            $_prm =  $this->model::Create($request->only($this->model->fillable));

            foreach ($request->articles ?? [] as $key => $ligne) {
                $_article = Article::Grid(['id' => $ligne['id']])->first();

                if ($ligne['id'] && $_article) {
                    foreach ($ligne['variation'] as $t_var => $c_var) {
                        foreach ($c_var as $bvar => $qty) {
                            if ($qty > 0) {
                                Lcommande::updateOrCreate([
                                    'commande_id' => $_prm->id,
                                    'article_id' => $ligne['id'],
                                    'variation' => $t_var != 0 ? ("$t_var" . ($bvar != 0 ? "/" . $bvar : '')) : null,
                                ], [
                                    'qty' => $qty,
                                    'pu' =>  $_article->puht,
                                ]);
                            }
                        }
                    }
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
            ["name" => 'cgeneral', "title" => "Commande N°$commande->id", 'color' => "aliceblue"],
            // ["name" => 'lignes', "title" => 'Articles', 'color' => "cornflowerblue"],
        ];
        return response()->json(['child' => view('components.commande.show', compact('commande', 'vdata', 'tabs'))->render()], 200);
    }

    /**
     * Display the specified resource.
     */
    public function fields(Client $client)
    {
        $this->authorize('create', $this->model::class);

        $vdata = $this->vdata();
        // $client_id = Gate::allows('is_client', [App\Models\User::class]) ? Auth::user()->client  :  $client->id;
        return view('components.commande.fields', compact('vdata', 'client'))->render();
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

        if ($request->has('date_livraison_confirmee')) {
            $this->authorize('liv_confirme', [$this->model::class, $commande]);
        }

        $_data = $request->only($this->model->fillable);

        if ($request->has('ids') && $request->ids) {
            $_dl_conf = trim($request->ids, ',');
            $this->authorize('liv_confirme', [$this->model::class, $commande]);
            $_data['date_livraison_confirmee'] = $_dl_conf && $_dl_conf != '' ? $_dl_conf : null;
        }

        $commande->update($_data);

        $_resp = [
            "list" => "commandes",
        ];
        if (!$request->has('noClicked')) {
            $_resp['_clicked'] = ".commandes.datatable .cgeneral.item.active";
        }
        if ($request->has('planif')) {
            $_prm =  $this->model::Grid(['id' => $commande->id])->first();
            $week = $request->has('week') ? $request->week : $_prm->weekSte;
            $_resp['close'] = true;
            $_resp['_target'] = "#ui-cardplanif_" . str_replace('/', '_', $week) . "_" . $commande->id;
            $_resp['_replace'] = view('components.commande.planif.includes.card')
                ->with([
                    'week' => $week,
                    'sem' => $week,
                    "statut" =>  $_prm->statut_id,
                    "commande" => $_prm
                ])->render();
            if ($week != $_prm->weekSte) {
                $_resp["weeks"] = [$week, $_prm->weekSte];
            }
        } else  if ($request->has('statut_id') && $request->has('suivi')) {
            $_resp['ok'] =  "la commande mise à jour avec succès";
            $_resp['_drow'] = "#tr_commandes_$commande->id";
        } else {
            $_resp['ok'] =  "la commande mise à jour avec succès";
            $_resp['_row'] = $this->model::Grid(['id' => $commande->id])->first();
        }

        return response()->json($_resp, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commande $commande)
    {
        $this->authorize('delete', [$this->model::class, $commande]);

        $commande->delete();

        $e_resp = [
            "ok" => "la commande N° ($commande->id) est supprimée",
            "_drow" => "#tr_commandes_$commande->id",
        ];

        return response()->json($e_resp, 200);
    }
}
