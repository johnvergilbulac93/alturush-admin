<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class ItemsExport implements FromCollection, 
ShouldAutoSize,
// WithMapping, 
WithHeadings,
WithColumnFormatting, 
WithEvents
{
    public $filter;

    public function __construct(string $filter)
    {
        $this->filter = $filter;
    }

    public function collection()
    {
        if ($this->filter === 'all') {
            $query =  DB::table('gc_product_items')
                ->join('gc_product_prices', 'gc_product_items.itemcode', '=', 'gc_product_prices.itemcode')
                ->select('gc_product_items.itemcode', 'gc_product_items.product_name', 'gc_product_items.category_name', 'gc_product_items.category_no', 'gc_product_prices.UOM', 'gc_product_prices.price_with_vat')
                ->where('gc_product_items.status', 'active')
                ->get();
        }
        if ($this->filter === 'available') {
            $query =  DB::table('gc_product_items')
                ->join('gc_product_prices', 'gc_product_items.itemcode', '=', 'gc_product_prices.itemcode')
                ->select('gc_product_items.itemcode', 'gc_product_items.product_name', 'gc_product_items.category_name', 'gc_product_items.category_no', 'gc_product_prices.UOM', 'gc_product_prices.price_with_vat')
                ->where('gc_product_items.status', 'active')
                ->whereNotIn('gc_product_items.itemcode', function ($query) {
                    $query->select('gc_item_log_availables.itemcode')->from('gc_item_log_availables')->where('gc_item_log_availables.store', '=', Auth::user()->bunit_code);
                })->get();
        }
        if ($this->filter === 'unavailable') {

            $query =  DB::table('gc_product_items')
                ->join('gc_product_prices', 'gc_product_items.itemcode', '=', 'gc_product_prices.itemcode')
                ->select('gc_product_items.itemcode', 'gc_product_items.product_name', 'gc_product_items.category_name', 'gc_product_items.category_no', 'gc_product_prices.UOM', 'gc_product_prices.price_with_vat')
                ->whereIn('gc_product_items.itemcode', function ($query) {
                    $query->select('gc_item_log_availables.itemcode')->from('gc_item_log_availables')->where('gc_item_log_availables.store', '=', Auth::user()->bunit_code);
                })->get();
        }

        return $query;
    }

    // public function map($items): array
    // {
    //     return [
    //         $items->itemcode,
    //         $items->product_name,
    //         $items->category_name,
    //         $items->category_no,
    //         $items->UOM,
    //         $items->price_with_vat,
    //     ];
    // }

    public function headings(): array
    {
        return [
            'ITEMCODE',
            'DESCRIPTION',
            'CATEGORY NAME',
            'CATEGORY NO',
            'UNIT OF MEASURE',
            'RETAIL'
        ];
    }
    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2,
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:F1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size'      =>  12
                    ],

                ]);
            },
        ];
    }
}
