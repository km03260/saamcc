<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class Commande extends Model
{
    use HasFactory;

    /**
     * Table name
     * @var string
     */
    protected $table = "cc_commandes";

    /**
     * Scope grid
     * 
     * @param Builder $query
     * @param array $cond
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeGrid(Builder $query, array $cond = [])
    {
        $cond = array_filter($cond);
        return $query
            ->select(DB::raw("$this->table.*"))
            ->with(['statut', 'user', 'client'])
            ->when(key_exists('client_id', $cond), function ($q) use ($cond) {
                $q->where('client_id', $cond['client_id']);
            })
            ->when(key_exists('statut_id', $cond), function ($q) use ($cond) {
                $q->where('statut_id', $cond['statut_id']);
            })
            ->when(key_exists('id', $cond), function ($q) use ($cond) {
                $q->where('id', $cond['id']);
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
                "name" => "N°",
                "data" => "id",
                'column' => "id",
                "render" => false,
                "className" => 'left aligned open_child',
                "width" => "75px",
            ],
            [
                "name" => "Statut",
                "data" => "statut.designation",
                'column' => 'statut_id',
                "render" => "relation",
                "className" => 'left aligned open_child',
            ],
            [
                "name" => "Date de livraison souhaitée",
                "data" => "date_livraison_souhaitee",
                'column' => 'date_livraison_souhaitee',
                "render" => false,
                "className" => 'left aligned open_child',
            ],
            [
                "name" => "Date de livraison confirmée",
                "data" => "date_livraison_confirmee",
                'column' => 'date_livraison_confirmee',
                "render" => false,
                "className" => 'left aligned open_child',
            ],
            [
                "name" => "Client",
                "data" => "client.raison_sociale",
                'column' => 'client_id',
                "render" => 'relation',
                'visible' => key_exists('wclient', $cond),
                "className" => 'left aligned open_child',
            ],
            [
                "name" => "Créé Par",
                "data" => "user.Prenom",
                'column' => 'created_by',
                "render" => 'relation',
                "className" => 'left aligned open_child',
            ],
            [
                "name" => "Créé Le",
                "data" => "created_at",
                'column' => 'created_at',
                "render" => false,
                "className" => 'left aligned open_child',
            ],
            [
                "name" => "",
                "data" => "default",
                'column' => "/handle/render?com=default&model=commande&D=D&width=50",
                "render" => 'url',
                "className" => 'center aligned open p-0',
                "visible" => Gate::allows('create', [self::class]),
                'width' => "55px"
            ],
        ];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'client_id',
        'statut_id',
        'date_livraison_souhaitee',
        'date_livraison_confirmee',
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
        static::deleting(function ($_mdl) {
            $_mdl->articles->each->delete();
        });
    }

    /**
     * Get commande articles
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany(Lcommande::class);
    }

    /**
     * get commande statut
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function statut()
    {
        return $this->belongsTo(Scommande::class, 'statut_id');
    }

    /**
     * get created _user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * get client
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * Get created at atributte
     */
    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) =>  Carbon::parse($value)->format('d/m/Y'),
        );
    }

    /**
     * Set the user's dateLivraisonSouhaitee
     */
    public function dateLivraisonSouhaitee(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value ? Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d') : null,
        );
    }

    /**
     * set the user's dateLivraisonConfirmee
     */
    public function dateLivraisonConfirmee(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value ? Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d') : null,
        );
    }
}
