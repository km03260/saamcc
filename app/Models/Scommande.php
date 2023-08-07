<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class Scommande extends Model
{
    use HasFactory;

    /**
     * Table name
     * @var string
     */
    protected $table = "cc_commande_statuts";

    /**
     * Grid Search scope
     *
     * @param Builder $query
     * @param string|null $search
     * @param string|null $selected
     * @param array $cond
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeSearch(Builder $query, String $search = null, String $selected = null, array $cond = [])
    {
        return $query
            ->select(DB::raw("designation as name, id as value, designation as text ,
                              CASE WHEN id = '$selected' THEN true ELSE false END AS selected
                    "))
            ->when(key_exists('id', $cond), function ($q) use ($cond) {
                $q->where("id", $cond['id']);
            })
            ->when(Gate::allows('is_operateur', [User::class]), function ($q) {
                $q->whereIn('id', [4, 5]);
            })
            ->when($search, function ($q) use ($search) {
                $q->where(function ($w) use ($search) {
                    $w->where('designation', 'LIKE', "%$search%");
                });
            })
            ->limit(100);
    }
}
