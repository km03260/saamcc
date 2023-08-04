<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommandeRequest;
use App\Models\Commande;
use App\Models\Scommande;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SuiviCommandeController extends Controller
{
    /**
     * Create new instance of SuiviCommandeController
     * @param Model $model
     */
    public function __construct(public Model $model = new Commande())
    {
    }

    /**
     * Display  resources
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed|string
     */
    public function index(Request $request)
    {
        $this->authorize('access', [App\Models\User::class]);

        $vdata = $this->vdata();
        if ($request->has('tab')) {
            $tab = $request->tab;
            return view("components.commande.suivi.tabs.$tab", compact('vdata'))->render();
        }

        $tabs = [];
        foreach (Scommande::whereNotIn('id', [1])->get() as $st) {
            $tabs[] = [
                "name" => $st->id,
                "title" => $st->designation,
                "color" => $st->color,
            ];
        }
        return  view('components.commande.suivi.index', compact('vdata', 'tabs'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return mixed
     */
    public function grid(Request $request)
    {
        $this->authorize('access', [App\Models\User::class]);

        if ($request->has('header')) {
            return  $this->GET_HEADER($request, $this->model::gridColumns($request->has('selection')));
        }
        return $this->_dataTable($request, $this->model);
    }


    /**
     * Update the specified resource in storage.
     * 
     * @param StoreCommandeRequest $request
     * @param Commande $commande
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreCommandeRequest $request, Commande $commande)
    {
    }


    /**
     * Display the specified resource.
     */
    public function show(Commande $commande)
    {
    }
}
