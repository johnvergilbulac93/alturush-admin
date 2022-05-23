<?php

namespace App\Imports;

use App\gc_product_item;
use App\gc_product_price;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ItemsImport implements ToCollection, WithHeadingRow
{
    use Importable;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            
            $check_price =  gc_product_price::where('itemcode', '=', intval($row['item_code']))
                ->where('UOM', '=', $row['uom'])
                ->where('price_group', '=', $row['price_group'])
                ->exists();

            $check_item =  gc_product_item::where('itemcode', '=', intval($row['item_code']))->exists();

            if ($check_item) {

                gc_product_item::where('itemcode', '=', intval($row['item_code']))->update([
                    'product_name' => $row['description'],
                    'category_name' => $row['category'],
                    'category_no' => intval($row['category_no']),
                    'itemcode' => intval($row['item_code']),
                    'status' => 'active'
                ]);

            } else {

                gc_product_item::insert([
                    'itemcode' => intval($row['item_code']),
                    'product_name' => $row['description'],
                    'category_name' => $row['category'],
                    'category_no' => intval($row['category_no']),
                    'status' => 'active'
                ]);
            }

            if (!$check_price) {
                gc_product_price::insert([
                    'itemcode'        => intval($row['item_code']),
                    'UOM'             => $row['uom'],
                    'price'           => $row['retail'],
                    'price_with_vat'  => $row['retail'],
                    'price_group'     => $row['price_group']
                ]);
            }
        }
    }
}
