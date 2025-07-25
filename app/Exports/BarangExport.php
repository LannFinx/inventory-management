<?php

namespace App\Exports;

use App\Models\Barang;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class BarangExport implements FromView, WithEvents
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $query = Barang::with(['kategori', 'suppliers']);

        if ($this->request->filled('keyword')) {
            $query->where('nama_barang', 'like', '%' . $this->request->keyword . '%');
        }

        if ($this->request->filled('kategori_id')) {
            $query->where('kategori_id', $this->request->kategori_id);
        }

        if ($this->request->filled('from') && $this->request->filled('to')) {
            $query->whereBetween('created_at', [$this->request->from, $this->request->to]);
        }

        $barangs = $query->get();
        return view('barangs.export_excel', compact('barangs'));
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Set auto width for all columns
                foreach (range('A', 'F') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                // Style header row
                $sheet->getStyle('A1:F1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                        'size' => 12,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'C0392B'], // Merah elegan
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center',
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Style all data rows (dynamic range)
                $highestRow = $sheet->getHighestRow();
                $sheet->getStyle("A2:E$highestRow")->applyFromArray([
                    'font' => [
                        'size' => 11,
                        'color' => ['rgb' => '000000'],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                    'alignment' => [
                        'vertical' => 'center',
                        'wrapText' => true,
                    ],
                ]);
            },
        ];
    }
}
