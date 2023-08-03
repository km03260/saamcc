<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Profile extends Model
{
    use HasFactory;

    /**
     * Table name
     * @var string
     */
    protected $table = 'sso_profiles';


    /**
     * Search scope
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
            ->select(DB::raw("designation as name, code as value, designation as text ,
                              CASE WHEN code = '$selected' THEN true ELSE false END AS selected
                    "))
            ->when(key_exists('code', $cond), function ($q) use ($cond) {
                $q->where("code", $cond['code']);
            })
            ->when($search, function ($q) use ($search) {
                $q->where(function ($w) use ($search) {
                    $w->where('designation', 'LIKE', "%$search%");
                });
            })
            ->when(Auth::user()->Profil == 9, function ($q) {
                $q->whereIn('code', [8]);
            })
            ->when(Auth::user()->Profil == 8, function ($q) {
                $q->whereIn('code', [8]);
            })
            ->limit(100);
    }
}
