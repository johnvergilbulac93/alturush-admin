<?php

namespace App\Imports;

use App\gc_product_item;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FilenameImport implements ToCollection, WithChunkReading, WithValidation, WithHeadingRow
{
    use Importable;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if ($row->filter()->isNotEmpty()) {
                gc_product_item::where('itemcode', '=', intval($row['itemcode']))->update([
                    'image' =>   $row['filename']
                ]);
            }
        }
    }
    public function rules(): array
    {
        return [
            'itemcode' => 'required',
            'filename' => 'required',
        ];
    }
    public function customValidationMessages()
    {
        return [
            'filename.required' => 'The csv file should contain product image filename',
            'itemcode.required' => 'The csv file should contain product code',
        ];
    }
    public function chunkSize(): int
    {
        return 1000;
    }
}
