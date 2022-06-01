<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function defaultHome()
    {
        return Page::where('is_default_home', true);
    }

    public static function default404()
    {
        return Page::where('is_default_404', true);
    }

    protected function content(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Str::limit($value, 50, '...')
        );
    }
}
