<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLcommandeRequest;
use App\Http\Requests\UpdateLcommandeRequest;
use App\Models\Article;
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
        $this->authorize('create', Commande::class);

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
        $client = $request->client;
        $ids = $request->has('ids') ? $request->get('ids') : '';
        $notIn = $request->has('notIn') ? $request->get('notIn') : '';

        return response()->json([
            '_target' => $request->target,
            "_append_row" => view('components.commande.ligne.row', compact('vdata', 'client', 'ids', 'notIn'))->render()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLcommandeRequest $request)
    {
        $this->authorize('create', Commande::class);

        foreach ($request->articles ?? [] as $key => $ligne) {

            $_article = Article::Grid(['id', $ligne['id']])->first();

            if ($ligne['id'] && $_article && $ligne['qty'] > 0) {
                $this->model::updateOrCreate([
                    'commande_id' => $request->commande_id,
                    'article_id' => $ligne['id'],
                ], [
                    'qty' => $ligne['qty'],
                    'pu' =>  $_article->puht,
                ]);
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
    public function update(UpdateLcommandeRequest $request, Lcommande $lcommande)
    {
        //
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
