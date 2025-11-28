<?php

namespace App\Exports;

use App\Models\Products;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    public function __construct(public $request)
    {
    }

    public function array(): array
    {
        $category_id = $this->request->filter_category_id;
        $active = $this->request->filter_active;
        $created_at = $this->request->filter_created_at;

        $data = Products::orderBy('created_at', 'DESC')
                ->when($category_id != null, function ($query) use($category_id) {
                    $query->where('category_id', $category_id);
                })
                ->when($active != null, function ($query) use($active) {
                    $query->where('active', $active);
                })
                ->when($created_at != null, function ($query) use($created_at) {
                    $created_ranges = explode(' - ', $created_at);
                    $query->where('created_at', '>=', date('Y-m-d H:i:s', strtotime($created_ranges[0].' 00:00:00')));
                    $query->where('created_at', '<=', date('Y-m-d H:i:s', strtotime($created_ranges[1].' 23:59:59')));
                })
                ->with(['hasCategory'])
                ->get();

        foreach ($data as $index => $item) {
            $size_qty = [];
            if($item->size_qty_options){
                $get_size_qty = json_decode($item->size_qty_options);
                
                foreach($get_size_qty as $sq){
                    $size_qty[] = $sq->size.' : '.($sq->qty ? implode(',',$sq->qty) : '');
                }
            }

            $rows[] = [
                ($index + 1),
                ($item->hasCategory ? $item->hasCategory->name : ''),
                $item->name,
                $item->description ? strip_tags($item->description) : '',
                $item->size_qty_options ? implode("\r\n", $size_qty) : '',
                ($item->active) ? 'Active' : 'Not Active',
                ($item->main_product) ? 'Main Product' : '',
            ];
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'No', 'Category', 'Name', 'Description', 'Size Quantity', 'Active', 'Main Product'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Bold header
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);

        // Center header
        $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal('center');

        $lastRow = count($this->array()) + 1;

        // Center kolom
        $sheet->getStyle("A2:A{$lastRow}")
            ->getAlignment()->setHorizontal('center');
        $sheet->getStyle("B2:B{$lastRow}")
            ->getAlignment()->setHorizontal('center');
        $sheet->getStyle("E2:E{$lastRow}")
            ->getAlignment()->setHorizontal('center');
        $sheet->getStyle("F2:F{$lastRow}")
            ->getAlignment()->setHorizontal('center');

        // Border all cells
        $sheet->getStyle("A1:G{$lastRow}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle('thin');

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 15,
            'C' => 30,
            'D' => 70,
            'E' => 50,
            'F' => 20,
            'G' => 20,
        ];
    }
}
