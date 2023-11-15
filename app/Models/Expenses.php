<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    use HasFactory;
    protected $table = 'expenses';
    protected $fillable = ['parent_id', 'name', 'user_id'];
    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i:s',
        'updated_at' => 'datetime:d/m/Y H:i:s'
    ];

    public function childs(){
        return $this->hasMany(self::class, 'parent_id', 'id')->with('childs');
    }

    public function parent()
    {
        return $this->hasOne(self::class, 'id', 'parent_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'user_id', 'id');
    }

    public function payment(){
        
        return $this->hasMany(AmountSpent::class,'expenses_id','id');
    
    }
}
