<?php

namespace App\Http\Controllers;

use App\Helpers\Loader;
use App\Http\Requests\StoreCommandeRequest;
use App\Models\Commande;
use App\Models\Scommande;
use Carbon\Carbon;
use Illuminate\Support\Str;
use DateTime;
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

    public function planification(Request $request)
    {

        $vdata = $this->vdata();

        if ($request->ajax()) {

            $_commandes = $this->model::Grid(array_merge($request->all(), ['planif' => true]));

            $weeks = array_filter(collect($_commandes->get()->toArray())->unique('weekSte')->sortBy('dateSteUF')->pluck('weekSte')->toArray());

            $_min_c = count($weeks) > 0 ? reset($weeks) :  Carbon::now()->subWeeks(3)->format('W/Y');

            $_date = new DateTime('midnight');

            $_date->setISODate(Str::after($_min_c, '/'), Str::before($_min_c, '/'))->modify('-1 days');

            $_cdate = Carbon::now()->subWeeks(3);

            $_cdate_diff = $_cdate;

            $_diff = $_cdate_diff->diff($_date)->invert;

            $_start = $_diff < 1 ? $_cdate->format('W/Y') : $_min_c;

            $_weeks = array_filter(array_merge([$_start], $weeks));

            $weeks = Loader::parseWeeks($_weeks, $_start, end($weeks));

            $clients = array_unique($_commandes->distinct('client_id')->pluck('client_id')->toArray());

            return response()->json([
                "ok" => "Successfully load cmds",
                "sections" => view("components.commande.planif.includes.weeks", compact('weeks',  'clients'))->render(),
            ], 200);
        }

        $statuts = Scommande::whereNotIn('id', [1])->get();
        return  view('components.commande.planif.index', compact('vdata', 'statuts'));
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
    public function week(Request $request)
    {
        try {

            $data_request = array_merge($request->all(), ['planif' => true]);

            $__week = str_replace('/', '_', $request->week);

            $commandes = $this->model::Grid($data_request);

            return response()->json([
                "ok" => "Les commande de la semaine $request->week ont été téléchargés avec succès",
                "content" => [
                    $__week => view('components.commande.planif.includes.week', compact('commandes'))->with($data_request)->render(),
                ],
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => "Erreur lors de charger les commande de la semaine $request->week",
                "content" => [
                    $__week => view('components.commande.planif.includes.error-load-week')->with($data_request)->render(),
                ],
            ], 200);
        }
    }

    /**
     * Mouvement commande
     * @param Request $request
     * @param Commande $commande
     * @return \Illuminate\Http\JsonResponse
     */
    public function mouvement(Request $request, Commande $commande)
    {
        $this->authorize('update', [$this->model::class, $commande]);
        $_date = new DateTime('midnight');
        $_date->setISODate(Str::after($request->new_week, '/'), Str::before($request->new_week, '/'));

        $commande->update([
            'date_livraison_confirmee' => $_date->format('d/m/Y'),
        ]);

        return response()->json([
            "ok" => "Commande updated successfuly",
            "weeks" => [$request->week, $request->new_week],
        ], 200);
    }
}
