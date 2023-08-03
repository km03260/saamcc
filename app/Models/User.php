<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'sso_user';


    /**
     * Scope grid
     * @param Builder $query
     * @param array $cond
     * @return Builder
     */
    public function scopeGrid(Builder $query, array $cond = [])
    {
        $cond = array_filter($cond);

        return $query
            ->with(['profile'])
            ->when(key_exists('id', $cond), function ($q) use ($cond) {
                $q->where('id', $cond['id']);
            })
            ->when(key_exists('Profil', $cond), function ($q) use ($cond) {
                $q->where('Profil', $cond['Profil']);
            })
            ->when(key_exists('Nom', $cond), function ($q) use ($cond) {
                $q->where('Nom', 'LIKE', "%{$cond['Nom']}%");
            })
            ->when(key_exists('Prenom', $cond), function ($q) use ($cond) {
                $q->where('Prenom', 'LIKE', "%{$cond['Prenom']}%");
            })
            ->when(key_exists('Email', $cond), function ($q) use ($cond) {
                $q->where('Email', 'LIKE', "%{$cond['Email']}%");
            })
            ->when(key_exists('client_id', $cond), function ($q) use ($cond) {
                $q->whereHas('clients', function ($qhc) use ($cond) {
                    $qhc->where('cc_client_users.client_id', $cond['client_id']);
                });
            })
            ->when(Auth::user()->Profil == 9, function ($q) use ($cond) {
                $q->whereIn('Profil', [8]);
            })
            ->when(Auth::user()->Profil == 8, function ($q) use ($cond) {
                $q->whereIn('Profil', [8]);
            });
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Nom',
        'Prenom',
        'Login',
        'Email',
        'Tel',
        'Mdp',
        'Profil',
        'usersso',
        'password',
    ];

    const CREATED_AT = 'CreeLe';
    const UPDATED_AT = 'ModifieLe';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'usersso',
        'Mdp',
    ];

    /**
     * Appends atrbuttes
     *
     * @var array
     */
    protected $append = [
        'client',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'Mdp' => 'hashed',
    ];


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
                "name" => "Prenom",
                "data" => "Prenom",
                'column' => 'Prenom',
                "render" => false,
                "className" => 'left aligned',
            ],
            [
                "name" => "Nom",
                "data" => "Nom",
                'column' => 'Nom',
                "render" => false,
                "className" => 'left aligned',
            ],
            [
                "name" => "Email",
                "data" => "Email",
                'column' => 'Email',
                "render" => false,
                "className" => 'left aligned',
            ],
            [
                "name" => "Téléphone",
                "data" => "Tel",
                'column' => 'Tel',
                "render" => false,
                "className" => 'left aligned',
            ],
            [
                "name" => "Profile",
                "data" => "profile.designation",
                'column' => 'Profil',
                "render" => 'relation',
                'visible' => key_exists('wprofil', $cond),
                "className" => 'left aligned',
            ],
            [
                "name" => "",
                "data" => "default",
                'column' => "/handle/render?com=default&model=user&D=D&width=50",
                "render" => 'url',
                "className" => 'center aligned open p-0',
                "visible" => Gate::allows('create', [self::class]),
                'width' => "55px"
            ],
        ];
    }

    /**
     * The clients that belong to the user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function clients()
    {
        return $this->belongsToMany(Client::class, 'cc_client_users');
    }

    /**
     * Get related profile
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class, 'Profil', 'code');
    }


    /**
     * Get the user's related client.
     */
    public function client(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->clients()->first()?->id,
        );
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($_mdl) {
            $_mdl->CreePar = Auth::id();
            $_mdl->usersso = md5('profil' . $_mdl->Profil . '2020') . '-' . md5($_mdl->Email);
        });
        static::updating(function ($_mdl) {
            $_mdl->ModifiePar = Auth::id();
        });
    }
}
