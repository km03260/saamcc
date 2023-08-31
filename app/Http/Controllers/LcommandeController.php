<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLcommandeRequest;
use App\Http\Requests\UpdateLcommandeRequest;
use App\Models\Article;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Lcommande;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class LcommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(public Model $model = new Lcommande())
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return mixed
     */
    public function grid(Request $request)
    {
        $this->authorize('access', Commande::class);

        if ($request->has('header')) {
            return  $this->GET_HEADER($request, $this->model::gridColumns($request->all()));
        }
        return $this->_dataTable($request, $this->model);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, Commande $commande)
    {
        $this->authorize('create', [$this->model::class, $commande]);

        $vdata = $this->vdata();

        return response()->json([
            "template" => view('components.commande.ligne.create', compact('vdata', 'commande'))->render(),
        ], 200);
    }

    /**
     * Show the row form for creating a new resource.
     */
    public function row(Request $request)
    {
        $vdata = $this->vdata();
        $client = Client::find($request->client);
        $ids = $request->has('ids') ? $request->get('ids') : '';
        $notIn = $request->has('notIn') ? $request->get('notIn') : '';

        $_with = [];
        if ($request->has('wdelete')) {
            $_with['wdelete'] =  true;
        }

        return response()->json([
            '_target' => $request->target,
            "_append_row" => view('components.commande.ligne.row', compact('vdata', 'client', 'ids', 'notIn'))->with($_with)->render()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLcommandeRequest $request)
    {
        $commande = Commande::find($request->commande_id);

        $this->authorize('create', [$this->model::class, $commande]);

        foreach ($request->articles ?? [] as $key => $ligne) {

            $_article = Article::Grid(['id' => $ligne['id']])->first();
            if ($ligne['id'] && $_article) {
                foreach ($ligne['variation'] as $t_var => $c_var) {
                    foreach ($c_var as $bvar => $qty) {
                        if ($qty > 0) {
                            $_lign_cmd = Lcommande::where([
                                'commande_id' => $commande->id,
                                'article_id' => $ligne['id'],
                                'variation' => $t_var != 0 ? ("$t_var" . ($bvar != 0 ? "/" . $bvar : '')) : null,
                            ])->first();
                            if ($_lign_cmd) {
                                $_lign_cmd->update([
                                    'qty' => $qty + $_lign_cmd->qty,
                                    'pu' =>  $_article->puht,
                                ]);
                            } else {
                                Lcommande::create([
                                    'commande_id' => $commande->id,
                                    'article_id' => $ligne['id'],
                                    'variation' => $t_var != 0 ? ("$t_var" . ($bvar != 0 ? "/" . $bvar : '')) : null,
                                    'qty' => $qty,
                                    'pu' =>  $_article->puht,
                                ]);
                            }
                        }
                    }
                }
            }
        }

        return response()->json([
            "ok" => "Commande  est mis à jour",
            "_new" => ".lcommandes.datatable",
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lcommande $lcommande)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lcommande $lcommande)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreLcommandeRequest $request, Lcommande $lcommande)
    {
        $this->authorize('update', [$this->model::class, $lcommande]);

        $lcommande->update($request->only($this->model->fillable));

        return response()->json([
            "ok" => "L'article ($lcommande->article->ref) est mis à jour",
            "_row" => $this->model::Grid(["id" => $lcommande->id])->first(),
            "_row_p" => Commande::Grid(["id" => $lcommande->commande_id])->first(),
            "list" => "lcommandes",
            "list_p" => "commandes",
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lcommande $lcommande)
    {
        $this->authorize('create', Commande::class);

        $lcommande->delete();

        $e_resp = [
            "ok" => "la ligne est supprimée",
            "_drow" => "#tr_lcommandes_$lcommande->id",
        ];

        return response()->json($e_resp, 200);
    }
}
