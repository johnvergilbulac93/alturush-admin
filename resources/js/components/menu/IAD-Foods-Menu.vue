<template>
    <div class="mt-5 w-full border-l ">
        <MenuItem text="Dashboard" icon="fas fa-tachometer-alt" :route="{ name: 'dashboard' }" />
        <MenuItem text="Inquiry" icon="fas fa-info-circle"  >
          <template #sub-menu>
               <SubItem text="Daily Sales" :route="{name: 'daily_inquiry'}" />
               <SubItem text="Weekly Sales" :route="{name: 'weekly_inquiry'}"  />
               <SubItem text="Monthly Sales" :route="{name: 'monthly_inquiry'}" />
          </template>
        </MenuItem>
        <MenuItem text="Report" icon="fas fa-print"  >
          <template #sub-menu>
               <SubItem text="Tenant Order Details" :route="{name: 'tenant_order_details'}"/>
               <SubItem text="Town Most Order" :route="{name: 'town_most_order'}" />
               <SubItem text="Tenant Most Order" :route="{name: 'tenant_most_order'}" />
               <SubItem text="Source Most Order" :route="{name: 'source_most_order'}"/>
               <SubItem text="Rider Transaction" :route="{name: 'rider_transaction'}"/>      
               <SubItem text="Rider Daily Earning" :route="{name: 'rider_daily_earning'}"/>
               <SubItem text="Rider Count Per Day" :route="{name: 'rider_count_per_day'}"/>

               <SubItem text="Order Data Report" :route="{name: 'order_data_report'}"/>
               <SubItem text="Most Cancelled Items" :route="{name: 'most_cancelled_items'}"/>
               <SubItem text="Hourly Call Monitoring" :route="{name: 'hourly_call_monitoring'}"/>
               <SubItem text="Alturush Commission" :route="{name: 'alturush_commission'}"/>
          </template>
         </MenuItem>
    </div>
</template>
    