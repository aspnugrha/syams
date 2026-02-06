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
        $type = $this->request->filter_type;
        $active = $this->request->filter_active;
        $created_at = $this->request->filter_created_at;

        $data = Products::orderBy('main_product', 'desc')->orderBy('created_at', 'DESC')
                ->when($category_id != null, function ($query) use($category_id) {
                    $query->where('category_id', $category_id);
                })
                ->when($type != null, function ($query) use($type) {
                    $query->where('type', $type);
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

        $rows = [];
        foreach ($data as $index => $item) {
            $size_qty = [];
            $material_color = [];
            if($item->size_qty_options){
                $get_size_qty = json_decode($item->size_qty_options);
                
                foreach($get_size_qty as $sq){
                    $size_qty[] = $sq->size.' ('.($sq->qty ? implode(',',$sq->qty) : '').')';
                }
            }
            if($item->material_color_options){
                $get_material_color = json_decode($item->material_color_options);
                
                foreach($get_material_color as $mc){
                    $colors = [];
                    if($mc->colors){
                        foreach($mc->colors as $color){
                            // $colors[] = $color->color.'('.$color->color_code.')';
                            $colors[] = $color->color;
                        } 
                    }
                    $material_color[] = $mc->name.' ('.($colors ? implode(',',$colors) : '').')';
                }
            }

            $rows[] = [
                ($index + 1),
                $item->type,
                ($item->hasCategory ? $item->hasCategory->name : ''),
                $item->name,
                $item->description ? strip_tags($item->description) : '',
                ($item->active) ? 'Active' : 'Not Active',
                ($item->main_product) ? 'Main Product' : '',
                // $item->size_qty_options ? implode("\r\n", $size_qty) : '',
                $item->size_qty_options ? implode("  ", $size_qty) : '',
                $item->material_color_options ? implode("  ", $material_color) : '',
                $item->sablon_type,
                $item->is_bordir ? 'Yes' : 'No',
            ];
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'No', 'Type', 'Category', 'Name', 'Description', 'Active', 'Main Product', 'Size Quantity', 'Material & Color', 'Sablon Type', 'Bordir'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Bold header
        $sheet->getStyle('A1:k1')->getFont()->setBold(true);

        // Center header
        $sheet->getStyle('A1:k1')->getAlignment()->setHorizontal('center');

        $lastRow = count($this->array()) + 1;

        // Center kolom
        $sheet->getStyle("A2:A{$lastRow}")
            ->getAlignment()->setHorizontal('center');
        $sheet->getStyle("B2:B{$lastRow}")
            ->getAlignment()->setHorizontal('center');
        $sheet->getStyle("C2:C{$lastRow}")
            ->getAlignment()->setHorizontal('center');
        $sheet->getStyle("F2:F{$lastRow}")
            ->getAlignment()->setHorizontal('center');
        $sheet->getStyle("G2:G{$lastRow}")
            ->getAlignment()->setHorizontal('center');
        $sheet->getStyle("H2:H{$lastRow}")
            ->getAlignment()->setHorizontal('center');
        $sheet->getStyle("I2:I{$lastRow}")
            ->getAlignment()->setHorizontal('center');
        $sheet->getStyle("J2:J{$lastRow}")
            ->getAlignment()->setHorizontal('center');
        $sheet->getStyle("K2:K{$lastRow}")
            ->getAlignment()->setHorizontal('center');

        // Border all cells
        $sheet->getStyle("A1:K{$lastRow}")
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
            'C' => 15,
            'D' => 30,
            'E' => 70,
            'F' => 20,
            'G' => 20,
            'H' => 100,
            'I' => 100,
            'J' => 100,
            'K' => 15,
        ];
    }
}
