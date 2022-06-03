<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    use HasFactory;

    protected $fillable = ['role', 'route_name'];

    public static function roles()
    {
        return ['admin', 'user'];
    }

    public static function routes()
    {
        return ['dashboard', 'pages', 'navigation-menus', 'users', 'user-permissions'];
    }
}
