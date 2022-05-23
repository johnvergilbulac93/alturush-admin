<?php

namespace App\Http\Controllers\API;


use App\Imports\ItemsImport;
use Illuminate\Http\Request;
use App\gc_item_log_available;
use App\gc_product_item;
use App\Imports\FilenameImport;
use App\Imports\ItemCategoryImport;
use App\Imports\PriceChangedImport;
use App\Imports\PriceHistoryImport;
use App\Http\Controllers\Controller;
use App\Imports\ChangePriceImport;
use App\Imports\UpdateDescription;
use Illuminate\Support\Facades\Auth;

class UploadingController extends Controller
{

    public function uploaditem(Request $request)
    {
        $upload = (new ItemsImport)->import($request->file('file_item'));
        if ($upload) {
            return ['msg' => 'Upload successfully complete.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function uploadprice(Request $request)
    {
        // (new PriceHistoryImport)->import($request->file('file_price'));
        $upload = (new PriceChangedImport)->import($request->file('file_price'));
        if ($upload) {
            return ['msg' => 'Upload successfully complete.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function uploadItemDisable(Request $request)
    {
        $this->validate($request, [
            'file_item' => 'required|mimes:csv,txt'
        ]);
        $file = file($request->file('file_item')->getRealPath());
        $remove_header = array_slice($file, 1);
        $data =  array_map('str_getcsv', $remove_header);

        foreach ($data as $row) {

            $check = gc_item_log_available::where('itemcode', '=', intval($row[0]))->where('store', '=', Auth::user()->bunit_code)->exists();

            if ($check) {

                gc_item_log_available::where('itemcode', '=', intval($row[0]))
                    ->where('store', '=', Auth::user()->bunit_code)
                    ->delete();
            } else {
                gc_item_log_available::insert([
                    'itemcode'      => intval($row[0]),
                    'store'           => Auth::user()->bunit_code,
                    'tag_by'          => Auth::user()->name,
                ]);
            }
        }

        return 'success';
    }
    public function item_description(Request $request)
    {
        $upload = (new UpdateDescription)->import($request->file('file_description'));

        if ($upload) {
            return ['msg' => 'Upload complete.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }

    public function uploadcategory(Request $request)
    {

        $upload =  (new ItemCategoryImport)->import($request->file('file_category'));

        if ($upload) {
            return ['msg' => 'Upload complete.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }

    public function uploaditemfilename(Request $request)
    {
        $upload = (new FilenameImport)->import($request->file('image_filename'));
        if ($upload) {
            return ['msg' => 'Upload complete.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function multipleImage(Request $request)
    {
        $this->validate($request, ['file' => 'image|mimes:jpeg,png,jpg,gif,svg']);
        $imageName = $request->file->getClientOriginalName();
        $path = public_path() . '/ITEM-IMAGES/';
        // $path = '../admins.alturush.com/ITEM-IMAGES/';
        // $path2 = 'https://admins.alturush.com/ITEM-IMAGES/'; 
        if (file_exists($path . $imageName)) {
            @unlink($path . $imageName);
        }
        $request->file->move($path, $imageName);
        $url = "/ITEM-IMAGES/" . $imageName;
        return $url;
    }
}
