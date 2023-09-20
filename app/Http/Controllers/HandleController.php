<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HandleController extends Controller
{

    /**
     * render the actions resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render(Request $request)
    {
        try {
            $kdata = Str::random(8);
            $_model = null;
            if ($request->has('model')) {
                $model_name = "App\Models\\" . Str::ucfirst($request->model);
                if (class_exists($model_name)) {
                    $_model = $model_name::find($request->key) ?? null;
                }
            }
            return response()->json([
                'render' => view("components.render.actions.$request->com", compact('kdata', '_model'))
                    ->with($request->all())->render(),
            ], 200);
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    /**
     * Search in storage.
     *
     * @param Request $request
     * @param string $target
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request, String $target)
    {
        $namespace_model = "\\App\\Models\\" . Str::studly($target);
        if (class_exists($namespace_model)) {
            $_model = new $namespace_model();
            $result = ["success" => true, "results" => $_model::Search($request->search, $request->selected, $request->all())->toBase()->get()->unique("value")];
        } else {
            $search = Str::lower($request->search ?? '');
            $items = array_map(function ($item) use ($search) {
                if (str_contains(Str::lower($item['name']), $search) || $search == "tous") {
                    return $item;
                }
            }, $this->items($target, $request->selected, $request->has('options') ? explode(',', $request->options) : []));

            $result = ["success" => true, "results" => array_filter($items)];
        }
        return response()->json($result, 200);
    }

    /**
     * Get search items
     *
     * @param  string  $target
     * @return \array
     */
    private function items(string $target, $selected = '', $options = []): array
    {
        $result = [];
        switch ($target) {
            case 'fonctions':
                $result =
                    [
                        ["name" => "Direction", "text" => "Direction", "value" => "Direction", 'selected' => $selected == "Direction"],
                        ["name" => "Achat", "text" => "Achat", "value" => "Achat", 'selected' => $selected == "Achat"],
                        ["name" => "BE", "text" => "BE", "value" => "BE", 'selected' => $selected == "BE"],
                        ["name" => "Appro", "text" => "Appro", "value" => "Appro", 'selected' => $selected == "Appro"],
                        ["name" => "Divers", "text" => "Divers", "value" => "Divers", 'selected' => $selected == "Divers"],
                    ];
                break;
            case 'origins':
                foreach (['Salon', 'Exposant', 'Bouche à Oreille', 'saam.fr', 'Visite', 'emailing'] as $origin) {
                    $result[] = ["name" => $origin, "text" => $origin, "value" => $origin, 'selected' => $selected == $origin];
                }
                break;
            case 'statuts':
                foreach (['en cours', 'envoyée', 'gagnée', 'perdue', 'annulée', 'Autre Statut'] as $origin) {
                    $selected = $selected;
                    $result[] = ["name" => Str::ucfirst($origin), "text" => Str::ucfirst($origin), "value" => $origin, 'selected' => $selected == $origin];
                }
                break;
            case 'statuts_resultat':
                foreach (['gagnée', 'perdue'] as $origin) {
                    $selected = $selected;
                    $result[] = ["name" => Str::ucfirst($origin), "text" => Str::ucfirst($origin), "value" => $origin, 'selected' => $selected == $origin];
                }
                break;
            case 'client_type':
                foreach (['prospect', 'client', 'prescripteur'] as $origin) {
                    $result[] = ["name" => Str::ucfirst($origin), "text" => Str::ucfirst($origin), "value" => $origin, 'selected' => $selected == $origin];
                }
                break;
            case 'devis_statuts':
                foreach (['En cours', 'Envoyé au client', 'Validé'] as $origin) {
                    $selected = $selected != '' ? $selected : 'En cours';
                    $result[] = ["name" => Str::ucfirst($origin), "text" => Str::ucfirst($origin), "value" => $origin, 'selected' => $selected == $origin];
                }
                break;
            case 'type_field':
                foreach ([
                    'options',
                    'text',
                    'nombre',
                    'décimale',
                    'texte',
                    'checkbox'
                ] as $bloc) {
                    $selected = $selected;
                    $result[] = ["name" => Str::ucfirst($bloc), "text" => Str::ucfirst($bloc), "value" => $bloc, 'selected' => $selected == $bloc];
                }
                break;
            case 'empty':
                foreach ([] as $bloc) {
                    $selected = $selected;
                    $result[] = ["name" => Str::ucfirst($bloc), "text" => Str::ucfirst($bloc), "value" => $bloc, 'selected' => $selected == $bloc];
                }
                break;

            default:
                $selected = explode(',', $selected);
                foreach ($options as $bloc) {
                    $result[] = ["name" => Str::ucfirst($bloc), "text" => Str::ucfirst($bloc), "value" => $bloc, 'selected' => in_array($bloc, $selected)];
                }

                break;
        }
        return $result;
    }
}
