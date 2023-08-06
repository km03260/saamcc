<?php

namespace App\Models;

use Carbon\Carbon;
use DateTime;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

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
            ->select(DB::raw("
             $this->table.*,
             CASE WHEN $this->table.statut_id NOT IN (1,2) THEN $this->table.date_livraison_confirmee ELSE '' END AS date_livraison_confirmee,
             UNIX_TIMESTAMP($this->table.date_livraison_souhaitee) AS dateSteUF,
             DATE_FORMAT($this->table.date_livraison_souhaitee, '%V/%Y') AS weekSte
             "))
            ->with(['statut', 'user', 'client'])
            ->when(key_exists('client_id', $cond), function ($q) use ($cond) {
                $q->where('client_id', $cond['client_id']);
            })
            ->when(key_exists('week', $cond), function ($q) use ($cond) {
                $_date = new DateTime('midnight');
                $_date->setISODate(Str::after($cond['week'], '/'), Str::before($cond['week'], '/'));
                $q->whereBetween('date_livraison_souhaitee', [$_date->modify('-1 days')->format('Y-m-d'), $_date->modify('+5 days')->format('Y-m-d')]);
            })
            ->when(key_exists('article_id', $cond), function ($q) use ($cond) {
                $q->whereHas('articles', function ($qha) use ($cond) {
                    $qha->where('cc_commande_articles.article_id', $cond['article_id']);
                });
            })
            ->when(key_exists('statut_id', $cond), function ($q) use ($cond) {
                $q->where('statut_id', $cond['statut_id']);
            })
            ->when(key_exists('statuts', $cond), function ($q) use ($cond) {
                $q->whereIn('statut_id', $cond['statuts']);
            })
            ->when(key_exists('id', $cond), function ($q) use ($cond) {
                $q->where('id', $cond['id']);
            })
            ->when(Auth::user()->Profil == 8, function ($q) {
                $q->where('client_id', Auth::user()->clients()->first()->id);
            });;
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
                "name" => "Client",
                "data" => "client.raison_sociale",
                'column' => 'client_id',
                "render" => 'relation',
                'visible' => key_exists('wclient', $cond),
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
                "name" => "Statut",
                "data" => "statut.designation",
                'column' => 'statut_id',
                "render" => "relation",
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
                "data" => "statut_suivi",
                'column' => "/handle/render?com=update-statut-column&model=commande&D=D&width=50",
                "render" => 'url',
                "className" => 'center aligned open p-0',
                "visible" => Gate::allows('create', [self::class]) && key_exists('suivi', $cond),
                'width' => "55px"
            ],
            // [
            //     "name" => "",
            //     "data" => "default",
            //     'column' => "/handle/render?com=default&model=commande&D=D&width=50",
            //     "render" => 'url',
            //     "className" => 'center aligned open p-0',
            //     "visible" => Gate::allows('create', [self::class]),
            //     'width' => "55px"
            // ],
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

            if ($_mdl->isDirty('statut_id') && $_mdl->statut_id == 3 && !$_mdl->date_livraison_confirmee) {
                $_mdl->date_livraison_confirmee = Carbon::parse($_mdl->date_livraison_souhaitee)->format('d/m/Y');
            }
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
