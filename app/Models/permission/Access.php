<?php

namespace App\Models\permission;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Access extends Model
{
    use HasFactory;

    /**
     * Table name
     *
     * @var string
     */
    public $table = "sso_access_rights";
}
