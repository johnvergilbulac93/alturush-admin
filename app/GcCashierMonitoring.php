<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GcCashierMonitoring extends Model
{

    protected $table = 'gc_cashier_monitoring';

    public function finalOrderStatus()
    {
        return $this->hasMany(GCFinalOrderStatus::class, 'ticket_id', 'ticket_id');
    }

    public function finalOrders()
    {
        return $this->hasMany(GCFinalOrder::class, 'ticket_id', 'ticket_id')->selectRaw('gc_final_order.*, 
        gc_product_items.product_name, 
        gc_product_items.itemcode, 
        gc_product_uoms.UOM')
            ->join('gc_product_items', 'gc_product_items.product_id', 'gc_final_order.product_id')
            ->join('gc_product_uoms', 'gc_product_uoms.uom_id', 'gc_final_order.uom_id');
    }
    public function discountAmount()
    {
        return $this->hasMany(GcDiscountedAmount::class, 'ticket_id', 'ticket_id');
    }

    public function customerBill()
    {
        return $this->hasMany(CustomerBill::class, 'ticket_id', 'ticket_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'id', 'ticket_id')->selectRaw('CONCAT(customer_delivery_infos.firstname ," " ,customer_delivery_infos.lastname) AS customer,
            tickets.*,
            receipt,
            gc_transactions.status
            ')
            ->join('customer_delivery_infos', 'customer_delivery_infos.ticket_id', '=', 'tickets.id')
            ->JOIN('gc_transactions', 'gc_transactions.ticket_id', '=', 'ticket');
    }
}
