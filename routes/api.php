<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


// this routes is protected by authentication
Route::middleware('auth:api')->group(function () {

    //Uploading Routes
    Route::prefix('uploading')->group(function () {
        Route::post('/item',                                    'API\UploadingController@uploaditem');
        Route::post('/item_price',                              'API\UploadingController@uploadprice');
        Route::post('/item_disable',                            'API\UploadingController@uploadItemDisable');
        Route::post('/item_category',                           'API\UploadingController@uploadcategory');
        Route::post('/item_filename',                           'API\UploadingController@uploaditemfilename');
        Route::post('/item_image',                              'API\UploadingController@multipleImage');
        Route::post('/item_description',                        'API\UploadingController@item_description');
    });
    //End Uploading Routes

    //Chart Routes
    Route::prefix('chart')->group(function () {
        Route::get('/not_available_item',                       'API\ChartController@not_available_item');
        Route::get('/top_items',                                'API\ChartController@top_items');
        Route::get('/top_item_store',                           'API\ChartController@top_item_store');
    });
    //End Chart Routes

    Route::prefix('export')->group(function () {
        Route::get('/product',                                  'Export\ExportController@export_product');
    });
    //Report Routes
    Route::prefix('report')->group(function () {

        //Report for All Store Routes

        Route::get('/liquidation',                              'API\ReportController@get_liquidation');
        Route::get('/accountability',                           'API\ReportController@get_accountability');
        Route::get('/transactions',                             'API\ReportController@get_transactions');
        Route::get('/instruction',                              'API\ReportController@get_instruction');
        Route::get('/unfound',                                  'API\ReportController@get_unfound');
        //End Report for All Store Routes

        //Report for per Store Routes
        Route::prefix('store')->group(function () {
            Route::get('/item_report',                          'API\ReportController@get_item_report_store');
            Route::get('/liquidation',                          'API\ReportController@get_liquidation_store');
            Route::get('/accountability',                       'API\ReportController@get_accountability_store');
        });
        //End Report for per Store Routes

        //Report Foods
        Route::prefix('foods')->group(function () {
            Route::get('/getTenantOrders',                      'API\ReportController@getTenantOrders');
            Route::get('/getTownMostOrders',                    'API\ReportController@getTownMostOrders');
            Route::get('/getTenantMostOrders',                  'API\ReportController@getTenantMostOrders');
            Route::get('/getSourceMostOrder',                   'API\ReportController@getSourceMostOrder');
            Route::get('/getRiderTransaction',                  'API\ReportController@getRiderTransaction');
            Route::get('/getRidersDailyEarning',                'API\ReportController@getRidersDailyEarning');
            Route::get('/getRiderCountPerDay',                  'API\ReportController@getRiderCountPerDay');
            Route::get('/getOrderDataReport',                   'API\ReportController@getOrderDataReport');
            Route::get('/getMostCancelledItem',                 'API\ReportController@getMostCancelledItem');
            Route::get('/getHourlyCallMonitoring',              'API\ReportController@getHourlyCallMonitoring');
            Route::get('/getCommission',                        'API\ReportController@getCommission');
        });
        //End Report Foods

    });
    //End Report Routes

    Route::prefix('product')->group(function () {
        //Product/Item All Store Routes
        Route::get('/show',                                     'API\ItemController@get_item_all_store');
        Route::get('/item_available_all_store/show',            'API\ItemController@item_available_all_store');
        Route::post('/change_status',                           'API\ItemController@change_status');
        Route::post('/image',                                   'API\ItemController@item_image');
        Route::get('/category',                                 'API\ItemController@item_category');
        Route::get('/disable_uom/show',                         'API\ItemController@show_item_disable_per_uom');
        Route::post('/disable_uom',                             'API\ItemController@disable_item_uom');
        Route::get('/enable_uom/show',                          'API\ItemController@show_item_enable_per_uom');
        Route::post('/enable_uom',                              'API\ItemController@enable_item_uom');
        Route::get('/change_price/count',                       'API\ItemController@change_price_count');
        Route::get('/change_price/show',                        'API\ItemController@change_price');

        //End Product/Item All Store Routes


        //Product/Item Per Store Routes
        Route::prefix('per_store')->group(function () {
            Route::get('/show',                                 'API\ItemController@get_item_per_store');
            Route::get('/item_not_available/show',              'API\ItemController@item_not_available_per_store');
            Route::post('/item_enabled',                        'API\ItemController@enabled_selected_item');
            Route::post('/item_disabled',                       'API\ItemController@disabled_selected_item');
            Route::delete('/item_tag_enabled/{itemcode}',       'API\ItemController@tag_item_enabled');
            Route::post('/item_tag_disabled',                   'API\ItemController@tag_item_disabled');
            Route::post('/change_status',                       'API\ItemController@change_status_per_store');
            Route::get('/price_changes/show',                   'API\ItemController@count_price_changes');
        });
        //End Product/Item Per Store Routes
    });

    //Masterfile Setup Routes
    Route::prefix('masterfile')->group(function () {

        Route::get('/province',                                'Masterfile\CommonController@province');
        Route::get('/town',                                    'Masterfile\CommonController@town');
        Route::get('/barangay',                                'Masterfile\CommonController@barangay');
        Route::get('/transportation',                          'Masterfile\CommonController@transportation');
        Route::get('/store',                                   'Masterfile\CommonController@store');
        Route::get('/price_group',                             'Masterfile\CommonController@price_group');
        Route::get('/department',                              'Masterfile\CommonController@department');
        Route::get('/global_category',                         'Masterfile\CommonController@global_category');
        Route::get('/discount',                                'Masterfile\CommonController@discount');
        Route::get('/selected_tenant',                         'Masterfile\CommonController@get_selected_tenant');
        Route::get('/range_level',                             'Masterfile\CommonController@range_level');



        Route::prefix('payment_method')->group(function () {
            Route::get('/show',                                'Masterfile\PaymentMethodController@show_payment_method');
            Route::post('/create',                             'Masterfile\PaymentMethodController@create_payment_method');
            Route::post('/update',                             'Masterfile\PaymentMethodController@update_payment_method');
            Route::post('/change_status',                      'Masterfile\PaymentMethodController@change_status');
        });
        Route::prefix('global_discount')->group(function () {
            Route::get('/show',                                'Masterfile\GlobalDiscountController@show_global_discount');
            Route::post('/create',                             'Masterfile\GlobalDiscountController@create_global_discount');
            Route::post('/update',                             'Masterfile\GlobalDiscountController@update_global_discount');
            Route::post('/change_status',                      'Masterfile\GlobalDiscountController@change_status');
        });
        Route::prefix('discount')->group(function () {
            Route::get('/show',                                'Masterfile\DiscountController@show_discount');
            Route::post('/create',                             'Masterfile\DiscountController@create_discount');
            Route::post('/update',                             'Masterfile\DiscountController@update_discount');
            Route::post('/change_status',                      'Masterfile\DiscountController@change_status');
        });
        Route::prefix('global_categories')->group(function () {
            Route::get('/show',                                'Masterfile\GlobalCategoriesController@show_global_categories');
            Route::post('/create',                             'Masterfile\GlobalCategoriesController@create_global_categories');
            Route::post('/update',                             'Masterfile\GlobalCategoriesController@update_global_categories');
            Route::post('/change_status',                      'Masterfile\GlobalCategoriesController@change_status');
        });
        Route::prefix('bu_group')->group(function () {
            Route::get('/bu_group',                            'Masterfile\BuGroupController@bu_group');
            Route::get('/show',                                'Masterfile\BuGroupController@show_bunit_group');
            Route::post('/create',                             'Masterfile\BuGroupController@create_bunit_group');
            Route::post('/update',                             'Masterfile\BuGroupController@update_bunit_group');
            Route::post('/change_status',                      'Masterfile\BuGroupController@change_status');
        });
        Route::prefix('bu_time')->group(function () {
            Route::get('/show',                                'Masterfile\BuTimeController@show_bunit_time');
            Route::post('/create',                             'Masterfile\BuTimeController@save_business_time');
            Route::post('/update',                             'Masterfile\BuTimeController@update_business_time');
            Route::post('/change_status',                      'Masterfile\BuTimeController@change_status');
        });

        Route::prefix('bunit')->group(function () {
            Route::get('/show',                                'Masterfile\BunitController@show_business_unit');
            Route::post('/create',                             'Masterfile\BunitController@create_business_unit');
            Route::post('/update',                             'Masterfile\BunitController@update_business_unit');
            Route::post('/status',                             'Masterfile\BunitController@status_business_unit');
            Route::post('/set_global_category',                'Masterfile\BunitController@set_global_category');
            Route::post('/change_photo',                       'Masterfile\BunitController@change_photo');
        });
        Route::prefix('usertype')->group(function () {

            Route::get('/show',                                'Masterfile\UserTypeController@show_usertype');
            Route::post('/status',                             'Masterfile\UserTypeController@change_status');

            Route::prefix('tenant')->group(function () {
                Route::post('/create',                         'Masterfile\UserTypeController@create_usertype_tenant');
                Route::post('/update',                         'Masterfile\UserTypeController@update_usertype_tenant');
            });
            Route::prefix('system')->group(function () {
                Route::post('/create',                         'Masterfile\UserTypeController@create_system_usertype');
                Route::post('/update',                         'Masterfile\UserTypeController@update_system_usertype');
            });
        });
        Route::prefix('rule')->group(function () {
            Route::get('/show',                                'Masterfile\BRuleController@show_rule');
            Route::post('/update',                             'Masterfile\BRuleController@update_rule');
            Route::get('/show/{id}',                           'API\SetUpController@rule_show_by_id');
        });

        Route::prefix('price_group')->group(function () {
            Route::get('/show',                                'Masterfile\PriceGroupController@show_price_goup');
            Route::post('/update',                             'Masterfile\PriceGroupController@update_price_group');
            Route::delete('/price_group/{id}',                 'API\SetUpController@delete_price_group');
        });

        Route::prefix('tenant')->group(function () {
            Route::prefix('goods')->group(function () {
                Route::get('/show',                            'Masterfile\TenantController@show_goods_tenant');
                Route::post('/save',                           'Masterfile\TenantController@save_goods_tenant');
                Route::post('/update',                         'Masterfile\TenantController@update_goods_tenant');
                Route::post('/change_status',                  'Masterfile\TenantController@change_status_goods_tenant');
            });
            Route::prefix('foods')->group(function () {
                Route::get('/show',                            'Masterfile\TenantController@show_foods_tenant');
                Route::post('/save',                           'Masterfile\TenantController@save_foods_tenant');
                Route::post('/update',                         'Masterfile\TenantController@update_foods_tenant');
                Route::post('/change_status',                  'Masterfile\TenantController@change_status_foods_tenant');
                Route::post('/contacts',                       'Masterfile\TenantController@show_contacts_tenant_foods');
                Route::post('/save_contact',                   'Masterfile\TenantController@save_contacts_tenant_foods');
                Route::post('/remove_contact',                 'Masterfile\TenantController@remove_contacts_tenant_foods');
                Route::post('/change_image',                   'Masterfile\TenantController@change_image_tenant_foods');
            });
        });

        Route::prefix('min_order')->group(function () {
            Route::prefix('goods')->group(function () {
                Route::get('/show',                            'Masterfile\MinOrderController@show_min_order_goods');
                Route::post('/save',                           'Masterfile\MinOrderController@save_min_order_goods');
                Route::post('/update',                         'Masterfile\MinOrderController@update_min_order_goods');
                Route::post('/change_status',                  'Masterfile\MinOrderController@status_min_order_goods');
            });
            Route::prefix('foods')->group(function () {
                Route::get('/show',                            'Masterfile\MinOrderController@show_min_order_foods');
                Route::post('/save',                           'Masterfile\MinOrderController@save_min_order_foods');
                Route::post('/update',                         'Masterfile\MinOrderController@update_min_order_foods');
                Route::post('/change_status',                  'Masterfile\MinOrderController@status_min_order_foods');
            });
        });

        Route::prefix('delivery_charge')->group(function () {
            Route::prefix('goods')->group(function () {
                Route::get('/show',                            'Masterfile\DeliveryChargeController@show_delivery_charges_goods');
                Route::post('/save',                           'Masterfile\DeliveryChargeController@create_delivery_charges_goods');
                Route::post('/update',                         'Masterfile\DeliveryChargeController@update_delivery_charges_goods');
                Route::post('/change_status',                  'Masterfile\DeliveryChargeController@change_status_goods');
            });
            Route::prefix('foods')->group(function () {
                Route::get('/show',                            'Masterfile\DeliveryChargeController@show_delivery_charges_foods');
                Route::post('/save',                           'Masterfile\DeliveryChargeController@create_delivery_charges_foods');
                Route::post('/update',                         'Masterfile\DeliveryChargeController@update_delivery_charges_foods');
                Route::post('/change_status',                  'Masterfile\DeliveryChargeController@change_status_foods');
            });
        });

        Route::prefix('province')->group(function () {
            Route::get('/show',                                'Masterfile\ProvinceController@show_province');
            Route::post('/update',                             'Masterfile\ProvinceController@update_province');
            Route::post('/save',                               'Masterfile\ProvinceController@save_province');
            Route::post('/status',                             'Masterfile\ProvinceController@change_province_status');
        });

        Route::prefix('town')->group(function () {
            Route::get('/show',                                'Masterfile\TownController@show_town');
            Route::post('/save',                               'Masterfile\TownController@save_town');
            Route::post('/update',                             'Masterfile\TownController@update_town');
            Route::post('/status',                             'Masterfile\TownController@change_status');
        });

        Route::prefix('barangay')->group(function () {

            Route::get('/show',                                'Masterfile\BrgyController@show_brgy');
            Route::post('/save',                               'Masterfile\BrgyController@save_brgy');
            Route::post('/update',                             'Masterfile\BrgyController@update_brgy');
            Route::post('/status',                             'Masterfile\BrgyController@change_status');
        });

        Route::prefix('tenant_food')->group(function () {
            Route::get('/show',                                'API\SetUpController@show_tenant_food');
        });

        Route::prefix('location_group')->group(function () {
            Route::get('/show',                                'Masterfile\LocationGroupController@location_group');
            Route::get('/default_data',                        'Masterfile\LocationGroupController@get_default_data');
            Route::post('/update',                             'Masterfile\LocationGroupController@update_data');
        });
    });


    Route::prefix('user')->group(function () {

        Route::get('/usertype',                                 'Masterfile\UserController@usertype');
        Route::get('/employees',                                'Masterfile\UserController@employees');
        Route::get('/userrole',                                 'Masterfile\UserController@userrole');

        Route::prefix('good')->group(function () {
            Route::get('/show',                                 'Masterfile\UserController@get_users');
            Route::post('/create',                              'Masterfile\UserController@create_good_user');
            Route::post('/update',                              'Masterfile\UserController@update_user');
            Route::post('/profile_image',                       'Masterfile\UserController@profile_image');
            Route::post('/change_password',                     'Masterfile\UserController@change_password');
            Route::post('/change_username',                     'Masterfile\UserController@change_username');
            Route::post('/status',                              'Masterfile\UserController@user_status');
            Route::post('/reset_password',                      'Masterfile\UserController@goods_user_reset_password');
        });

        Route::prefix('food')->group(function () {

            Route::get('/default',                              'Masterfile\UserController@get_default_data');
            Route::get('/usertype',                             'Masterfile\UserController@food_usertype');

            Route::prefix('tenant')->group(function () {
                Route::get('/show',                             'Masterfile\UserController@get_tenant_users');
                Route::get('/tenant_usertype',                  'Masterfile\UserController@get_tenant_usertype');
                Route::post('/update_user',                     'Masterfile\UserController@update_user_tenant');
                Route::post('/create_user',                     'Masterfile\UserController@create_user_tenant');
                Route::post('/reset_password',                  'Masterfile\UserController@tenant_reset_password');
                Route::post('/status',                          'Masterfile\UserController@change_tenant_user_status');
                Route::post('/user_photo',                      'Masterfile\UserController@change_tenant_user_photo');
            });
            Route::prefix('system')->group(function () {
                Route::get('/show',                             'Masterfile\UserController@get_system_users');
                Route::post('/create_user',                     'Masterfile\UserController@create_system_user');
                Route::post('/update_user',                     'Masterfile\UserController@update_system_user');
                Route::post('/user_photo',                      'Masterfile\UserController@change_system_user_photo');
                Route::post('/status',                          'Masterfile\UserController@change_system_user_status');
                Route::post('/reset_password',                  'Masterfile\UserController@system_user_reset_password');
                Route::post('/save_user_role',                  'Masterfile\UserController@save_user_role');
            });
        });
    });
});
