<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ShippingRate extends Model
{
    protected $fillable = ['shipping_zone_id', 'name', 'type', 'cost', 'min_order_value', 'is_active'];
    protected $casts = ['cost' => 'decimal:2', 'min_order_value' => 'decimal:2'];
    public function zone() { return $this->belongsTo(ShippingZone::class, 'shipping_zone_id'); }
}
