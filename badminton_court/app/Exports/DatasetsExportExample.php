<?php

namespace App\Exports;

use App\Models\Dataset;
use Maatwebsite\Excel\Concerns\FromCollection;

class DatasetsExportExample implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect([
            ['FATHAN AZHAR ALVIANO', 'L', '3 Tahun - 4 Bulan - 20 Hari', '13,2', '92'],
            ['DUMA AQELA BERU MENJERANG', 'P', '4 Tahun - 3 Bulan - 15 Hari', '10', '80'],
        ]);
    }
}
