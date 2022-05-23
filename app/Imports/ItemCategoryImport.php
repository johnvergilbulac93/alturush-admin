<?php

namespace App\Imports;

use App\gc_product_item;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;

class ItemCategoryImport implements ToCollection, WithHeadingRow, WithBatchInserts, WithChunkReading, WithValidation
{
    use Importable;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            gc_product_item::where('itemcode', '=', intval($row['itemcode']))
                ->update([
                    'category_name' => $row['category_name'],
                    'category_no'   => intval($row['category_no']),
                ]);
        }
    }
    public function batchSize(): int
    {
        return 1000;
    }
    public function chunkSize(): int
    {
        return 1000;
    }
    public function rules(): array
    {
        return [
            'itemcode' => 'required',
            'category_name' => 'required',
            'category_no' => 'required',

        ];
    }
    public function customValidationMessages()
    {
        return [
            'itemcode.required' => 'The csv file should contain product code',
            'category_name.required' => 'The csv file should contain product category name',
            'category_no.required' => 'The csv file should contain product category no.',

        ];
    }
}
