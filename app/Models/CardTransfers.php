<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardTransfers extends Model
{
    use HasFactory;
    protected $table = 'card_transfers';
    protected $fillable = ['user_id', 'card_no', 'to_card_no', 'record', 'amount', 'exchange'];
    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i:s',
        'updated_at' => 'datetime:d/m/Y H:i:s'
    ];

    public function getAMountFormatAttribute($exchange)
    {
       
        $exchange = match ($exchange) {
            1 => 'Rub',
            2 => 'USD',
            3 => 'EUR',
            4 => 'AZN',
            default => 'Rub'
        };
        return number_format($this->amount, 2) . $exchange;
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
}
