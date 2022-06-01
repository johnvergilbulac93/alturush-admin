//goods components
import landing_page from "./../components/goods/pages/Landing-page";
import item from "./../components/goods/pages/Item-masterfile";
import disabled_item_batch from "./../components/goods/pages/Item-disabled-batch";
import dashboard from "./../components/goods/pages/Dashboard";
import monitoring from "./../components/dashboard/Monitoring";

import reports_store from "./../components/goods/pages/Reports-store";

import exporting from "./../components/goods/pages/ExportFiles";

import count from "./../components/goods/pages/Available-item-store";

import minimum_delivery from "./../components/goods/pages/Minimum-order-delivery";
import liquidition_store from "./../components/goods/pages/Liquidition-Report-Store";
import accountability_store from "./../components/goods/pages/Accountability-Report-Store";

import change_password from "./../components/goods/pages/Change-Password";
import change_username from "./../components/goods/pages/Change-Username";
import contact_us from "./../Usable/Contact-Us";

import user from "./../components/masterfile/User";
import user_type from "./../components/masterfile/Usertype";
import business_unit from "./../components/masterfile/Business-unit";
import business_unit_group from "./../components/masterfile/Business-unit-group";
import business_unit_time from "./../components/masterfile/Business-unit-time";
import business_rule from "./../components/masterfile/Business-rule";
import price_group from "./../components/masterfile/Price-group";
import global_categories from "./../components/masterfile/Global-Categories";
import discount from "./../components/masterfile/Discounts";
import global_discount from "./../components/masterfile/Global-Discount";
import payment_method from "./../components/masterfile/Payment-method";
import delivery_charges from "./../components/masterfile/Delivery-Charges";
import tenant from "./../components/masterfile/Tenant";
import province from "./../components/masterfile/Provinces";
import towns from "./../components/masterfile/Towns";
import barangay from "./../components/masterfile/Barangay";
import minimum_order from "./../components/masterfile/Minimum-Order";
import location_group_setup from "./../components/masterfile/Location-Group";
import voucher from "./../components/masterfile/Voucher-Categories";

import product_list from "./../components/goods/pages/Central-item";
import disable_uom from "./../components/goods/pages/Item-disable-per-uom";
import enable_uom from "./../components/goods/pages/Item-enable-per-uom";
import export_product from "./../components/goods/pages/ExportProduct";

import upload_new_product from "./../components/goods/pages/Uploading/NewProduct";
import upload_new_price from "./../components/goods/pages/Uploading/PriceUpdate";
import upload_filename from "./../components/goods/pages/Uploading/ImageFilename";
import product_category from "./../components/goods/pages/Uploading/ProductCategory";
import product_description from "./../components/goods/pages/Uploading/ProductDescription";

import liquidation from "./../components/goods/pages/Reports/Liquidition-Report";
import accountability from "./../components/goods/pages/Reports/Accountability-Report";
import transaction from "./../components/goods/pages/Reports/Transactions";
import comments_suggestions from "./../components/goods/pages/Reports/Special-Instructions-Comments-Suggestions";

import tenant_order_details from "./../components/foods/pages/report/TenantOrderDetails";
import town_most_order from "./../components/foods/pages/report/TownMostOrder";
import tenant_most_order from "./../components/foods/pages/report/TenantMostOrder";
import source_most_order from "./../components/foods/pages/report/SourceMostOrder";
import rider_transaction from "./../components/foods/pages/report/RiderTransaction";
import rider_daily_earning from "./../components/foods/pages/report/RiderDailyEarning";
import rider_count_per_day from "./../components/foods/pages/report/RiderCountPerDay";
import order_data_report from "./../components/foods/pages/report/OrderDataReport";
import hourly_call_monitoring from "./../components/foods/pages/report/HourlyCallMonitoring";
import alturush_commission from "./../components/foods/pages/report/AlturushCommission";

import tenants_order from "./../components/foods/pages/OrderManagement/Tenant-Order";
import rider_lists from "./../components/foods/pages/Rider/RiderList";

import Redirect from "./../Usable/Redirect";

const routes = [
    {
        path: "/",
        name: "monitoring",
        component: monitoring
    },
    {
        path: "/change_password",
        name: "change_password",
        component: change_password
    },
    {
        path: "/change_username",
        name: "change_username",
        component: change_username
    },

    {
        path: "/masterfile/user",
        name: "users",
        component: user
    },
    {
        path: "/masterfile/user-type",
        name: "user_type",
        component: user_type
    },
    {
        path: "/masterfile/business-unit",
        name: "b_unit",
        component: business_unit
    },
    {
        path: "/masterfile/business-unit-group",
        name: "b_unit_group",
        component: business_unit_group
    },
    {
        path: "/masterfile/business-unit-time",
        name: "b_unit_time",
        component: business_unit_time
    },
    {
        path: "/masterfile/business-rule",
        name: "business_rule",
        component: business_rule
    },
    {
        path: "/masterfile/price-group",
        name: "price_group",
        component: price_group
    },
    {
        path: "/masterfile/global-categories",
        name: "global_categories",
        component: global_categories
    },
    {
        path: "/masterfile/discount",
        name: "discount",
        component: discount
    },
    {
        path: "/masterfile/global-discount",
        name: "global_discount",
        component: global_discount
    },
    {
        path: "/masterfile/payment-method-setup",
        name: "payment_method",
        component: payment_method
    },
    {
        path: "/masterfile/delivery-charges",
        name: "delivery_charges",
        component: delivery_charges
    },
    {
        path: "/masterfile/tenant",
        name: "tenant",
        component: tenant
    },
    {
        path: "/masterfile/province",
        name: "province",
        component: province
    },
    {
        path: "/masterfile/towns",
        name: "towns",
        component: towns
    },
    {
        path: "/masterfile/barangays",
        name: "barangay",
        component: barangay
    },
    {
        path: "/masterfile/minimum_order",
        name: "minimum_order",
        component: minimum_order
    },
    {
        path: "/masterfile/location_group_setup",
        name: "location_group_setup",
        component: location_group_setup
    },
    {
        path: "/masterfile/voucher",
        name: "voucher",
        component: voucher
    },
    {
        path: "/goods/product_lists",
        name: "product_list",
        component: product_list
    },
    {
        path: "/goods/disable_product_uom",
        name: "disable_uom",
        component: disable_uom
    },
    {
        path: "/goods/enable_product_uom",
        name: "enable_uom",
        component: enable_uom
    },
    {
        path: "/goods/export_product",
        name: "export_product",
        component: export_product
    },

    {
        path: "/goods/uploading/new_product",
        name: "upload_new_product",
        component: upload_new_product
    },
    {
        path: "/goods/uploading/change_price",
        name: "upload_new_price",
        component: upload_new_price
    },
    {
        path: "/goods/uploading/filename",
        name: "upload_filename",
        component: upload_filename
    },
    {
        path: "/goods/uploading/product_category",
        name: "product_category",
        component: product_category
    },
    {
        path: "/goods/uploading/update_product_description",
        name: "product_description",
        component: product_description
    },
    {
        path: "/goods/report/liquidation",
        name: "liquidation",
        component: liquidation
    },
    {
        path: "/goods/report/accountability",
        name: "accountability",
        component: accountability
    },
    {
        path: "/goods/report/total_order_remitted",
        name: "transaction",
        component: transaction
    },
    {
        path: "/goods/report/comments_and_suggestions",
        name: "comments_suggestions",
        component: comments_suggestions
    },
    {
        path: "/foods/report/tenant_order_details",
        name: "tenant_order_details",
        component: tenant_order_details
    },
    {
        path: "/foods/report/town_most_order",
        name: "town_most_order",
        component: town_most_order
    },
    {
        path: "/foods/report/tenant_most_order",
        name: "tenant_most_order",
        component: tenant_most_order
    },
    {
        path: "/foods/report/source_most_order",
        name: "source_most_order",
        component: source_most_order
    },
    {
        path: "/foods/report/rider_transaction",
        name: "rider_transaction",
        component: rider_transaction
    },
    {
        path: "/foods/report/rider_daily_earning",
        name: "rider_daily_earning",
        component: rider_daily_earning
    },
    {
        path: "/foods/report/rider_count_per_day",
        name: "rider_count_per_day",
        component: rider_count_per_day
    },
    {
        path: "/foods/report/order_data_report",
        name: "order_data_report",
        component: order_data_report
    },
    {
        path: "/foods/report/hourly_call_monitoring",
        name: "hourly_call_monitoring",
        component: hourly_call_monitoring
    },
    {
        path: "/foods/report/alturush_commission",
        name: "alturush_commission",
        component: alturush_commission
    },
    {
        path: "/foods/tenants_order",
        name: "tenants_order",
        component: tenants_order
    },
    {
        path: "/foods/rider_lists",
        name: "rider_lists",
        component: rider_lists
    },
    // {
    //     path: "/dashboard",
    //     name: "dashboard",
    //     component: dashboard
    // },
    {
        path: "/item",
        name: "item",
        component: item
    },
    {
        path: "/disabled_item_batch",
        name: "disabled_item",
        component: disabled_item_batch
    },
    {
        path: "/reports_store",
        name: "reports_store",
        component: reports_store
    },
    {
        path: "/exporting",
        name: "export",
        component: exporting
    },
    {
        path: "/count",
        name: "count",
        component: count
    },

    {
        path: "/minimum_delivery",
        name: "minimum_delivery",
        component: minimum_delivery
    },
    {
        path: "/liquidition_store",
        name: "liquidition_store",
        component: liquidition_store
    },
    {
        path: "/accountability_store",
        name: "accountability_store",
        component: accountability_store
    },
    {
        path: "/contact_us",
        name: "contact_us",
        component: contact_us
    },
    { path: "*", component: Redirect }
];
export default routes;
