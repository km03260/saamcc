<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVariationRequest;
use App\Http\Requests\UpdateVariationRequest;
use App\Models\Variation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class VariationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(public Model $model = new Variation())
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $this->authorize('create', $this->model::class);

        $vdata = $this->vdata();
        if ($request->has('type')) {
            return view('components.variation.includes.field-type', compact('vdata'))->with($request->all())->render();
        }
        $client_id = $request->get('client_id') ?? null;
        return response()->json([
            "template" => view('components.variation.create', compact('vdata', 'client_id'))->render(),
        ], 200);
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
     * Store a newly created resource in storage.
     */
    public function store(StoreVariationRequest $request)
    {
        $this->authorize('create', $this->model::class);

        $_prm =  $this->model::Create($request->only($this->model->fillable));

        return response()->json([
            "ok" => "La variation de ($_prm->label) est bien enregistrée",
            "_new" => ".variations.datatable",
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Variation $variation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Variation $variation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreVariationRequest $request, Variation $variation)
    {
        $this->authorize('update', [$this->model::class]);

        $variation->update($request->only($this->model->fillable));

        return response()->json([
            "ok" => "La variation ($variation->ref) est mis à jour",
            "_row" => $this->model::Grid(["id" => $variation->id])->first(),
            "list" => "variations",
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Variation $variation)
    {
        $this->authorize('delete', [$this->model::class]);

        $variation->delete();

        $e_resp = [
            "ok" => "La variation de ($variation->label) est supprimée",
            "_drow" => "#tr_variations_$variation->id",
        ];

        return response()->json($e_resp, 200);
    }
}
