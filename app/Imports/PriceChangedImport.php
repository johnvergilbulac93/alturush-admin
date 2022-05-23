<?php

namespace App\Imports;

use App\gc_product_price;
use App\gc_product_price_history;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithValidation;

class PriceChangedImport implements ToCollection, WithValidation
{
    use Importable;

    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {
            $data_check =  gc_product_price_history::where('itemcode', '=', intval($row[0]))
                ->where('UOM', '=', $row[2])
                ->where('price_group', '=', $row[6])
                ->exists();
            $data_check_price  =  gc_product_price::where('itemcode', '=', intval($row[0]))
                ->where('UOM', '=', $row[2])
                ->where('price_group', '=', $row[6])
                ->exists();
            $price =  gc_product_price::where('itemcode', '=', intval($row[0]))
                ->where('UOM', '=', $row[2])
                ->where('price_group', '=', $row[6])
                ->first();

            if ($data_check_price) {

                if ($data_check) {
                    gc_product_price_history::where('itemcode', intval($row[0]))
                        ->where('UOM', $row[2])
                        ->where('price_group', '=', $row[6])
                        ->update([
                            'prev_price'            =>   floatval(str_replace(',', '', $price->price_with_vat)),
                            'new_price'             =>   floatval(str_replace(',', '', $row[5])),
                            'update_at'             =>   date('Y-m-d H:i:s')
                        ]);
                } else {
                    gc_product_price_history::insert([
                        'prev_price'        =>   floatval(str_replace(',', '', $price->price_with_vat)),
                        'new_price'         =>   floatval(str_replace(',', '', $row[5])),
                        'itemcode'          =>   intval($row[0]),
                        'UOM'               =>   $row[2],
                        'update_at'         =>   date('Y-m-d H:i:s'),
                        'price_group'       =>   $row[6]
                    ]);
                }

                gc_product_price::where('itemcode', '=', intval($row[0]))
                    ->where('UOM', '=', $row[2])
                    ->where('price_group', '=', $row[6])
                    ->update([
                        'price'             =>  floatval(str_replace(',', '', $row[5])),
                        'price_with_vat'    =>  floatval(str_replace(',', '', $row[5])),
                    ]);
            } else {

                gc_product_price::insert([
                    'itemcode'          =>  intval($row[0]),
                    'UOM'               =>  $row[2],
                    'price'             =>  floatval(str_replace(',', '', $row[5])),
                    'price_with_vat'    =>  floatval(str_replace(',', '', $row[5])),
                    'status'            =>  1,
                    'price_group'       =>  $row[6],
                ]);
            }
        }
    }
    public function rules(): array
    {
        return [
            '0' => 'required',
            '2' => 'required',
            '5' => 'required',
            '6' => 'required',
        ];
    }
    public function customValidationMessages()
    {
        return [
            '0.required' => 'The csv file should contain product code',
            '2.required' => 'The csv file should contain product unit of measure',
            '5.required' => 'The csv file should contain product price',
            '6.required' => 'The csv file should contain product price group',
        ];
    }
}
