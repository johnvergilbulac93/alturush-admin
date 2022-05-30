<template>
    <Menu theme="light" style="width: 100%;" accordion>
        <Submenu name="1">
            <template slot="title">
                <Icon type="ios-analytics" />
                Dashboard
            </template>
            <MenuItem name="1-1">Goods Dashboard</MenuItem>
            <MenuItem name="1-2">Foods Dashboard</MenuItem>
        </Submenu>
        <Submenu name="2">
            <template slot="title">
                <Icon type="md-settings" />
                Masterfile
            </template>

            <MenuItem name="2-1" to="/masterfile/user">Users</MenuItem>
            <MenuItem name="2-2" to="/masterfile/user-type">Usertype(s)</MenuItem>

            <MenuItem name="2-3" to="/masterfile/business-unit">Business Unit(s)</MenuItem>
            <MenuItem name="2-4" to="/masterfile/business-unit-group">Business Unit(s) Group</MenuItem>
            <MenuItem name="2-5" to="/masterfile/business-unit-time">Business Unit(s) Time</MenuItem>
            <MenuItem name="2-6" to="/masterfile/business-rule">Business Rules</MenuItem>

            <MenuItem name="2-7" to="/masterfile/price-group">Price Group</MenuItem>
            <MenuItem name="2-8" to="/masterfile/global-categories">Global Categories</MenuItem>
            <MenuItem name="2-9" to="/masterfile/discount">Discount</MenuItem>
            <MenuItem name="2-10" to="/masterfile/global-discount">Global Discount Setup</MenuItem>
            <MenuItem name="2-11" to="/masterfile/payment-method-setup">Payment Method</MenuItem>
            <MenuItem name="2-12" to="/masterfile/delivery-charges">Delivery Charges</MenuItem>
            <MenuItem name="2-19" to="/masterfile/voucher">Voucher Categories</MenuItem>

            <MenuItem name="2-13" to="/masterfile/tenant">Tenant</MenuItem>
            <MenuItem name="2-14" to="/masterfile/province">Province(s)</MenuItem>
            <MenuItem name="2-15" to="/masterfile/towns">Town(s)</MenuItem>
            <MenuItem name="2-16" to="/masterfile/barangays">Barangay(s)</MenuItem>
            <MenuItem name="2-17" to="/masterfile/minimum_order">Minimum Order</MenuItem>
            <MenuItem name="2-18" to="/masterfile/location_group_setup">Location Group Setup</MenuItem>


        </Submenu>
        <Submenu name="3">
            <template slot="title">
                <Icon type="md-folder" />
                Goods Files
            </template>
            <Submenu name="4">
                <template slot="title">
                    <Icon type="ios-archive" />
                    Product
                </template>
                <MenuItem name="3-1" to="/goods/product_lists">Product Lists</MenuItem>
                <MenuItem name="3-2" to="/goods/disable_product_uom">Disable Product Unit of Measure(UOM)</MenuItem>
                <MenuItem name="3-3" to="/goods/enable_product_uom">Enable Product Unit of Measure(UOM)</MenuItem>
                <MenuItem name="3-4" to="/goods/export_product">Export Product(s) </MenuItem>

            </Submenu>
            <Submenu name="5">
                <template slot="title">
                    <Icon type="md-cloud-upload" />
                    Uploading
                </template>
                <MenuItem name="5-1" to="/goods/uploading/new_product">New Product </MenuItem>
                <MenuItem name="5-2" to="/goods/uploading/change_price">Change Price</MenuItem>
                <MenuItem name="5-3" to="/goods/uploading/filename">Image filename </MenuItem>
                <MenuItem name="5-4" to="/goods/uploading/product_category">Product Category</MenuItem>
                <!-- <MenuItem name="5-5">Multiple Images</MenuItem> -->
                <MenuItem name="5-6" to="/goods/uploading/update_product_description">Product Description</MenuItem>
            </Submenu>
        </Submenu>
        <Submenu name="9">
            <template slot="title">
                <Icon type="md-folder" />
                Foods Files
            </template>
            <MenuItem name="9-1" to="/foods/tenants_order">Tenant(s) Order</MenuItem>
            <MenuItem name="9-2" to="/foods/rider_lists">Rider List </MenuItem>

        </Submenu>
        <Submenu name="6">
            <template slot="title">
                <Icon type="md-analytics" />
                Reports
            </template>
            <Submenu name="7">
                <template slot="title">
                    <Icon type="md-analytics" />
                    Goods
                </template>
                <MenuItem name="7-1" to="/goods/report/liquidation">Liquidation</MenuItem>
                <MenuItem name="7-2" to="/goods/report/accountability">Accountability</MenuItem>
                <MenuItem name="7-3" to="/goods/report/total_order_remitted">Total Order - REMITTED</MenuItem>
                <MenuItem name="7-4" to="/goods/report/comments_and_suggestions">Comments & Suggestions</MenuItem>
            </Submenu>
            <Submenu name="8">
                <template slot="title">
                    <Icon type="md-analytics" />
                    Foods
                </template>
                <MenuItem name="8-1" to="/foods/report/tenant_order_details">Tenant Order Details</MenuItem>
                <MenuItem name="8-2" to="/foods/report/town_most_order">Town Most Order</MenuItem>
                <MenuItem name="8-3" to="/foods/report/tenant_most_order">Tenant Most Order</MenuItem>
                <MenuItem name="8-4" to="/foods/report/source_most_order">Source Most Order</MenuItem>
                <MenuItem name="8-5" to="/foods/report/rider_transaction">Rider Transaction</MenuItem>
                <MenuItem name="8-6" to="/foods/report/rider_daily_earning">Rider Daily Earning</MenuItem>
                <MenuItem name="8-7" to="/foods/report/rider_count_per_day">Rider Count Per Day</MenuItem>
                <MenuItem name="8-8" to="/foods/report/order_data_report">Order Data Report</MenuItem>
                <MenuItem name="8-9" to="/foods/report/hourly_call_monitoring">Hourly Call Monitoring</MenuItem>
                <MenuItem name="8-0" to="/foods/report/alturush_commission">Alturush Commission</MenuItem>
            </Submenu>
        </Submenu>
    </Menu>
</template>
