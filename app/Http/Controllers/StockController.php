<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStockRequest;
use App\Http\Requests\UpdateStockRequest;
use App\Models\Article;
use App\Models\Mouvement;
use App\Models\Stock;
use App\Models\Zone;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class StockController extends Controller
{

    public function __construct(public Model $model = new Stock())
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('access', $this->model::class);

        $vdata = $this->vdata();

        return view('components.stock.index', compact('vdata'));
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
    public function create(Request $request)
    {
        $this->authorize('create', $this->model::class);

        $vdata = $this->vdata();
        $client_id = $request->get('client_id') ?? null;
        $zones = Zone::orderBy('order')->get();

        return response()->json([
            "template" => view('components.stock.create', compact('vdata', 'client_id', 'zones'))->render(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStockRequest $request)
    {
        $this->authorize('create', $this->model::class);

        foreach ($request->zones as $zone => $qty) {
            if ($qty) {
                $this->model::updateOrCreate(['article_id' => $request->article_id, "zone_id" => $zone], ["qte" => $qty]);
            }
        }

        return response()->json([
            "ok" => "Stock est bien modifié",
            "_new" => ".stocks.datatable",
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $vdata = $this->vdata();
        return response()->json(['child' => view('components.stock.show', compact('article', 'vdata'))->render()], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStockRequest $request, Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function sens(Request $request, Int $dir, Article $article, Zone $zone)
    {
        $this->authorize('update', $this->model::class);
        if ($dir == 3) {
            $this->authorize('upStock', $this->model::class);
        }
        $_stock = $this->model::firstOrCreate(['article_id' => $article->id, 'zone_id' => $zone->id]);
        $_old_qty = $_stock->qte;
        $_stock->update(['qte' => $request->qty]);

        Mouvement::create([
            "stock_id" => $_stock->id,
            "sen_id" => $dir,
            "zone_id" => $zone->id,
            "qte" => $request->qty - $_old_qty
        ]);

        return response()->json([
            "ok" => "Stock est mis à jour",
            "_row" => $this->model::Grid(['article_id' => $article->id])->first(),
            "list" => "stocks",
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        //
    }
}
