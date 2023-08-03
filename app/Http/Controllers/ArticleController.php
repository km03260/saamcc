<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ArticleController extends Controller
{

    public function __construct(public Model $model = new Article())
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vdata = $this->vdata();

        return view('components.article.index', compact('vdata'));
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
        return response()->json([
            "template" => view('components.article.create', compact('vdata', 'client_id'))->render(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        $this->authorize('create', $this->model::class);

        $_prm =  $this->model::Create($request->only($this->model->fillable));

        return response()->json([
            "ok" => "$_prm->ref est bien enregistré",
            "_new" => ".articles.datatable",
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function savewhat(StoreArticleRequest $request, Article $article)
    {
        $this->authorize('update', [$this->model::class, $article]);

        $article->update($request->only($this->model->fillable));

        return response()->json([
            "ok" => "L'article ($article->ref) est mis à jour",
            "_row" => $this->model::Grid(["id" => $article->id])->first(),
            "list" => "articles",
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $this->authorize('delete', [$this->model::class, $article]);

        $article->delete();

        $e_resp = [
            "ok" => "l'article $article->ref est supprimée",
            "_drow" => "#tr_articles_$article->id",
        ];

        return response()->json($e_resp, 200);
    }
}
