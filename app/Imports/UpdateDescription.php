<?php

namespace App\Imports;

use App\gc_product_item;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UpdateDescription implements ToCollection, WithHeadingRow, WithValidation
{
    use Importable;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            gc_product_item::where('itemcode', intval($row['itemcode']))->update(['product_name' => trim($row['description'])]);
        }
    }
    public function rules(): array
    {
        return [
            'itemcode' => 'required',
            'description' => 'required',

        ];
    }
    public function customValidationMessages()
    {
        return [
            'itemcode.required' => 'The csv file should contain product code',
            'description.required' => 'The csv file should contain product description',

        ];
    }
}
