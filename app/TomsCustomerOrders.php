<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TomsCustomerOrders extends Model
{
    protected $table = 'toms_customer_orders';

    public function product_uom()
    {
        return $this->belongsTo('App\UOM', 'uom_id', 'id');
    }
    public function product_flavor()
    {
        return $this->belongsTo('App\CustomerOrderFlavor', 'id', 'order_id')->join('fd_flavors', 'fd_flavors.id', 'toms_customer_order_flavors.flavor_id');
    }
    public function product_choice()
    {
        return $this->hasMany('App\CustomerOrderChoices', 'order_id', 'id')
            ->join('fd_products', 'fd_products.product_id', 'toms_customer_order_choices.choice_id')
            ->leftJoin('fd_uoms', 'fd_uoms.id', 'toms_customer_order_choices.uom_id');
    }
    public function product_addon()
    {
        return $this->hasMany('App\CustomerOrderAddons', 'order_id', 'id')
            ->join('fd_products', 'fd_products.product_id', 'toms_customer_order_addons.addon_id')
            ->leftJoin('fd_uoms', 'fd_uoms.id', 'toms_customer_order_addons.uom_id');
    }
    public function suggestions()
    {
        return $this->hasMany('App\CustomerOrderSuggestion', 'order_id', 'id')
            ->join('fd_product_suggestions', 'fd_product_suggestions.id', 'toms_customer_order_suggestions.product_suggestion_id')
            ->join('fd_suggestions', 'fd_suggestions.id', 'toms_customer_order_suggestions.suggestion_id');
    }
}
