<?php

namespace App\Exports;

use App\Models\Cluster;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ResultExportPdf implements FromView, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $data           = request()->session()->get('results');
        $endOfIteration = end($data['iterationStep']);
        $collection     = collect();
        $clusters       = Cluster::all();
        foreach ($data['datasets'] as $index => $d) {
            $collection->push([
                'nama'          => $d['name'],
                'jenis_kelamin' => ($d['gender'] == 'L' ? 'Laki - Laki' : 'Perempuan'),
                'usia'          => daysToYearMonthDay($d['age']),
                'berat_badan'   => $d['weight'],
                'tinggi_badan'  => $d['height'],
                'kategori_gizi' => $clusters->where('id', $endOfIteration['centroid'][$index])->first()->name
            ]);
        }
        return view('admin.calculate.export_pdf', ['data' => $collection]);
    }
}
