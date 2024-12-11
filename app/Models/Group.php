<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Group extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($group) {
            $group->uuid = (string) Str::orderedUuid();
        });
    }

    public function groupusers()
    {
        return $this->hasMany(GroupUser::class);
    }
}
