<?php

namespace App\Exports;

use App\Models\FieldBooking;
use DateTime;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class FieldBookingExport implements FromQuery, WithHeadings, WithMapping, WithTitle, WithEvents, ShouldAutoSize,WithColumnFormatting,WithCustomStartCell
{
    private $startDate;
    private $endDate;
    private $no = 0;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function startCell(): string
    {
        return 'A4';
    }

    public function query()
    {
        return FieldBooking::with('field.fieldLocation.user', 'user', 'field')
            ->whereBetween('date', [$this->startDate, $this->endDate]);
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Nama Pemesan',
            'Nama Lapangan',
            'Lokasi',
            'Waktu',
            'Durasi',
            'Status',
            'Total Bayar',
            'Nama Pengelola',
        ];
    }

    public function map($fieldBooking): array
    {
        $jam = $fieldBooking->start_time . ' - ' . $fieldBooking->end_time;
        $start_time = new DateTime($fieldBooking->start_time);
        $end_time = new DateTime($fieldBooking->end_time);
        $diff = $start_time->diff($end_time);
        $total_jam = $diff->h;
        $biaya = $total_jam * $fieldBooking->field->price;
        //nomor urut
        $this->no++;
        return [
            $this->no,
            $fieldBooking->date,
            $fieldBooking->user->name,
            $fieldBooking->field->name,
            $fieldBooking->field->fieldLocation->name,
            $jam,
            $total_jam . ' Jam',
            $fieldBooking->status,
            $biaya,
            $fieldBooking->field->fieldLocation->user->name,
        ];
    }

    public function title(): string
    {
        return 'Laporan Penyewaan Lapangan';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                // Merge cells untuk judul
                $sheet->mergeCells('A1:J1');
                //text center
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
                $sheet->mergeCells('A2:J2');
                //text center
                $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');

                // Set judul dan periode
                $sheet->setCellValue('A1', 'Laporan Penyewaan Lapangan');
                $sheet->setCellValue('A2', 'Periode ' . $this->startDate . ' - ' . $this->endDate);

                // Set style untuk judul
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(12);

                // Berikan ruang kosong sebelum header kolom
                $sheet->insertNewRowBefore(3, 1);

                //format header
                $sheet->getStyle('A5:J5')->getFont()->setBold(true);
                $sheet->getStyle('A5:J5')->getAlignment()->setHorizontal('center');
                //warna hijau
                $sheet->getStyle('A5:J5')->getFill()->setFillType('solid')->getStartColor()->setARGB('FF00FF00');

                //border semua cell
                $sheet->getStyle('A5:J5')->getBorders()->getAllBorders()->setBorderStyle('thin');
                $sheet->getStyle('A6:J' . ($this->no + 5))->getBorders()->getAllBorders()->setBorderStyle('thin');

            },
        ];
    }

    public function columnFormats(): array
    {
        return [
            //biaya format rupiah
            'I' => '"Rp "#,##0',
        ];
    }
}
