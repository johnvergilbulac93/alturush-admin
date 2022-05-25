<?php

namespace App\Http\Controllers\API;

use DateTime;
use App\Ticket;
use Carbon\Carbon;
use App\TenantFood;
use App\GCFinalOrder;
use App\TomsTagRider;
use App\gc_bunit_code;
use App\GCUnfoundItem;
use App\DeliveryTimeSetup;
use App\TomsCustomerOrders;
use App\GcCashierMonitoring;
use Illuminate\Http\Request;
use App\CustomerDiscountedAmount;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function get_item_report_store(Request $request)
    {
        $this->validate($request, [
            'type'      => 'required',
        ]);

        $filter = $request->type;
        $buId = Auth::user()->bunit_code;
        $getBU = DB::table('locate_business_units')->where('bunit_code', $buId)->first();

        if ($filter === 'all') {

            $filename = $getBU->acroname . '-ALL-ITEMS-' . Carbon::now()->format('Y-m-d-hms') . '.xls';

            $query =   DB::table('gc_product_items')
                ->join('gc_product_prices', 'gc_product_items.itemcode', '=', 'gc_product_prices.itemcode')
                ->select('gc_product_items.itemcode', 'gc_product_items.product_name', 'gc_product_items.category_name', 'gc_product_items.category_no', 'gc_product_prices.UOM', 'gc_product_prices.price_with_vat')
                ->where('gc_product_items.status', 'active')
                ->get();

            $result['items'] = $query;
            $result['filename'] = $filename;
            return $result;
        }

        if ($filter === 'available') {

            $filename = $getBU->acroname . '-AVAILABLE-ITEMS-' . Carbon::now()->format('Y-m-d-hms') . '.xls';

            $query =   DB::table('gc_product_items')
                ->join('gc_product_prices', 'gc_product_items.itemcode', '=', 'gc_product_prices.itemcode')
                ->select('gc_product_items.itemcode', 'gc_product_items.product_name', 'gc_product_items.category_name', 'gc_product_items.category_no', 'gc_product_prices.UOM', 'gc_product_prices.price_with_vat')
                ->where('gc_product_items.status', 'active')
                ->whereNotIn('gc_product_items.itemcode', function ($query) {
                    $query->select('gc_item_log_availables.itemcode')->from('gc_item_log_availables')->where('gc_item_log_availables.store', '=', Auth::user()->bunit_code);
                })->get();
            $result['items'] = $query;
            $result['filename'] = $filename;
            return $result;
        }

        if ($filter === 'unavailable') {

            $filename = $getBU->acroname . '-UNAVAILABLE-ITEMS-' . Carbon::now()->format('Y-m-d-hms') . '.xls';

            $query =   DB::table('gc_product_items')
                ->join('gc_product_prices', 'gc_product_items.itemcode', '=', 'gc_product_prices.itemcode')
                ->select('gc_product_items.itemcode', 'gc_product_items.product_name', 'gc_product_items.category_name', 'gc_product_items.category_no', 'gc_product_prices.UOM', 'gc_product_prices.price_with_vat')
                ->whereIn('gc_product_items.itemcode', function ($query) {
                    $query->select('gc_item_log_availables.itemcode')->from('gc_item_log_availables')->where('gc_item_log_availables.store', '=', Auth::user()->bunit_code);
                })->get();
            $result['items'] = $query;
            $result['filename'] = $filename;
            return $result;
        }
    }

    public function get_liquidation(Request $request)
    {
        $this->validate($request, [
            'store' => ['required']
        ], [
            'store.required' => 'Please select a store.'
        ]);

        $buId = $request->store;
        $dateFrom = Carbon::parse($request->startDate)->toDateString();
        $dateTo = Carbon::parse($request->endDate)->toDateTimeString();
        $getBU = DB::table('locate_business_units')->where('bunit_code', $buId)->first();

        $query = GcCashierMonitoring::with(['finalOrderStatus', 'finalOrders', 'discountAmount', 'customerBill', 'tickets'])
            ->join('locate_business_units', 'locate_business_units.bunit_code', '=', 'gc_cashier_monitoring.bu_id')
            ->join('gc_users', 'gc_users.id', '=', 'gc_cashier_monitoring.cashier_id')
            ->join('gc_order_statuses', 'gc_order_statuses.ticket_id', '=', 'gc_cashier_monitoring.ticket_id')
            ->where('gc_order_statuses.paid_status', true)
            ->where('gc_order_statuses.bu_id', '=', $buId)
            // ->whereBetween('gc_order_statuses.order_pickup', [$dateFrom, $dateTo])
            ->whereDate('gc_order_statuses.order_pickup', '>=', $dateFrom)
            ->whereDate('gc_order_statuses.order_pickup', '<=', $dateTo)
            ->orderBy('gc_order_statuses.order_pickup')
            ->get();
        // ->groupBy('bunit_code');

        $result['b_unit'] = $getBU;
        $result['cashier_details'] = $query;
        return $result;
    }

    public function get_accountability(Request $request)
    {
        $buId = $request->store;
        $dateFrom = Carbon::parse($request->startDate)->toDateString();
        $dateTo = Carbon::parse($request->endDate)->toDateTimeString();
        $getBU = DB::table('locate_business_units')->where('bunit_code', $buId)->first();

        $data = Ticket::with(['finalOrders', 'finalOrderStatus', 'discountAmount', 'customerBill', 'CashierMonitoring'])
            ->selectRaw('CONCAT(customer_delivery_infos.firstname ," " ,customer_delivery_infos.lastname) AS customer,
            tickets.*,
            receipt,
            gc_transactions.status,
            gc_order_statuses.order_pickup,
            gc_order_statuses.bu_id,
            locate_business_units.acroname,
            locate_business_units.business_unit,
            locate_business_units.logo
        ')
            ->join('customer_delivery_infos', 'customer_delivery_infos.ticket_id', '=', 'tickets.id')
            ->JOIN('gc_transactions', 'gc_transactions.ticket_id', '=', 'ticket')
            ->JOIN('gc_order_statuses', 'gc_order_statuses.ticket_id', '=', 'tickets.id')
            ->JOIN('locate_business_units', 'locate_business_units.bunit_code', '=', 'gc_order_statuses.bu_id')
            ->where('gc_order_statuses.paid_status', true)
            ->where('gc_order_statuses.bu_id', '=', $buId)
            ->whereDate('gc_order_statuses.order_pickup', '>=', $dateFrom)
            ->whereDate('gc_order_statuses.order_pickup', '<=', $dateTo)
            ->get();
        $result['b_unit'] = $getBU;
        $result['data'] = $data;
        return $result;
    }

    public function get_liquidation_store(Request $request)
    {

        $buId = Auth::user()->bunit_code;
        $dateFrom = Carbon::parse($request->startDate)->toDateString();
        $dateTo = Carbon::parse($request->endDate)->toDateTimeString();
        $getBU = DB::table('locate_business_units')->where('bunit_code', $buId)->first();

        $cashier = GcCashierMonitoring::with(['finalOrderStatus', 'finalOrders', 'discountAmount', 'customerBill', 'tickets'])
            ->join('locate_business_units', 'locate_business_units.bunit_code', '=', 'gc_cashier_monitoring.bu_id')
            ->join('gc_users', 'gc_users.id', '=', 'gc_cashier_monitoring.cashier_id')
            ->join('gc_order_statuses', 'gc_order_statuses.ticket_id', '=', 'gc_cashier_monitoring.ticket_id')
            ->where('gc_order_statuses.paid_status', true)
            ->where('gc_order_statuses.bu_id', '=', $buId)
            // ->whereBetween('gc_order_statuses.order_pickup', [$dateFrom, $dateTo])
            ->whereDate('gc_order_statuses.order_pickup', '>=', $dateFrom)
            ->whereDate('gc_order_statuses.order_pickup', '<=', $dateTo)
            ->orderBy('gc_order_statuses.order_pickup')
            ->get()
            ->groupBy('cashier_id');

        $result['b_unit'] = $getBU;
        $result['cashier_details'] = $cashier;
        return $result;
    }

    public function get_accountability_store(Request $request)
    {
        $buId = Auth::user()->bunit_code;
        $dateFrom = Carbon::parse($request->startDate)->toDateString();
        $dateTo = Carbon::parse($request->endDate)->toDateTimeString();
        $getBU = DB::table('locate_business_units')->where('bunit_code', $buId)->first();

        $data = Ticket::with(['finalOrders', 'finalOrderStatus', 'discountAmount', 'customerBill', 'CashierMonitoring'])
            ->selectRaw('CONCAT(customer_delivery_infos.firstname ," " ,customer_delivery_infos.lastname) AS customer,
            emp_no,
            name as picker_name,
            tickets.*,
                receipt,
                gc_transactions.status
            ')
            ->join('customer_delivery_infos', 'customer_delivery_infos.ticket_id', '=', 'tickets.id')
            ->JOIN('barangays', 'barangays.brgy_id', '=', 'customer_delivery_infos.barangay_id')
            ->JOIN('towns', 'towns.town_id', '=', 'barangays.town_id')
            ->JOIN('province', 'province.prov_id', '=', 'towns.prov_id')
            ->JOIN('gc_picker_taggings', 'gc_picker_taggings.ticket_id', '=', 'tickets.id')
            ->JOIN('gc_pickers', 'gc_pickers.id', '=', 'gc_picker_taggings.picker_id')
            ->JOIN('gc_order_statuses', 'gc_order_statuses.ticket_id', '=', 'tickets.id')
            ->JOIN('gc_transactions', 'gc_transactions.ticket_id', '=', 'ticket')
            ->where('gc_order_statuses.paid_status', true)
            ->where('gc_order_statuses.bu_id', '=', $buId)
            ->whereDate('gc_order_statuses.order_pickup', '>=', $dateFrom)
            ->whereDate('gc_order_statuses.order_pickup', '<=', $dateTo)
            // ->whereBetween('gc_order_statuses.order_pickup', [$dateFrom, $dateTo])
            ->orderBy('gc_order_statuses.order_pickup')
            ->get();

        // $result['cashier_details'] = auth()->user();
        $result['b_unit'] = $getBU;
        $result['data'] = $data;
        return $result;
    }
    public function get_transactions(Request $request)
    {
        $this->validate($request, [
            'store'        => ['required'],
            'type'         => ['required'],
        ], [
            'store.required' => 'Please choose a store to continue.',
            'type.required'  => 'Please choose a report type to continue.'

        ]);

        $buId = $request->store;
        $dateFrom = Carbon::parse($request->startDate)->toDateString();
        $dateTo = Carbon::parse($request->endDate)->toDateTimeString();
        $getBU = DB::table('locate_business_units')->where('bunit_code', $buId)->first();

        if ($buId === 'all') {
            $data = Ticket::with(['finalOrders', 'finalOrderStatusStore', 'discountAmount', 'customerBill', 'CashierMonitoring'])
                ->selectRaw('CONCAT(customer_delivery_infos.firstname ," " ,customer_delivery_infos.lastname) AS customer,
            tickets.*,
            receipt,
            gc_transactions.status,
            gc_order_statuses.order_pickup,
            gc_order_statuses.bu_id,
            locate_business_units.acroname,
            locate_business_units.business_unit,
            locate_business_units.logo
        ')
                ->join('customer_delivery_infos', 'customer_delivery_infos.ticket_id', '=', 'tickets.id')
                ->JOIN('gc_transactions', 'gc_transactions.ticket_id', '=', 'ticket')
                ->JOIN('gc_order_statuses', 'gc_order_statuses.ticket_id', '=', 'tickets.id')
                ->JOIN('locate_business_units', 'locate_business_units.bunit_code', '=', 'gc_order_statuses.bu_id')
                ->where('gc_order_statuses.paid_status', true)
                ->whereDate('gc_order_statuses.order_pickup', '>=', $dateFrom)
                ->whereDate('gc_order_statuses.order_pickup', '<=', $dateTo)
                ->get();
        } else {

            $data = Ticket::with(['finalOrders', 'finalOrderStatusStore', 'discountAmount', 'customerBill', 'CashierMonitoring'])
                ->selectRaw('CONCAT(customer_delivery_infos.firstname ," " ,customer_delivery_infos.lastname) AS customer,
                tickets.*,
                receipt,
                gc_transactions.status,
                gc_order_statuses.order_pickup,
                gc_order_statuses.bu_id,
                locate_business_units.acroname,
                locate_business_units.business_unit,
                locate_business_units.logo
            ')
                ->join('customer_delivery_infos', 'customer_delivery_infos.ticket_id', '=', 'tickets.id')
                ->JOIN('gc_transactions', 'gc_transactions.ticket_id', '=', 'ticket')
                ->JOIN('gc_order_statuses', 'gc_order_statuses.ticket_id', '=', 'tickets.id')
                ->JOIN('locate_business_units', 'locate_business_units.bunit_code', '=', 'gc_order_statuses.bu_id')
                ->where('gc_order_statuses.paid_status', true)
                ->where('gc_order_statuses.bu_id', '=', $buId)
                ->whereDate('gc_order_statuses.order_pickup', '>=', $dateFrom)
                ->whereDate('gc_order_statuses.order_pickup', '<=', $dateTo)
                ->get();
        }


        if ($buId === 'all') {

            $result['b_unit'] = 'ALL STORE';
            $result['data'] = $data;
            return $result;
        } else {

            $result['b_unit'] = $getBU;
            $result['data'] = $data;
            return $result;
        }
    }
    public function get_instruction(Request $request)
    {
        $this->validate($request, [
            'store' => ['required']
        ], [
            'store.required' => 'Please select a store.'
        ]);

        $getBU = DB::table('locate_business_units')->where('bunit_code', $request->store)->first();
        $query = DB::table('gc_special_instructions')->where('bu_id', $request->store)->orderBy('id', 'DESC')->get();

        $result['b_unit'] = $getBU;
        $result['data'] = $query;

        return $result;
    }
    public function get_unfound(Request $request)
    {
        $this->validate($request, [
            'store' => ['required']
        ], [
            'store.required' => 'Please select a store.'
        ]);

        $buId = $request->store;
        $dateFrom = Carbon::parse($request->start)->toDateString();
        $dateTo = Carbon::parse($request->end)->toDateTimeString();

        $getBU = DB::table('locate_business_units')->where('bunit_code', $buId)->first();
        // $query = DB::table('gc_unfound_items')->where('bu_id', $buId)->orderBy('id','DESC')->get();
        $query = DB::table('gc_unfound_items')
            ->join('gc_order_statuses', 'gc_order_statuses.ticket_id', 'gc_unfound_items.ticket_id')
            ->join('tickets', 'tickets.id', 'gc_unfound_items.ticket_id')
            ->join('order_sources', 'order_sources.id', 'tickets.source_id')
            ->join('customer_delivery_infos', 'customer_delivery_infos.ticket_id', '=', 'gc_unfound_items.ticket_id')
            ->select('*')
            ->selectRaw('CONCAT(customer_delivery_infos.firstname ," " ,customer_delivery_infos.lastname) AS customer')
            ->where('gc_unfound_items.bu_id', $buId)
            ->whereDate('gc_unfound_items.created_at', '>=', $dateFrom)
            ->whereDate('gc_unfound_items.created_at', '<=', $dateTo)
            ->get();

        $result['b_unit'] = $getBU;
        $result['data'] = $query;

        return $result;
    }

    public function getTenantOrders(Request $request)
    {

        $date = Carbon::parse($request->date)->toDateTimeString();

        if ($request->store == 'all') {
            $tenant = TenantFood::join('locate_business_units', 'locate_business_units.bunit_code', 'locate_tenants.bunit_code')->where('locate_tenants.active', true)->get();
        } else {
            $tenant = TenantFood::join('locate_business_units', 'locate_business_units.bunit_code', 'locate_tenants.bunit_code')->where(['locate_tenants.bunit_code' =>  $request->store, 'locate_tenants.active' => true])->get();
        }
        $data_res = array();

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
            $data_res[] = ['tenant_data' => $value, 'orders' => $order_list, 'total_amt' =>  number_format($total_amt, 2)];
        }
        return $data_res;
    }
    public function getTownMostOrders(Request $request)
    {

        $category = $request->category;
        $dateFrom = Carbon::parse($request->dateFrom)->toDateTimeString();
        $dateTo = Carbon::parse($request->dateTo)->toDateTimeString();

        $data_return = array();
        if ($category == 2) {
            $res = Ticket::join('customer_delivery_infos', 'customer_delivery_infos.ticket_id', 'tickets.id')
                ->join('barangays', 'barangays.brgy_id', 'customer_delivery_infos.barangay_id')
                ->join('towns', 'towns.town_id', 'barangays.town_id')
                ->where(['tickets.order_type_stat' => true, 'tickets.cancel_status' => false])
                ->whereDate('tickets.created_at', '>=', $dateFrom)
                ->whereDate('tickets.created_at', '<=', $dateTo)
                ->get()
                ->groupBy('town_name');
            foreach ($res as $key => $value) {
                $data_return[] = ['town' => $key, 'total_order' => $value->count()];
            }
        } else {
            $res = Ticket::with('customer_orders')
                ->join('customer_delivery_infos', 'customer_delivery_infos.ticket_id', 'tickets.id')
                ->join('barangays', 'barangays.brgy_id', 'customer_delivery_infos.barangay_id')
                ->join('towns', 'towns.town_id', 'barangays.town_id')
                ->where(['tickets.order_type_stat' => false, 'tickets.cancel_status' => false])
                ->whereDate('tickets.created_at', '>=', $dateFrom)
                ->whereDate('tickets.created_at', '<=', $dateTo)
                ->get()->groupBy('town_name');

            foreach ($res as $key => $value) {
                $total = 0;
                foreach ($value as $val) {
                    foreach ($val['customer_orders']->groupBy('global_cat_id') as $keyz => $valz) {
                        if ($keyz == $category) {
                            $total += 1 * $valz->groupBy('ticket_id')->count();
                        }
                    }
                }
                if ($total) {
                    $data_return[] = ['town' => $key, 'total_order' => $total];
                }
            }
        }
        return $data_return;
    }
    public function getTenantMostOrders(Request $request)
    {

        $category = $request->category;
        $dateFrom = Carbon::parse($request->dateFrom)->toDateTimeString();
        $dateTo = Carbon::parse($request->dateTo)->toDateTimeString();
        $store = $request->store;

        $data_result = array();
        if ($category == 2) {
            $bdata = array();
            if ($store != "all") {
                $bdata = GCFinalOrder::join('tickets', 'tickets.id', 'gc_final_order.ticket_id')
                    ->join('gc_order_statuses', 'gc_order_statuses.ticket_id',  'gc_final_order.ticket_id')
                    ->join('locate_business_units', 'locate_business_units.bunit_code', 'gc_final_order.bu_id')
                    ->whereDate('gc_order_statuses.prepared_at', '>=', $dateFrom)
                    ->whereDate('gc_order_statuses.prepared_at', '<=', $dateTo)
                    ->where(['gc_final_order.canceled_status' => false, 'gc_final_order.bu_id' => $store])
                    ->get();
            } else {

                $bdata = GCFinalOrder::join('tickets', 'tickets.id', 'gc_final_order.ticket_id')
                    ->join('gc_order_statuses', 'gc_order_statuses.ticket_id',  'gc_final_order.ticket_id')
                    ->join('locate_business_units', 'locate_business_units.bunit_code', 'gc_final_order.bu_id')
                    ->whereDate('gc_order_statuses.prepared_at', '>=', $dateFrom)
                    ->whereDate('gc_order_statuses.prepared_at', '<=', $dateTo)
                    ->where(['gc_final_order.canceled_status' => false])
                    ->get();
            }

            $brules = DB::table('gc_setup_business_rules')->get()->first();
            foreach ($bdata->groupBy('ticket') as $key => $value) {
                $data_result[] = [
                    'ticket' => $key,
                    'store' => $value->first()->business_unit,
                    'total_order' =>  $value->count(),
                    'total_sales' => $value->sum('total_price'),
                    'picking_charge' => $brules->pickup_charge
                ];
            }
        } else {
            $tdata = array();
            if ($store != "all") {
                $tdata =  TenantFood::join('locate_business_units', 'locate_business_units.bunit_code', 'locate_tenants.bunit_code')
                    ->where(['locate_tenants.global_cat_id' => $category, 'locate_tenants.bunit_code' => $store, 'locate_tenants.active' => true])
                    ->select('locate_tenants.*', 'locate_business_units.acroname as bunit_acroname')
                    ->get();
            } else {
                $tdata = TenantFood::join('locate_business_units', 'locate_business_units.bunit_code', 'locate_tenants.bunit_code')
                    ->where(['locate_tenants.global_cat_id' => $category, 'locate_tenants.active' => true])
                    ->select('locate_tenants.*', 'locate_business_units.acroname as bunit_acroname')
                    ->get();
            }
            foreach ($tdata as $value) {
                $item_data = TomsCustomerOrders::join('fd_products', 'fd_products.product_id', 'toms_customer_orders.product_id')
                    ->whereDate('pickup_at', '>=', $dateFrom)
                    ->whereDate('pickup_at', '<=', $dateTo)
                    ->where([
                        'fd_products.tenant_id' => $value['tenant_id'],
                        'canceled_status' => false
                    ])
                    ->get();
                $tickets = array();
                foreach ($item_data->groupBy('ticket_id') as $tkey) {
                    $tickets[] = $tkey;
                }
                $tdisc = CustomerDiscountedAmount::where(['tenant_id' => $value['tenant_id']])->whereIn('ticket_id', $tickets)->get();
                $data_result[] = [
                    'acroname' => $value['bunit_acroname'],
                    'tenant' => $value['tenant'],
                    'total_order' => $item_data->groupBy('ticket_id')->count(),
                    'total_sales' => floatval($item_data->sum('total_price') - $tdisc->sum('discount'))
                ];
            }
        }

        return $data_result;
    }
    public function getSourceMostOrder(Request $request)
    {

        $dateFrom = Carbon::parse($request->dateFrom)->toDateTimeString();
        $dateTo = Carbon::parse($request->dateTo)->toDateTimeString();

        $data_result = array();
        $query =  Ticket::join('order_sources', 'order_sources.id', 'tickets.source_id')
            ->where(['cancel_status' => false])
            ->whereDate('tickets.created_at', '>=', $dateFrom)
            ->whereDate('tickets.created_at', '<=', $dateTo)
            ->get()
            ->groupBy('source');
        foreach ($query as $key => $value) {
            $data_result[] = ['source' => $key, 'count' => $value->count()];
        }
        return $data_result;
    }
    public function getRiderTransaction(Request $request)
    {
        $dateFrom = Carbon::parse($request->dateFrom)->toDateTimeString();
        $dateTo = Carbon::parse($request->dateTo)->toDateTimeString();

        $data_result = array();
        $data_res = TomsTagRider::join('toms_riders_data', 'toms_riders_data.id', 'toms_tag_riders.rider_id')
            ->join('customer_delivery_infos', 'customer_delivery_infos.ticket_id', 'toms_tag_riders.ticket_id')
            ->join('barangays', 'barangays.brgy_id', 'customer_delivery_infos.barangay_id')
            ->join('towns', 'towns.town_id', 'barangays.town_id')
            ->leftJoin('tbl_delivery_charges', function ($join) {
                $join->on('tbl_delivery_charges.brgy_id', 'customer_delivery_infos.barangay_id');
                $join->orOn('tbl_delivery_charges.town_id', 'towns.town_id');
            })
            ->where('remitted_status', 1)
            ->whereBetween('toms_tag_riders.created_at', [$dateFrom, $dateTo])
            // ->limit(20)
            ->get()
            ->groupBy('rider_id');

        foreach ($data_res as $key => $value) {
            $data_result[] = [
                'riders_name' => $value->first()->r_lastname . ", " . $value->first()->r_firstname,
                'trans_num' => $value->count(),
                'fuel' => $value->sum('fuel_amt'),
                'riders_fee' => $value->sum('charge_amt')
            ];
        }
        return $data_result;
    }
    public function getRidersDailyEarning(Request $request)
    {
        $dateFrom = Carbon::parse($request->dateFrom)->toDateTimeString();
        $dateTo = Carbon::parse($request->dateTo)->toDateTimeString();

        $riders = DB::table('toms_tag_riders')
            ->selectRaw('rider_id, CONCAT(r_firstname, " ", r_lastname) as rider_name, town_name as location, rider_share as rates, DATE(remitted_at) as transaction_date')
            ->join('toms_riders_data', 'toms_riders_data.id', 'toms_tag_riders.rider_id')
            ->join('tickets', 'tickets.id', 'toms_tag_riders.ticket_id')
            ->join('customer_delivery_infos', 'customer_delivery_infos.ticket_id', 'toms_tag_riders.ticket_id')
            ->join('barangays', 'barangays.brgy_id', 'customer_delivery_infos.barangay_id')
            ->join('towns', 'towns.town_id', 'barangays.town_id')
            ->join('tbl_delivery_charges', 'tbl_delivery_charges.town_id', 'towns.town_id')
            ->where('delevered_status', 1)
            ->whereBetween('delevered_at', [$dateFrom,  $dateTo])
            ->get();


        $ridersDeliveries = $riders->groupBy([
            'rider_name',
            'transaction_date',
            'location'
        ])->toArray();

        $riderDailyEarnings['tableData'] = [];
        $riderDailyEarnings['summary'] = [];
        $riderDailyEarnings['grandTotal'] = 0;

        foreach ($ridersDeliveries as $rider => $riderDelivery) {

            $dates = [];
            $grandTotalRates = 0;
            $grandTotalTransactions = 0;
            $grandTotalTotal = 0;
            $key = 0;

            ksort($riderDelivery);

            foreach ($riderDelivery as $date => $deliveries) {

                $date = Carbon::parse($date)->format('F d, Y');


                $towns = [];


                foreach ($deliveries as $town => $townDelivery) {
                    $key++;
                    $rates = $townDelivery[0]->rates;
                    $noOfTransactions = count($townDelivery);
                    $total = $rates * $noOfTransactions;

                    $towns[] = compact('town', 'rates', 'noOfTransactions', 'total', 'key');
                }

                $towns = collect($towns)->sortByDesc('noOfTransactions')->values()->toArray();

                $subTotalRates = 0;
                $subTotalNoOfTransactions = 0;
                $subTotal = 0;

                foreach ($towns as $townDelivery) {
                    $subTotalRates += $townDelivery['rates'];
                    $subTotalNoOfTransactions += $townDelivery['noOfTransactions'];
                    $subTotal += $townDelivery['total'];
                }

                $dateSubTotal = compact('subTotalRates', 'subTotalNoOfTransactions', 'subTotal');

                $dates[] = compact('date', 'towns', 'dateSubTotal');

                $grandTotalRates += $subTotalRates;
                $grandTotalTransactions += $subTotalNoOfTransactions;
                $grandTotalTotal += $subTotal;
            }

            $riderDailyEarnings['tableData'][] = compact('rider', 'dates', 'grandTotalRates', 'grandTotalTransactions', 'grandTotalTotal');
            $riderDailyEarnings['summary'][] = compact('rider', 'grandTotalTotal');
            $riderDailyEarnings['grandTotal'] += $grandTotalTotal;
        }

        return $this->orderByHighestEarnings($riderDailyEarnings);
    }
    private function orderByHighestEarnings($riderDailyEarnings)
    {
        $riderDailyEarnings['tableData'] = collect($riderDailyEarnings['tableData'])->sortByDesc('grandTotalTotal')->values()->toArray();
        $riderDailyEarnings['summary'] = collect($riderDailyEarnings['summary'])->sortByDesc('grandTotalTotal')->values()->toArray();

        return $riderDailyEarnings;
    }
    public function getRiderCountPerDay(Request $request)
    {

        $dateFrom = Carbon::parse($request->dateFrom)->toDateTimeString();
        $dateTo = Carbon::parse($request->dateTo)->toDateTimeString();

        $tickets = DB::table('tickets')
            ->selectRaw('date(tickets.created_at) as transaction_date, count(tickets.id) as no_of_transaction')
            ->join('toms_tag_riders', 'toms_tag_riders.ticket_id', 'tickets.id')
            ->where([['tickets.cancel_status', 0], ['toms_tag_riders.remitted_status', 1]])
            ->whereBetween('tickets.created_at', [$dateFrom,  $dateTo])
            ->groupByRaw('date(tickets.created_at)')
            ->get();

        $tickets = $tickets->map(function ($ticket) {
            $formattedDate = Carbon::parse($ticket->transaction_date)->format('F j, Y');
            $noOfRiders = TomsTagRider::whereDate('remitted_at', $ticket->transaction_date)->distinct('rider_id')->count();

            $ticket->transaction_date = $formattedDate;
            $ticket->no_of_riders = empty($noOfRiders) ? 0 : $noOfRiders;

            return $ticket;
        });

        return $tickets;
    }
    public function getOrderDataReport(Request $request)
    {
        $dateFrom = Carbon::parse($request->dateFrom)->toDateTimeString();
        $dateTo = Carbon::parse($request->dateTo)->toDateTimeString();

        if ($request->platform === 'all') {
            $data = TomsCustomerOrders::join('tickets', 'tickets.id', 'toms_customer_orders.ticket_id')
                ->join('customer_delivery_infos', 'customer_delivery_infos.ticket_id', 'tickets.id')
                ->join('barangays', 'barangays.brgy_id', 'customer_delivery_infos.barangay_id')
                ->join('towns', 'towns.town_id', 'barangays.town_id')
                ->join('province', 'province.prov_id', 'towns.prov_id')
                ->join('order_sources', 'order_sources.id', 'tickets.source_id')
                ->join('fd_products', 'fd_products.product_id', 'toms_customer_orders.product_id')
                ->join('locate_tenants', 'locate_tenants.tenant_id', 'fd_products.tenant_id')
                ->whereDate('submitted_at', '>=', $dateFrom)
                ->whereDate('submitted_at', '<=', $dateTo)
                ->where([
                    ['tickets.order_type_stat', 0],
                    ['toms_customer_orders.canceled_status', 0],
                    ['tickets.cancel_status', 0]
                ])
                ->selectRaw('tickets.ticket, toms_customer_orders.ticket_id, locate_tenants.tenant_id, tenant, pickup_at, ticket, mobile_number, tenant, type, toms_customer_orders.mop, firstname, lastname, street_purok, brgy_name, town_name, zipcode, prov_name, source')
                ->get();
        } else {
            $data = TomsCustomerOrders::join('tickets', 'tickets.id', 'toms_customer_orders.ticket_id')
                ->join('customer_delivery_infos', 'customer_delivery_infos.ticket_id', 'tickets.id')
                ->join('barangays', 'barangays.brgy_id', 'customer_delivery_infos.barangay_id')
                ->join('towns', 'towns.town_id', 'barangays.town_id')
                ->join('province', 'province.prov_id', 'towns.prov_id')
                ->join('order_sources', 'order_sources.id', 'tickets.source_id')
                ->join('fd_products', 'fd_products.product_id', 'toms_customer_orders.product_id')
                ->join('locate_tenants', 'locate_tenants.tenant_id', 'fd_products.tenant_id')
                ->whereDate('toms_customer_orders.submitted_at', '>=',  $dateFrom)
                ->whereDate('toms_customer_orders.submitted_at', '<=', $dateTo)
                ->where([
                    ['tickets.order_type_stat', 0],
                    ['toms_customer_orders.canceled_status', 0],
                    ['tickets.cancel_status', 0],
                    ['tickets.type', $request->platform]
                ])
                ->selectRaw('toms_customer_orders.ticket_id, locate_tenants.tenant_id, tenant, pickup_at, ticket, mobile_number, tenant, type, toms_customer_orders.mop, firstname, lastname, street_purok, brgy_name, town_name, zipcode, prov_name, source')
                ->get();
        }
        $data_result = array();
        foreach ($data->groupBy('ticket') as $key => $value) {
            $tenants = array();
            foreach ($value->groupBy('tenant') as $tkey => $tvalue) {
                $tenants[] = $tkey;
            }
            $data_result[] = [
                'ticket' => $key,
                'tenants' => $tenants,
                'date_time' => $value->first()->pickup_at,
                'contact_num' => $value->first()->mobile_number,
                'remarks' => ($value->first()->type == 1 ? 'Tele-Ordering' : $value->first()->type == 2) ? 'Mobile-Application' : 'Web-Application',
                'mode' => $value->first()->mop ? 'Pick-up' : 'Delivery',
                'name' => $value->first()->lastname . ", " . $value->first()->firstname,
                'address' => $value->first()->street_purok .
                    ', ' .
                    $value->first()->brgy_name .
                    ', ' .
                    $value->first()->town_name .
                    ' ' .
                    $value->first()->zipcode .
                    ', ' .
                    $value->first()->prov_name,
                'town' => $value->first()->town_name,
                'source' => $value->first()->source
            ];
        }
        return $data_result;
    }
    public function getMostCancelledItem()
    {

        $order_data = GCFinalOrder::join('gc_product_items', 'gc_product_items.product_id', 'gc_final_order.product_id')
            ->where('canceled_status', 1)
            ->select('category_name', 'product_name', 'gc_final_order.product_id')
            ->get()
            ->groupBy('product_id');
        $data_result = array();
        foreach ($order_data as $key => $value) {
            $data_result[] = [
                'category_name' => $value->first()->category_name,
                'product_name' => $value->first()->product_name,
                'count' => $value->count()
            ];
        }
        return $data_result;
    }
    public function getHourlyCallMonitoring(Request $request)
    {
        $date = Carbon::parse($request->date)->toDateTimeString();
        $store = $request->store;

        if ($store ===  'all') {
            $data = TenantFood::join('locate_business_units', 'locate_business_units.bunit_code', 'locate_tenants.bunit_code')
                ->where(['locate_tenants.active' => true])
                ->select('locate_business_units.acroname as bunit_acroname', 'locate_tenants.*', 'locate_business_units.*')
                ->orderBy('tenant', 'asc')
                ->get();
        } else {
            $data = TenantFood::join('locate_business_units', 'locate_business_units.bunit_code', 'locate_tenants.bunit_code')
                ->where(['locate_tenants.active' => true, 'locate_tenants.bunit_code' => $store])
                ->select('locate_business_units.acroname as bunit_acroname', 'locate_tenants.*', 'locate_business_units.*')
                ->orderBy('tenant', 'asc')
                ->get();
        }
        $del_time_setup = DeliveryTimeSetup::where('status', true)->get();
        $time_start = new DateTime($del_time_setup->first()->time_start);
        $time_end = new DateTime($del_time_setup->first()->time_end);
        $time_def = $time_end->diff($time_start);
        $result2 = array();
        foreach ($data as $value) {
            $time_data = array();
            $ta = "";
            $tb = "";
            for ($i = 0; $i < $time_def->format("%H"); $i++) {
                if ($i == 0) {
                    $ta = date("g:i:s a", strtotime($time_start->format('H:i:s')));
                    $tb = date("g:i:s a", strtotime('+' . ($i + 1) . "hours", strtotime($time_start->format('H:i:s'))));
                } else {
                    $ta = date("g:i:s a", strtotime('+' . $i . 'hours +1 minutes', strtotime($time_start->format('H:i:s'))));
                    $tb = date("g:i:s a", strtotime('+' . ($i + 1) . "hours", strtotime($time_start->format('H:i:s'))));
                }
                $tran_dataz = Ticket::join('toms_customer_orders', 'toms_customer_orders.ticket_id', 'tickets.id')
                    ->join('fd_products', 'fd_products.product_id', 'toms_customer_orders.product_id')
                    ->where([
                        'toms_customer_orders.canceled_status' => false,
                        'tickets.cancel_status' => false,
                        'fd_products.tenant_id' => $value['tenant_id'],
                    ])
                    ->whereDate('tickets.created_at', $date)
                    ->whereTime('tickets.created_at', '>=', date('H:i:s', strtotime($ta)))
                    ->whereTime('tickets.created_at', '<=', date('H:i:s', strtotime($tb)))
                    ->get()
                    ->groupBy('ticket_id');
                $time_data[] = ['trans_time' => $ta . " - " . $tb, 'trans_num' => $tran_dataz->count()];
            }
            $result2[] = ['tenant' => $value['bunit_acroname'] . "-" . $value['tenant'], 'time_data' => $time_data];
        }
        $result = array();
        for ($i = 0; $i < $time_def->format("%H"); $i++) {
            if ($i == 0) {
                $ta = date("g:i:s a", strtotime($time_start->format('H:i:s')));
                $tb = date("g:i:s a", strtotime('+' . ($i + 1) . "hours", strtotime($time_start->format('H:i:s'))));
            } else {
                $ta = date("g:i:s a", strtotime('+' . $i . 'hours +1 minutes', strtotime($time_start->format('H:i:s'))));
                $tb = date("g:i:s a", strtotime('+' . ($i + 1) . "hours", strtotime($time_start->format('H:i:s'))));
            }
            $tran_dataz = Ticket::join('toms_customer_orders', 'toms_customer_orders.ticket_id', 'tickets.id')
                ->join('fd_products', 'fd_products.product_id', 'toms_customer_orders.product_id')
                ->where(['toms_customer_orders.canceled_status' => false, 'tickets.cancel_status' => false])
                ->whereDate('tickets.created_at', $date)
                ->whereTime('tickets.created_at', '>=', date('H:i:s', strtotime($ta)))
                ->whereTime('tickets.created_at', '<=', date('H:i:s', strtotime($tb)))
                ->get()->groupBy('ticket_id')->count();
            $result[] = ['trans_time' => date('g:i:s', strtotime($ta)) . " - " . date('g:i:s a', strtotime($tb)), 'trans_num' => $tran_dataz];
        }
        return ['result' => $result, 'result2' => $result2];
    }
    public function getCommission(Request $request)
    {
        $dateFrom = Carbon::parse($request->dateFrom)->toDateTimeString();
        $dateTo = Carbon::parse($request->dateTo)->toDateTimeString();

        $result = array();

        if ($request->platform === 'all') {
            $data = Ticket::selectRaw("ticket_id, ticket, type, tickets.created_at as ticket_created, concat(firstname, ' ', lastname) as customer_name")->join('customer_delivery_infos', 'customer_delivery_infos.ticket_id', 'tickets.id')
                ->join('barangays', 'barangays.brgy_id', 'customer_delivery_infos.barangay_id')
                ->join('towns', 'towns.town_id', 'barangays.town_id')
                ->join('province', 'province.prov_id', 'towns.prov_id')
                ->join('order_sources', 'order_sources.id', 'tickets.source_id')
                ->where(['tickets.cancel_status' => false, 'tickets.order_type_stat' => $request->category != 0 ? true : false])
                ->whereDate('tickets.created_at', '>=', $dateFrom)
                ->whereDate('tickets.created_at', '<=',  $dateTo)
                ->orderBy('tickets.id', 'asc')
                ->get();
        } else {
            $data = Ticket::selectRaw("ticket_id, type, ticket, tickets.created_at as ticket_created, concat(firstname, ' ', lastname) as customer_name")->join('customer_delivery_infos', 'customer_delivery_infos.ticket_id', 'tickets.id')
                ->join('barangays', 'barangays.brgy_id', 'customer_delivery_infos.barangay_id')
                ->join('towns', 'towns.town_id', 'barangays.town_id')
                ->join('province', 'province.prov_id', 'towns.prov_id')
                ->join('order_sources', 'order_sources.id', 'tickets.source_id')
                ->where(['tickets.cancel_status' => false, 'tickets.type' => $request->platform, 'tickets.order_type_stat' => $request->category != 0  ? true : false])
                ->whereDate('tickets.created_at', '>=', $dateFrom)
                ->whereDate('tickets.created_at', '<=', $dateTo)
                ->orderBy('tickets.id', 'asc')
                ->get();
        }
        foreach ($data as $value) {
            if ($request->category) {
                $order_data =  GcFinalOrder::where([
                    'ticket_id' => $value['ticket_id'],
                    'canceled_status' => false
                ])->get();
            } else {
                $order_data = TomsCustomerOrders::join('fd_products', 'fd_products.product_id', 'toms_customer_orders.product_id')
                    ->join('locate_tenants', 'locate_tenants.tenant_id', 'fd_products.tenant_id')
                    ->where('toms_customer_orders.ticket_id', $value['ticket_id'])
                    ->where('toms_customer_orders.canceled_status', false)
                    ->get();
            }
            $cust_disc = CustomerDiscountedAmount::where('ticket_id', $value['ticket_id'])->get();
            if ($order_data) {
                $result[] = [
                    'total_purchase' => $cust_disc ? floatval($order_data->sum('total_price')) : floatval($order_data->sum('total_price') - $cust_disc->sum('discount')),
                    'discount' => floatval($cust_disc->sum('discount')),
                    'dataz' => $value,
                    'time' => Carbon::parse($value['ticket_created'])->format('F d, Y h:i A')
                ];
            }
        }

        return $result;
    }
}
