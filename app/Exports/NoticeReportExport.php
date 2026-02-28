<?php

namespace App\Exports;

use App\Models\Event;
use App\Models\NoticeReport;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NoticeReportExport implements
    FromQuery,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithTitle,
    WithColumnWidths,
    WithEvents
{
    public function __construct(
        protected Event $event
    ) {}

    public function query(): Builder
    {
        return NoticeReport::query()
            ->where('event_id', $this->event->id)
            ->orderBy('created_at', 'asc')
            ->select(['id', 'event_id', 'nama', 'nip', 'unit_kerja', 'created_at']);
    }

    public function title(): string
    {
        return 'Rekap Pelaporan ASN';
    }

    public function headings(): array
    {
        $totalLapor  = $this->event->noticeReports()->count();
        $totalTarget = (int) $this->event->total_target_asn;
        $deadline    = $this->event->event_data['deadline'] ?? '-';

        return [
            ['Rekap Pelaporan ASN — ' . ($this->event->title ?? '')],
            ['Tanggal Berlaku: ' . ($this->event->event_date ? $this->event->event_date->translatedFormat('d F Y') : '-')],
            ['Batas Waktu: ' . $deadline . '   |   Sudah Melapor: ' . $totalLapor . ' dari ' . ($totalTarget > 0 ? $totalTarget : '?') . ' ASN'],
            [''],
            ['No', 'Nama Lengkap', 'NIP', 'Unit Kerja', 'Tanggal Input'],
        ];
    }

    public function map($report): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        return [
            $rowNumber,
            $report->nama,
            $report->nip,
            $report->unit_kerja,
            $report->created_at ? $report->created_at->format('d/m/Y H:i') : '-',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 35,
            'C' => 22,
            'D' => 35,
            'E' => 20,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 13],
            ],
            2 => [
                'font' => ['bold' => false, 'size' => 11],
            ],
            3 => [
                'font' => ['bold' => false, 'size' => 11],
            ],
            5 => [
                'font'      => ['bold' => true, 'size' => 11],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFD6E4F7']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet      = $event->sheet->getDelegate();
                $lastRow    = $sheet->getHighestRow();
                $lastColumn = 'E';

                // Merge summary rows
                $sheet->mergeCells('A1:E1');
                $sheet->mergeCells('A2:E2');
                $sheet->mergeCells('A3:E3');

                $sheet->getStyle('A1:E3')->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT)
                    ->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getRowDimension(1)->setRowHeight(22);
                $sheet->getRowDimension(2)->setRowHeight(18);
                $sheet->getRowDimension(3)->setRowHeight(18);
                $sheet->getRowDimension(4)->setRowHeight(10);

                // Border + freeze
                if ($lastRow >= 5) {
                    $tableRange = 'A5:' . $lastColumn . $lastRow;
                    $sheet->getStyle($tableRange)->getBorders()->getAllBorders()
                        ->setBorderStyle(Border::BORDER_THIN);
                    $sheet->freezePane('A6');

                    // Center: No (A) dan Tanggal (E)
                    $sheet->getStyle('A5:A' . $lastRow)->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('E5:E' . $lastRow)->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                    // Wrap text nama + unit kerja
                    $sheet->getStyle('B5:B' . $lastRow)->getAlignment()->setWrapText(true);
                    $sheet->getStyle('D5:D' . $lastRow)->getAlignment()->setWrapText(true);
                }
            },
        ];
    }
}
