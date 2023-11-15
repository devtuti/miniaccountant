<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmountSpent extends Model
{
    use HasFactory;
    protected $table = 'amount_spent';
    protected $fillable = ['expenses_id', 'user_id', 'amount', 'exchange', 'comment'];
    protected $appends = ['total'];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i:s',
        'updated_at' => 'datetime:d/m/Y H:i:s'
    ];

    public function expenses()
    {
        return $this->hasOne(Expenses::class,'id','expenses_id');
    }

    public function getAMountFormatAttribute($exchange)
    {
        //return number_format($this->amount, 2) . 'AZN';
        $exchange = match ($exchange) {
            1 => 'Rub',
            2 => 'USD',
            3 => 'EUR',
            4 => 'AZN',
            default => 'Rub'
        };

        return number_format($this->amount, 2) . ' '.$exchange;
    }

    public function getExchangeFormatAttribute($exchange)
    {
        $exchange = match ($exchange) {
            1 => 'Rub',
            2 => 'USD',
            3 => 'EUR',
            4 => 'AZN',
            default => 'Rub'
        };

        return $exchange;
    }

    public function getTotalAttribute($query)
    {
        return number_format($query->where('user_id', auth()->user()->id)->sum($this->amount), 2) . 'AZN';
    }
}
