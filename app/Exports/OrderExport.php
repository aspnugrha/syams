<?php

namespace App\Exports;

use App\Models\Orders;
use App\Models\Products;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use function PHPSTORM_META\map;

class OrderExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    public function __construct(public $request)
    {
    }

    public function array(): array
    {
        $order_type = $this->request->filter_order_type;
        $customer_id = $this->request->filter_customer_id;
        $status = $this->request->filter_status;
        $order_date = $this->request->filter_order_date;
        $created_at = $this->request->filter_created_at;

        $data = Orders::orderBy('created_at', 'DESC')
                ->when($order_type != null, function ($query) use($order_type) {
                    $query->where('order_type', $order_type);
                })
                ->when($customer_id != null, function ($query) use($customer_id) {
                    $query->where('customer_id', $customer_id);
                })
                ->when($status != null, function ($query) use($status) {
                    $query->where('status', $status);
                })
                ->when($order_date != null, function ($query) use($order_date) {
                    $ranges = explode(' - ', $order_date);
                    $query->where('order_date', '>=', date('Y-m-d H:i:s', strtotime($ranges[0].' 00:00:00')));
                    $query->where('order_date', '<=', date('Y-m-d H:i:s', strtotime($ranges[1].' 23:59:59')));
                })
                ->when($created_at != null, function ($query) use($created_at) {
                    $created_ranges = explode(' - ', $created_at);
                    $query->where('created_at', '>=', date('Y-m-d H:i:s', strtotime($created_ranges[0].' 00:00:00')));
                    $query->where('created_at', '<=', date('Y-m-d H:i:s', strtotime($created_ranges[1].' 23:59:59')));
                })
                ->with(['details'])
                ->get();

        $rows = [];
        foreach ($data as $index => $item) {
            $rows[] = [
                ($index + 1),
                $item->order_number,
                $item->customer_name,
                $item->customer_email,
                $item->customer_phone_number,
                $item->order_date ? date('d F Y H:i:s', strtotime($item->order_date)) : '',
                $item->details ? count($item->details).' product' : '',
                $item->notes,
                $item->order_type,
                $item->status,
            ];

            if($item->details){
                foreach($item->details as $detail){
                    $sizes = explode(',',$detail->size_selected);
                    $qtys = json_decode($detail->qty_selected);

                    // dd($detail, $sizes, $qtys);

                    $data_size_qty = [];
                    foreach($sizes as $size){
                        $data_size_qty[] = $size.' ('.$qtys->$size.' pcs)';
                    }

                    $rows[] = [
                        '',
                        $detail->product_category,
                        $detail->product_name,
                        $data_size_qty ? implode(', ', $data_size_qty) : '',
                        $detail->notes ?? '',
                    ];
                }
            }
        }

        // dd($rows);

        return $rows;
    }

    public function headings(): array
    {
        return [
            'No', 'Order Number', 'Customer Name', 'Customer Email', 'Customer Phone Number', 'Order Date', 'Total Product', 'Notes', 'Type', 'Status'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Bold header
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);

        // Center header
        $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal('center');

        $lastRow = count($this->array()) + 1;

        // Center kolom
        $sheet->getStyle("A2:A{$lastRow}")
            ->getAlignment()->setHorizontal('center');
        $sheet->getStyle("B2:B{$lastRow}")
            ->getAlignment()->setHorizontal('center');
        $sheet->getStyle("C2:C{$lastRow}")
            ->getAlignment()->setHorizontal('left');
        $sheet->getStyle("D2:D{$lastRow}")
            ->getAlignment()->setHorizontal('left');
        $sheet->getStyle("E2:E{$lastRow}")
            ->getAlignment()->setHorizontal('center');
        $sheet->getStyle("F2:F{$lastRow}")
            ->getAlignment()->setHorizontal('center');
        $sheet->getStyle("G2:G{$lastRow}")
            ->getAlignment()->setHorizontal('center');
        $sheet->getStyle("I2:I{$lastRow}")
            ->getAlignment()->setHorizontal('center');
        $sheet->getStyle("J2:J{$lastRow}")
            ->getAlignment()->setHorizontal('center');

        // Border all cells
        $sheet->getStyle("A1:J{$lastRow}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle('thin');

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 30,
            'C' => 30,
            'D' => 30,
            'E' => 30,
            'F' => 30,
            'G' => 15,
            'H' => 30,
            'I' => 15,
            'J' => 15,
        ];
    }
}
