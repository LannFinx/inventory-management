<?php

namespace App\Exports;

use App\Models\Barang;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class BarangExport implements FromView, WithEvents, WithColumnFormatting, WithColumnWidths
{
    protected $request;
    protected $barangs;

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

        $this->barangs = $query->get(); // disimpan untuk digunakan di drawings
        return view('barangs.export_excel', ['barangs' => $this->barangs]);
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_DATE_YYYYMMDD,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 25,
            'C' => 25,
            'D' => 25,
            'E' => 25,
            'F' => 25,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Judul
                $sheet->mergeCells('A1:F1');
                $sheet->setCellValue('A1', 'LAPORAN DATA BARANG');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'd63031']],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Header
                $sheet->getStyle('A2:F2')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF3E4D']],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                ]);

                // Data isi
                $highestRow = $sheet->getHighestRow();
                $sheet->getStyle("A3:F{$highestRow}")->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                    'font' => ['size' => 11],
                ]);

                // Footer Tanggal Cetak
                $footerRow = $highestRow + 2;
                $sheet->mergeCells("A{$footerRow}:F{$footerRow}");
                $sheet->setCellValue("A{$footerRow}", 'Tanggal Cetak: ' . now()->translatedFormat('d F Y'));
                $sheet->getStyle("A{$footerRow}")->applyFromArray([
                    'font' => ['italic' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
                ]);
            },
        ];
    }
}
