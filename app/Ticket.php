<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public function finalOrdersCancel()
    {
        return $this->hasMany(GCFinalOrder::class, 'ticket_id', 'id');
    }
    public function finalOrdersCancelItem()
    {
        return $this->hasMany(GCFinalOrder::class, 'ticket_id', 'id')->where('canceled_status', 1);
    }
    public function finalOrders()
    {
        return $this->hasMany(GCFinalOrder::class, 'ticket_id', 'id')->selectRaw('gc_final_order.*, 
        gc_product_items.product_name, 
        gc_product_items.itemcode, 
        gc_product_uoms.UOM')
            ->where('bu_id', auth()->user()->bunit_code)
            ->join('gc_product_items', 'gc_product_items.product_id', 'gc_final_order.product_id')
            ->join('gc_product_uoms', 'gc_product_uoms.uom_id', 'gc_final_order.uom_id');
    }
    public function finalOrderStatusStore()
    {
        return $this->hasMany(GCFinalOrderStatus::class, 'ticket_id', 'id');
    }
    public function finalOrderStatus()
    {
        return $this->hasMany(GCFinalOrderStatus::class, 'ticket_id', 'id')->where('bu_id', auth()->user()->bunit_code);
    }

    public function discount()
    {
        return $this->hasMany(CustomerDiscount::class, 'ticket_id', 'id');
    }

    public function discountStatus()
    {
        return $this->hasMany(CustomerDiscountStatus::class, 'ticket_id', 'id');
    }

    public function discountAmount()
    {
        return $this->hasMany(GcDiscountedAmount::class, 'ticket_id', 'id');
    }

    public function customerBill()
    {
        return $this->hasMany(CustomerBill::class, 'ticket_id', 'id');
    }

    public function CashierMonitoring()
    {
        return $this->hasMany(GcCashierMonitoring::class, 'ticket_id', 'id')->join('gc_users', 'gc_users.id', '=', 'gc_cashier_monitoring.cashier_id');
    }

    public function GcTransaction()
    {
        return $this->hasMany(GcTransaction::class, 'ticket_id', 'ticket')
            ->SelectRaw('
            gc_transactions.ticket_id,
            gc_transactions.receipt,
            gc_package_barcode.type,
            gc_package_barcode.status
        ')
            ->join('gc_package_barcode', 'gc_package_barcode.receipt', '=', 'gc_transactions.receipt');
    }

    public function packageDetails()
    {
        return $this->hasMany(GcPackageDetails::class, 'ticket_id', 'ticket')->join('gc_barcode_type', 'gc_barcode_type.id', 'gc_package_details.barcodetype_id');
    }
    public function gc_delivery_info()
    {
        return $this->hasOne('App\CustomerDeliveryInfos', 'ticket_id', 'id')
            ->join('barangays', 'barangays.brgy_id', 'customer_delivery_infos.barangay_id')
            ->join('towns', 'towns.town_id', 'barangays.town_id')
            ->join('province', 'province.prov_id', 'towns.prov_id');;
    }
    public function customer_orders()
    {
        return $this->hasMany('App\TomsCustomerOrders', 'ticket_id', 'id')->join('fd_products', 'fd_products.product_id', 'toms_customer_orders.product_id')->join('locate_tenants', 'locate_tenants.tenant_id', 'fd_products.tenant_id')->where(['toms_customer_orders.canceled_status' => false]);
    }

    protected $table = 'tickets';
}
