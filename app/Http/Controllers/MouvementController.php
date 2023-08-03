<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMouvementRequest;
use App\Http\Requests\UpdateMouvementRequest;
use App\Models\Article;
use App\Models\Mouvement;
use App\Models\Stock;
use App\Models\Zone;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class MouvementController extends Controller
{

    public function __construct(public Model $model = new Mouvement())
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
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
        $this->authorize('access', $this->model::class);

        if ($request->has('header')) {
            return  $this->GET_HEADER($request, $this->model::gridColumns($request->all()));
        }
        return $this->_dataTable($request, $this->model);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, string $dir, Article $article, Zone $zone)
    {
        $this->authorize('create', $this->model::class);

        $vdata = $this->vdata();

        $zones = Zone::orderBy('order')->get();

        return response()->json([
            "template" => view('components.mouvement.create', compact('vdata', 'dir', 'article', 'zone', 'zones'))->render(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMouvementRequest $request, string $dir, Article $article, Zone $zone)
    {
        $this->authorize('update', Stock::class);
        $_stock = Stock::firstOrCreate(['article_id' => $article->id, 'zone_id' => $zone->id]);
        $qte = (int)$request->qte;
        $perte = (int)$request->perte;

        switch ($dir) {
            case '1':
                $_e_stock = Stock::firstOrCreate(['article_id' => $article->id, 'zone_id' => $zone->id + 1]);
                $_stock->decrement('qte', $qte + $perte);
                $_e_stock->increment('qte', $qte);
                $this->model::create([
                    "stock_id" => $_stock->id,
                    "sen_id" => 2,
                    "zone_id" => $zone->id,
                    "qte" => $qte,
                    "perte" => $perte
                ]);
                $this->model::create([
                    "stock_id" => $_e_stock->id,
                    "sen_id" => 1,
                    "zone_id" => $zone->id + 1,
                    "qte" => $qte
                ]);
                break;
            case '2':
                $_e_stock = Stock::firstOrCreate(['article_id' => $article->id, 'zone_id' => $zone->id - 1]);
                $_stock->decrement('qte', $qte + $perte);
                $_e_stock->increment('qte', $qte);
                $this->model::create([
                    "stock_id" => $_stock->id,
                    "sen_id" => 2,
                    "zone_id" => $zone->id,
                    "qte" => $qte,
                    "perte" => $perte
                ]);
                $this->model::create([
                    "stock_id" => $_e_stock->id,
                    "sen_id" => 1,
                    "zone_id" => $zone->id - 1,
                    "qte" => $qte
                ]);
                break;

            default:
                $_stock->increment('qte', $qte);
                $this->model::create([
                    "stock_id" => $_stock->id,
                    "sen_id" => 3,
                    "zone_id" => $zone->id,
                    "qte" => $qte
                ]);
                break;
        }

        return response()->json([
            "ok" => "Stock est mis à jour",
            "_row" => Stock::Grid(['article_id' => $article->id])->first(),
            "list" => "stocks",
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Mouvement $mouvement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mouvement $mouvement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMouvementRequest $request, Mouvement $mouvement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mouvement $mouvement)
    {
        //
    }
}
