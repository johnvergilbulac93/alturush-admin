<?php

namespace App\Http\Controllers\API;

use App\gc_product_item;
use App\gc_product_price;
use App\gc_product_uom;
use App\gc_item_log_available;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ItemController extends Controller
{

    public function get_item_per_store(Request $request)
    {
        $columns = ['product_id', 'itemcode', 'product_name', 'category_name', 'product_id'];

        $length = $request->input('length');
        $column = $request->input('column');
        $dir = $request->input('dir');
        $searchValue = $request->input('search');
        $categoryValue = $request->input('category');
        $type = $request->input('type');

        $query = gc_product_item::with(['items'])->where('status', 'active')->orderBy($columns[$column], $dir);

        $query2 =  gc_product_item::with(['items'])->where('status', 'active')
            ->whereNotIn('itemcode', function ($query) {
                $query->select('gc_item_log_availables.itemcode')->from('gc_item_log_availables')->where('gc_item_log_availables.store', '=', Auth::user()->bunit_code);
            })->orderBy($columns[$column], $dir);

        $query3 =  gc_product_item::with(['items'])->where('status', 'active')
            ->whereIn('itemcode', function ($query) {
                $query->select('gc_item_log_availables.itemcode')->from('gc_item_log_availables')->where('gc_item_log_availables.store', '=', Auth::user()->bunit_code);
            })->orderBy($columns[$column], $dir);

        if ($type) {
            if ($type == 1 || $categoryValue) {
                $query2->where(function ($query) use ($categoryValue) {
                    $query->where('category_name', 'like', '%' . $categoryValue . '%');
                });
            }
            if ($type == 2 || $categoryValue) {
                $query3->where(function ($query) use ($categoryValue) {
                    $query->where('category_name', 'like', '%' . $categoryValue . '%');
                });
            }

            if ($type == 1 || $searchValue) {
                $query2->where(function ($query) use ($searchValue) {
                    $query->where('itemcode', 'like', '%' . $searchValue . '%')
                        ->orWhere('product_name', 'like', '%' . $searchValue . '%');
                });
            }
            if ($type == 2 || $searchValue) {
                $query3->where(function ($query) use ($searchValue) {
                    $query->where('itemcode', 'like', '%' . $searchValue . '%')
                        ->orWhere('product_name', 'like', '%' . $searchValue . '%');
                });
            }
        } else {

            if ($searchValue) {
                $query->where(function ($query) use ($searchValue) {
                    $query->where('itemcode', 'like', '%' . $searchValue . '%')
                        ->orWhere('product_name', 'like', '%' . $searchValue . '%');
                });
            }

            if ($categoryValue) {
                $query->where(function ($query) use ($categoryValue) {
                    $query->where('category_name', 'like', '%' . $categoryValue . '%');
                });
            }
        }
        if ($type) {
            if ($type == 1) {
                $projects = $query2->paginate($length);
            }
            if ($type == 2) {
                $projects = $query3->paginate($length);
            }
        } else {
            $projects = $query->paginate($length);
        }

        return $projects;
    }

    public function get_item_all_store(Request $request)
    {
        $price_group = $request->price_group;
        $store = $request->store;
        $length = $request->length;
        $dir = $request->dir;
        $searchValue = $request->search;
        $categoryValue = $request->category;

        $query = gc_product_item::with(['item_price' => function (HasMany $q) use ($price_group) {
            $q->where('price_group', $price_group);
        }, 'item_not_available' => function (BelongsTo $q) use ($store) {
            $q->where('store', $store);
        }])->orderBy('product_id', $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('itemcode', 'like', '%' . $searchValue . '%')
                    ->orWhere('product_name', 'like', '%' . $searchValue . '%');
            });
        }

        if ($categoryValue) {
            $query->where(function ($query) use ($categoryValue) {
                $query->where('category_name', 'like', '%' . $categoryValue . '%');
            });
        }

        $finalResults = $query->paginate($length);

        return $finalResults;
    }

    public function item_not_available_per_store(Request $request)
    {

        $length = $request->input('length');
        $column = $request->input('column');
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query =  DB::table('gc_item_log_availables')
            ->join('gc_product_items', 'gc_product_items.itemcode', '=', 'gc_item_log_availables.itemcode')
            ->join('locate_business_units', 'locate_business_units.bunit_code', '=', 'gc_item_log_availables.store')
            ->select('*')
            ->where('gc_product_items.status', '=', 'active')
            ->where('gc_item_log_availables.store', '=', Auth::user()->bunit_code)
            ->orderBy('product_id', $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('gc_product_items.itemcode', 'like', '%' . $searchValue . '%')
                    ->orWhere('gc_product_items.product_name', 'like', '%' . $searchValue . '%');
            });
        }

        $final_result = $query->paginate($length);

        return  $final_result;
    }
    public function item_available_all_store()
    {
        return DB::table('gc_item_log_availables')
            ->join('gc_product_items', 'gc_product_items.itemcode', '=', 'gc_item_log_availables.itemcode')
            ->join('locate_business_units', 'locate_business_units.bunit_code', '=', 'gc_item_log_availables.store')
            ->select('*')
            ->get();
    }
    public function  tag_item_disabled(Request $request)
    {
        gc_item_log_available::insert([
            'itemcode'       => $request->itemcode,
            'store'          => Auth::user()->bunit_code,
            'tag_by'         => Auth::user()->name,
        ]);
    }

    public function tag_item_enabled($id)
    {
        gc_item_log_available::where('store', '=', Auth::user()->bunit_code)
            ->where('itemcode', '=', $id)
            ->delete();
    }

    public function change_status(Request $request)
    {
        if ($request->status == 'active') {
            $status = 'inactive';
        } else {
            $status = 'active';
        }
        $save = gc_product_item::where('product_id', $request->id)->update([
            'status'       => $status,
        ]);
        if ($save) {
            return ['msg' => 'Status successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }


    public function item_image(Request $request)
    {

        $image = $request->file('image');
        $imageName = $request->itemcode . '.' . $image->getClientOriginalName();

        $path = public_path() . '/ITEM-IMAGES/' . $imageName;

        if (file_exists($path)) {
            @unlink($path);
        }

        $image->move(public_path('ITEM-IMAGES'), $imageName);
        // $itemImage->move('../admins.alturush.com/ITEM-IMAGES/' , $imageName);

        $save = gc_product_item::where('product_id', $request->id)->update([
            'image' => $imageName
        ]);

        if ($save) {
            return ['msg' => 'Picture updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }

    public function show_item_disable_per_uom(Request $request)
    {

        $length = $request->input('length');
        $column = $request->input('column');
        $dir = $request->input('dir');
        $searchValue = $request->input('search');
        $categoryValue = $request->input('category');
        $query =  DB::table('gc_product_items')
            ->join('gc_product_prices', 'gc_product_items.itemcode', '=', 'gc_product_prices.itemcode')
            ->where('gc_product_prices.status', '=', 1)
            ->select('*')
            ->orderBy('price_id', $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('gc_product_prices.itemcode', 'like', '%' . $searchValue . '%')
                    ->orWhere('gc_product_items.product_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('gc_product_prices.UOM', 'like', '%' . $searchValue . '%');
            });
        }

        if ($categoryValue) {
            $query->where(function ($query) use ($categoryValue) {
                $query->where('gc_product_items.category_name', 'like', '%' . $categoryValue . '%');
            });
        }

        $finalResults = $query->paginate($length);

        return $finalResults;
    }
    public function disable_item_uom(Request $request)
    {
        $save = gc_product_price::whereIn('price_id', $request->ids)->update([
            'status' => 0
        ]);
        if ($save) {
            return ['msg' => 'Product UOM successfully disabled.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function enable_item_uom(Request $request)
    {
        $save = gc_product_price::whereIn('price_id', $request->ids)->update([
            'status' => 1
        ]);
        if ($save) {
            return ['msg' => 'Product UOM successfully enabled.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function show_item_enable_per_uom(Request $request)
    {
        $length = $request->input('length');
        $dir = $request->input('dir');
        $searchValue = $request->input('search');
        $categoryValue = $request->input('category');

        $query =  DB::table('gc_product_items')
            ->join('gc_product_prices', 'gc_product_items.itemcode', '=', 'gc_product_prices.itemcode')
            ->where('gc_product_prices.status', '=', 0)
            ->select('*')
            ->orderBy('price_id', $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('gc_product_prices.itemcode', 'like', '%' . $searchValue . '%')
                    ->orWhere('gc_product_items.product_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('gc_product_prices.UOM', 'like', '%' . $searchValue . '%');
            });
        }

        if ($categoryValue) {
            $query->where(function ($query) use ($categoryValue) {
                $query->where('gc_product_items.category_name', 'like', '%' . $categoryValue . '%');
            });
        }

        $finalResults = $query->paginate($length);

        return $finalResults;
    }
    public function change_price_count()
    {
        return  DB::table('gc_product_items')
            ->join('gc_product_price_histories', 'gc_product_items.itemcode', '=', 'gc_product_price_histories.itemcode')
            ->whereDate('gc_product_price_histories.update_at', Carbon::today()->toDateString())
            ->select('*')
            ->whereIn('gc_product_items.itemcode', function ($query) {
                $query->select('gc_product_price_histories.itemcode')->from('gc_product_price_histories');
            })
            ->count();
    }

    public function change_price(Request $request)
    {
        $price_group = $request->input('price_group');;
        $length = $request->input('length');
        $column = $request->input('column');
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query =  DB::table('gc_product_items')
            ->join('gc_product_price_histories', 'gc_product_items.itemcode', '=', 'gc_product_price_histories.itemcode')
            ->whereDate('gc_product_price_histories.update_at', Carbon::today()->toDateString())
            ->where('gc_product_price_histories.price_group',  $price_group)
            ->select('*')
            ->whereIn('gc_product_items.itemcode', function ($query) {
                $query->select('gc_product_price_histories.itemcode')->from('gc_product_price_histories');
            })
            ->orderBy('product_id', $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('gc_product_items.itemcode', 'like', '%' . $searchValue . '%')
                    ->orWhere('gc_product_items.product_name', 'like', '%' . $searchValue . '%');
            });
        }

        $final_result = $query->paginate($length);

        return  $final_result;
    }

    public function item_category()
    {
        return DB::table('gc_product_items')
            ->select('category_no', 'category_name', DB::raw('COUNT(category_no) as count'))
            ->orderBy('count', 'desc')
            ->groupBy('category_name')
            ->get();
    }
    public function disabled_selected_item(Request $request)
    {
        $itemcode = $request->ids;
        $count = 0;
        foreach ($itemcode as $key => $code) {
            $checking =  gc_item_log_available::where('itemcode', $code)->where('store', Auth::user()->bunit_code)->exists();

            if ($checking) {
                $count++;
            } else {
                $data = array(
                    'itemcode'       => $code,
                    'store'          => Auth::user()->bunit_code,
                    'tag_by'         => Auth::user()->name,
                );
                gc_item_log_available::insert($data);
            }
        }
        // return $count;
    }

    public function enabled_selected_item(Request $request)
    {
        $itemcode = $request->ids;

        foreach ($itemcode as $key => $code) {
            gc_item_log_available::where('itemcode', $code)->where('store', Auth::user()->bunit_code)->delete();
        }
    }
    public function count_price_changes()
    {
        return DB::table('gc_item_price_changes')
            ->select('*')
            ->join('gc_users', 'gc_item_price_changes.user_id', 'gc_users.id')
            ->where('gc_users.bunit_code', Auth::user()->bunit_code)
            ->whereDate('gc_item_price_changes.created_at', Carbon::today()->toDateString())
            ->count();
    }

    public function change_status_per_store(Request $request)
    {
        if ($request->store) {

            if ($request->status == 0) {

                gc_item_log_available::where('itemcode', $request->itemcode)->where('store', $request->store)->delete();
            } else {

                gc_item_log_available::insert([
                    'itemcode'       => $request->itemcode,
                    'store'          => $request->store,
                    'tag_by'         => Auth::user()->name,
                ]);
            }
        }
    }
}
