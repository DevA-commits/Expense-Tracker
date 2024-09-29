<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'payment_name'];

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
