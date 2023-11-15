<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transition extends Model
{
    use HasFactory;
    protected $table = 'transition';
    protected $fillable = ['parent_id', 'name', 'user_id'];
    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i:s',
        'updated_at' => 'datetime:d/m/Y H:i:s'
    ];

    public function childs()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')->with('childs');
    }

    public function parent()
    {
        return $this->hasOne(self::class, 'id', 'parent_id');
    }

    public function income(){
        return $this->hasMany(Income::class,'transition_id','id');
    }
}
