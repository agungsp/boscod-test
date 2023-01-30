<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetailState extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $appends = ['state_text'];

    public function stateText(): Attribute
    {
        return new Attribute(
            get: function ($value) {
                return match ($this->state_code) {
                    1 => "Pending",
                    2 => "Processing",
                    3 => "Cancel",
                    4 => "Success",
                    5 => "Error"
                };
            }
        );
    }
}
