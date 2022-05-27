<?php

namespace App\Http\Controllers\API;

use App\CustomerDiscountedAmount;
use App\Http\Controllers\Controller;
use App\TenantFood;
use App\Ticket;
use App\TomsCustomerOrders;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function tenant_orders(Request $request)
    {

        $date = Carbon::parse($request->date)->toDateTimeString();

        if ($request->store == 'all') {
            $tenant = TenantFood::join('locate_business_units', 'locate_business_units.bunit_code', 'locate_tenants.bunit_code')
                ->where('locate_tenants.active', true)
                ->get();
        } else {
            $tenant = TenantFood::join('locate_business_units', 'locate_business_units.bunit_code', 'locate_tenants.bunit_code')
                ->where(['locate_tenants.bunit_code' => $request->store, 'locate_tenants.active' => true])
                ->get();
        }
        $results = array();
        foreach ($tenant as $value) {
            $orders = TomsCustomerOrders::with('product_uom', 'suggestions', 'product_flavor', 'product_choice', 'product_addon')
                ->join('fd_products', 'fd_products.product_id', 'toms_customer_orders.product_id')
                ->join('locate_tenants', 'locate_tenants.tenant_id', 'fd_products.tenant_id')
                ->join('locate_business_units', 'locate_business_units.bunit_code', 'locate_tenants.bunit_code')
                ->select('toms_customer_orders.quantity
                as  prod_qty', 'locate_tenants.logo as tenant_logo', 'toms_customer_orders.*', 'fd_products.*', 'locate_tenants.*', 'locate_business_units.*')
                ->where(['fd_products.tenant_id' => $value['tenant_id'], 'canceled_status' => false])
                ->whereDate('pickup_at', $date)
                ->get();
            $total_amt = 0;
            $order_list = array();
            foreach ($orders->groupBy('ticket_id') as $tkey => $tvalue) {
                $ticket = Ticket::with('gc_delivery_info')->join('toms_customer_details', 'toms_customer_details.id', 'tickets.customer_id')->where('tickets.id', $tkey)->selectRaw('tickets.*, toms_customer_details.firstname, toms_customer_details.lastname')->first();
                $disc_amt = CustomerDiscountedAmount::where(['ticket_id' => $tkey, 'tenant_id' => $value['tenant_id']])->get();
                $order_list[$ticket->ticket] = ['items' => $tvalue, 'tdata' => $ticket, 'discount' => $disc_amt->sum('discount')];
                $total_amt += $tvalue->sum('total_price');
            }
            $results[] = ['tenant_data' => $value, 'orders' => $order_list, 'total_amt' =>  number_format($total_amt, 2)];
        }
        return $results;
    }
}
