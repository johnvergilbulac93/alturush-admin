<template>
    <Menu theme="light" style="width: 100%;" accordion>
        <MenuItem name="1" to="/">
                <Icon type="ios-speedometer" />
                Dashboard
        </MenuItem>
        <MenuGroup title="Reports">
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
        </MenuGroup>
    </Menu>
</template>
