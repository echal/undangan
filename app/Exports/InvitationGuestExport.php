<?php

namespace App\Exports;

use App\Models\Event;
use App\Models\Guest;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Database\Eloquent\Builder;

class InvitationGuestExport implements
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
        return Guest::query()
            ->where('event_id', $this->event->id)
            ->where('rsvp_status', 'hadir')
            ->orderBy('created_at', 'asc')
            ->select(['id', 'event_id', 'name', 'phone', 'rsvp_status', 'created_at']);
    }

    public function title(): string
    {
        return 'Rekap Tamu Hadir';
    }

    public function headings(): array
    {
        return [
            ['Rekap Tamu Hadir — ' . ($this->event->title ?? '')],
            ['Tanggal Acara: ' . ($this->event->event_date ? $this->event->event_date->translatedFormat('d F Y') : '-')],
            ['Total Hadir: ' . $this->event->guests()->where('rsvp_status', 'hadir')->count() . ' orang'],
            [''],
            ['No', 'Nama Tamu', 'No. HP', 'Tanggal Konfirmasi'],
        ];
    }

    public function map($guest): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        return [
            $rowNumber,
            $guest->name,
            $guest->phone ?? '-',
            $guest->created_at ? $guest->created_at->format('d/m/Y H:i') : '-',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 35,
            'C' => 20,
            'D' => 22,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        // Baris 1-3: summary (bold)
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 13],
            ],
            2 => [
                'font' => ['bold' => false, 'size' => 11],
                'font.color' => ['argb' => 'FF555555'],
            ],
            3 => [
                'font' => ['bold' => false, 'size' => 11],
                'font.color' => ['argb' => 'FF555555'],
            ],
            // Baris 5: header tabel
            5 => [
                'font'      => ['bold' => true, 'size' => 11],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFE8EDFC']],
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
                $lastColumn = 'D';

                // Merge cells baris 1-3 (title & summary)
                $sheet->mergeCells('A1:D1');
                $sheet->mergeCells('A2:D2');
                $sheet->mergeCells('A3:D3');

                // Alignment untuk summary rows
                $sheet->getStyle('A1:D3')->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT)
                    ->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getRowDimension(1)->setRowHeight(22);
                $sheet->getRowDimension(2)->setRowHeight(18);
                $sheet->getRowDimension(3)->setRowHeight(18);
                $sheet->getRowDimension(4)->setRowHeight(10); // baris kosong

                // Border pada tabel data (baris 5 ke bawah)
                if ($lastRow >= 5) {
                    $tableRange = 'A5:' . $lastColumn . $lastRow;

                    $sheet->getStyle($tableRange)->getBorders()->getAllBorders()->setBorderStyle(
                        Border::BORDER_THIN
                    );

                    // Freeze pane agar header tidak scroll
                    $sheet->freezePane('A6');

                    // Alignment kolom No (A) center
                    $sheet->getStyle('A5:A' . $lastRow)
                        ->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                    // Alignment tanggal (D) center
                    $sheet->getStyle('D5:D' . $lastRow)
                        ->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }

                // Wrap text nama tamu yang panjang
                $sheet->getStyle('B5:B' . $lastRow)->getAlignment()->setWrapText(true);
            },
        ];
    }
}
