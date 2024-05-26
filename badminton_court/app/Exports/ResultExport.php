<?php

namespace App\Exports;

use App\Models\Cluster;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ResultExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data           = request()->session()->get('results');
        $endOfIteration = end($data['iterationStep']);
        $collection     = collect();
        $clusters       = Cluster::all();
        foreach ($data['datasets'] as $index => $d) {
            $collection->push([
                'no'            => $index + 1,
                'nama'          => $d['name'],
                'jenis_kelamin' => ($d['gender'] == 'L' ? 'Laki - Laki' : 'Perempuan'),
                'usia'          => daysToYearMonthDay($d['age']),
                'berat_badan'   => $d['weight'],
                'tinggi_badan'  => $d['height'],
                'kategori_gizi' => $clusters->where('id', $endOfIteration['centroid'][$index])->first()->name
            ]);
        }
        return $collection;
    }

    public function headings(): array
    {
        return ["No", "Nama", 'Jenis Kelamin', 'Usia', 'Berat Badan', 'Tinggi Badan', 'Kategori Gizi'];
    }

    public function styles(Worksheet $sheet)
    {
        $borderStyle = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'], // Warna border (hitam)
                ],
            ],
        ];

        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();

        for ($row = 1; $row <= $lastRow; $row++) {
            $sheet->getStyle('A' . $row . ':' . $lastColumn . $row)->applyFromArray($borderStyle);
        }

        // Atur border untuk seluruh kolom
        for ($column = 'A'; $column <= $lastColumn; $column++) {
            $sheet->getStyle($column . '1:' . $column . $lastRow)->applyFromArray($borderStyle);
        }
    }
}
