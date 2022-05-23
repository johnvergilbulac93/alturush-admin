<?php

namespace App\Http\Controllers\Masterfile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GlobalCategoriesController extends Controller
{
    public function show_global_categories(Request $request)
    {
        $length = $request->length;
        $dir = $request->dir;
        $searchValue = $request->search;

        $query = DB::table('global_categories')->orderBy('global_categories.id', $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('global_categories.category', 'like', '%' . $searchValue . '%');
            });
        }

        $finalResults = $query->paginate($length);

        return $finalResults;
    }
    public function create_global_categories(Request $request)
    {
        $this->validate($request, [
            'category'      => ['required', 'unique:global_categories,category'],
        ], [
            'category.required' => 'Category name must not be empty.'
        ]);

        $save = DB::table('global_categories')->insert([
            'category'               => $request->category,
            'created_at'             => date('Y-m-d H:i:s'),
            'updated_at'             => date('Y-m-d H:i:s'),
        ]);
        if ($save) {
            return ['msg' => 'Successfully saved.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function update_global_categories(Request $request)
    {
        $this->validate($request, [
            'category'      => ['required'],
        ], [
            'category.required' => 'Category name must not be empty.'
        ]);

        $save = DB::table('global_categories')->where('global_categories.id', $request->id)->update([
            'category'              => $request->category,
            'updated_at'             => date('Y-m-d H:i:s'),
        ]);

        if ($save) {
            return ['msg' => 'Successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
    public function change_status(Request $request)
    {
        if ($request->type === 'delivery') {
            if ($request->status == 1) {
                $data = [
                    'delivery'  => 0
                ];
            } else {
                $data = [
                    'delivery'  => 1
                ];
            }
        }
        if ($request->type === 'pickup') {
            if ($request->status == 1) {
                $data = [
                    'pick_up'  => 0
                ];
            } else {
                $data = [
                    'pick_up'  => 1
                ];
            }
        }
        if ($request->type === 'status') {
            if ($request->status == 1) {
                $data = [
                    'status'  => 0
                ];
            } else {
                $data = [
                    'status'  => 1
                ];
            }
        }
        $save = DB::table('global_categories')->where('global_categories.id', $request->id)->update($data);
        if ($save) {
            return ['msg' => 'Status successfully updated.', 'status' => 'success', 'title' => 'Success'];
        } else {
            return ['msg' => 'Oops. something went wrong.', 'status' => 'error', 'title' => 'Oops'];
        }
    }
}
