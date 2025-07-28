<?php

namespace App\Exports;

use App\Models\Barang;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class BarangExport implements FromView, WithEvents, WithColumnFormatting, WithColumnWidths
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

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_DATE_YYYYMMDD,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 55,
            'B' => 45,
            'C' => 45,
            'D' => 45,
            'F' => 45,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Judul Laporan
                $sheet->mergeCells('A1:F1');
                $sheet->setCellValue('A1', 'LAPORAN DATA BARANG');
                $sheet->getDefaultRowDimension()->setRowHeight(-1); // auto height
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'FFFFFF']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Header Kolom (Baris ke-2)
                $sheet->getStyle('A2:F2')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FF5733']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                ]);

                // Data Table (mulai dari baris ke-3)
                $highestRow = $sheet->getHighestRow();
                $highestCol = $sheet->getHighestColumn();

                $sheet->getStyle("A3:{$highestCol}{$highestRow}")->applyFromArray([
                    'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                    'font' => ['size' => 11],
                ]);

                // Wrap text untuk kolom Supplier & Harga Beli (kolom D dan E)
                foreach (range(3, $highestRow) as $row) {
                    $sheet->getStyle("D{$row}:E{$row}")->getAlignment()->setWrapText(true);
                }

                // Tanggal Cetak
                $footerRow = $highestRow + 2;
                $sheet->mergeCells("A{$footerRow}:F{$footerRow}");
                $sheet->setCellValue("A{$footerRow}", 'Tanggal Cetak: ' . now()->translatedFormat('d F Y'));
                $sheet->getStyle("A{$footerRow}")->applyFromArray([
                    'font' => ['italic' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
                ]);

                // Auto-size kolom A sampai F
                foreach (range('A', 'F') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}
