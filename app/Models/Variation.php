<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class Variation extends Model
{
    use HasFactory;


    /**
     * Table name
     * @var string
     */
    protected $table = "cc_variations";


    /**
     * Scope grid
     * @param Builder $query
     * @param array $cond
     * @return Builder
     */
    public function scopeGrid(Builder $query, array $cond = [])
    {
        $cond = array_filter($cond);

        return $query->with(['client'])
            ->select(DB::raw("$this->table.*"))
            ->when(key_exists('client_id', $cond), function ($q) use ($cond) {
                $q->where('client_id', $cond['client_id']);
            })
            ->when(key_exists('label', $cond), function ($q) use ($cond) {
                $q->where('label', 'LIKE', "{$cond['label']}%");
            })
            ->when(key_exists('id', $cond), function ($q) use ($cond) {
                $q->where('id', $cond['id']);
            })
            ->when(Auth::user()->Profil == 8, function ($q) {
                $q->where('client_id', Auth::user()->clients()->first()->id);
            });
    }


    /**
     * Column's grid
     *
     * @param mixed $cond
     * @return array
     */
    public static function gridColumns($cond = []): array
    {
        return [
            [
                "name" => "Id",
                "data" => "id",
                'column' => "id",
                "render" => false,
                "className" => 'left aligned',
                "width" => "75px",
            ],
            [
                "name" => "libellé",
                "data" => "label",
                'column' => 'label',
                "render" => false,
                "edit" => 'data-field="label" data-model="/variation/update" data-type="text"',
                "className" => 'left aligned open_child open ' . (Gate::allows('update', [self::class]) ? 'editFieldLine' : ''),
            ],
            [
                "name" => "Value",
                "data" => "value",
                'column' => 'value',
                "render" => false,
                "className" => 'left aligned ',
            ],
            // [
            //     "name" => "Client",
            //     "data" => "client.raison_sociale",
            //     'column' => 'prospect_id',
            //     "render" => 'relation',
            //     'visible' => key_exists('wclient', $cond) && !Gate::allows('is_client', User::class),
            //     "className" => 'right aligned',
            // ],
            [
                "name" => "",
                "data" => "default",
                'column' => "/handle/render?com=default&model=variation&D=D&width=50",
                "render" => 'url',
                "className" => 'center aligned open p-0',
                "visible" => Gate::allows('delete', [self::class]),
                'width' => "55px"
            ],
        ];
    }

    /**
     * Get related client
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * Get the user's first name.
     */
    public function label(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value),
            set: fn ($value) => strtolower($value)
        );
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        "client_id",
        "label",
        "value",
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($_mdl) {
            $_mdl->created_by = Auth::id();
        });
        static::updating(function ($_mdl) {
            $_mdl->updated_by = Auth::id();
        });
    }
}
