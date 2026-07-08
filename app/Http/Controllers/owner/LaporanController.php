<?php

namespace App\Http\Controllers\owner;

use App\Http\Controllers\Controller;
use App\Models\Produksi;
use App\Models\Penjualan;
use App\Models\Kesehatan;
use App\Models\Sapi;
use App\Models\Mitra;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Dynamic cows statistics for Laporan page cards
        $totalSapi = Sapi::count();
        $sapiSehat = Sapi::where('status', 'normal')->count();
        $persenSehat = $totalSapi > 0 ? round(($sapiSehat / $totalSapi) * 100) : 0;

        // Stat cards: Total volume and sales in current month
        $produksiSusuBulanIni = (float) Produksi::whereMonth('tanggal', $today->month)
            ->whereYear('tanggal', $today->year)
            ->where('status', 'Tersimpan')
            ->sum('jumlah_susu');

        $totalPenjualanBulanIni = (float) Penjualan::whereMonth('tanggal', $today->month)
            ->whereYear('tanggal', $today->year)
            ->sum('total_pendapatan');

        // Fetch dynamic mitras
        $mitras = Mitra::all();

        // Merged daily logs for the last 30 days
        $dates = [];
        for ($i = 0; $i < 30; $i++) {
            $date = Carbon::today()->subDays($i);
            
            $prodVol = (float) Produksi::whereDate('tanggal', $date)
                ->where('status', 'Tersimpan')
                ->sum('jumlah_susu');

            $saleVal = (float) Penjualan::whereDate('tanggal', $date)
                ->sum('total_pendapatan');

            $firstSale = Penjualan::with('mitra')->whereDate('tanggal', $date)->first();
            $mitra = $firstSale && $firstSale->mitra ? $firstSale->mitra->nama : '—';

            $healthCount = Kesehatan::whereDate('created_at', $date)
                ->where('status', 'Perlu Pemantauan')
                ->count();

            $healthNote = 'Normal';
            $status = 'Normal';
            if ($healthCount > 0) {
                $healthNote = $healthCount . ' Sapi Pantau';
                $status = 'Perlu Pantau';
            }

            // Only include in the report list if there's any record / action on that day
            if ($prodVol > 0 || $saleVal > 0 || $healthCount > 0) {
                $dates[] = [
                    'tanggal' => $date->locale('id')->isoFormat('D MMMM YYYY'),
                    'produksi' => $prodVol,
                    'penjualan' => $saleVal,
                    'mitra' => $mitra,
                    'catatan' => $healthNote,
                    'status' => $status
                ];
            }
        }

        $penjualans = Penjualan::with('mitra')->get();
        $produksis = Produksi::with('sapi')->where('status', 'Tersimpan')->get();

        return view('owner.laporan.index', compact(
            'totalSapi',
            'sapiSehat',
            'persenSehat',
            'produksiSusuBulanIni',
            'totalPenjualanBulanIni',
            'mitras',
            'dates',
            'penjualans',
            'produksis'
        ));
    }

    public function export(Request $request)
    {
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : null;
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : null;
        $reportType = $request->input('report_type', 'Semua Data');
        $partnerName = $request->input('partner', 'Semua Mitra');

        // 1. Fetch filtered Penjualan
        $penjualanQuery = Penjualan::with('mitra');
        if ($startDate) {
            $penjualanQuery->where('tanggal', '>=', $startDate->toDateString());
        }
        if ($endDate) {
            $penjualanQuery->where('tanggal', '<=', $endDate->toDateString());
        }
        if ($partnerName !== 'Semua Mitra') {
            $penjualanQuery->whereHas('mitra', function ($q) use ($partnerName) {
                $q->where('nama', $partnerName);
            });
        }
        $penjualans = ($reportType === 'Produksi Susu') ? collect() : $penjualanQuery->orderBy('tanggal', 'desc')->get();

        // 2. Fetch filtered Produksi
        $produksiQuery = Produksi::with('sapi')->where('status', 'Tersimpan');
        if ($startDate) {
            $produksiQuery->where('tanggal', '>=', $startDate->toDateString());
        }
        if ($endDate) {
            $produksiQuery->where('tanggal', '<=', $endDate->toDateString());
        }
        if ($partnerName !== 'Semua Mitra') {
            $allowedDates = Penjualan::whereHas('mitra', function($q) use ($partnerName) {
                    $q->where('nama', $partnerName);
                });
            if ($startDate) $allowedDates->where('tanggal', '>=', $startDate->toDateString());
            if ($endDate) $allowedDates->where('tanggal', '<=', $endDate->toDateString());
            $allowedDates = $allowedDates->pluck('tanggal')->unique()->toArray();
            
            $produksiQuery->whereIn('tanggal', $allowedDates);
        }
        $produksis = ($reportType === 'Penjualan Susu') ? collect() : $produksiQuery->orderBy('tanggal', 'desc')->get();

        // Create Spreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Peternakan');
        
        // Enable gridlines
        $sheet->setShowGridlines(true);

        // Styling templates
        $titleStyle = [
            'font' => [
                'name' => 'Segoe UI',
                'size' => 16,
                'bold' => true,
                'color' => ['rgb' => '124827']
            ]
        ];
        
        $metaStyle = [
            'font' => [
                'name' => 'Segoe UI',
                'size' => 10,
                'bold' => false,
                'color' => ['rgb' => '4B5563']
            ]
        ];

        $sectionHeaderStyle = [
            'font' => [
                'name' => 'Segoe UI',
                'size' => 12,
                'bold' => true,
                'color' => ['rgb' => '124827']
            ]
        ];

        $tableHeaderStyle = [
            'font' => [
                'name' => 'Segoe UI',
                'size' => 10,
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '124827']
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ];

        $dataStyle = [
            'font' => [
                'name' => 'Segoe UI',
                'size' => 10
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'E5E7EB']
                ]
            ]
        ];

        $totalStyle = [
            'font' => [
                'name' => 'Segoe UI',
                'size' => 10,
                'bold' => true
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'F3F4F6']
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'D1D5DB']
                ]
            ]
        ];

        // 1. Write Header Info
        $sheet->setCellValue('A1', 'LAPORAN PETERNAKAN - PARMAN FARM');
        $sheet->getStyle('A1')->applyFromArray($titleStyle);

        $periodStr = 'Periode: ' . ($startDate ? $startDate->locale('id')->isoFormat('D MMMM YYYY') : 'Awal') . ' s/d ' . ($endDate ? $endDate->locale('id')->isoFormat('D MMMM YYYY') : 'Akhir');
        $sheet->setCellValue('A2', $periodStr);
        $sheet->getStyle('A2')->applyFromArray($metaStyle);

        $filterStr = 'Tipe Laporan: ' . $reportType . ' | Mitra: ' . $partnerName;
        $sheet->setCellValue('A3', $filterStr);
        $sheet->getStyle('A3')->applyFromArray($metaStyle);        $rowNum = 5;

        // --- SECTION A: PENJUALAN ---
        if ($reportType === 'Penjualan Susu' || $reportType === 'Semua Data') {
            $sheet->setCellValue('A' . $rowNum, 'A. PENJUALAN');
            $sheet->getStyle('A' . $rowNum)->applyFromArray($sectionHeaderStyle);
            $rowNum++;

            // Table Header
            $headersPenjualan = ['Tanggal', 'Pembeli', 'Jumlah Liter Terjual', 'Harga/Liter', 'Total Harga'];
            foreach ($headersPenjualan as $colIdx => $header) {
                $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx + 1);
                $sheet->setCellValue($colLetter . $rowNum, $header);
                $sheet->getStyle($colLetter . $rowNum)->applyFromArray($tableHeaderStyle);
            }
            $sheet->getRowDimension($rowNum)->setRowHeight(26);
            $startPenjualanRow = $rowNum + 1;
            $rowNum++;

            // Data Rows
            if ($penjualans->isEmpty()) {
                $sheet->setCellValue('A' . $rowNum, 'Tidak ada data penjualan.');
                $sheet->mergeCells('A' . $rowNum . ':E' . $rowNum);
                $sheet->getStyle('A' . $rowNum . ':E' . $rowNum)->applyFromArray($dataStyle);
                $sheet->getStyle('A' . $rowNum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $rowNum++;
            } else {
                foreach ($penjualans as $p) {
                    $friendlyDate = Carbon::parse($p->tanggal)->locale('id')->isoFormat('D MMMM YYYY');
                    $sheet->setCellValue('A' . $rowNum, $friendlyDate);
                    $sheet->setCellValue('B' . $rowNum, $p->mitra ? $p->mitra->nama : '—');
                    $sheet->setCellValue('C' . $rowNum, (float)$p->jumlah_terjual);
                    
                    // Formulas for Harga/Liter and Total Harga
                    // D: Harga/Liter = Total Harga / Jumlah Liter Terjual
                    $sheet->setCellValue('D' . $rowNum, '=IF(C' . $rowNum . '>0, E' . $rowNum . '/C' . $rowNum . ', 0)');
                    $sheet->setCellValue('E' . $rowNum, (float)$p->total_pendapatan);

                    // Number formatting
                    $sheet->getStyle('C' . $rowNum)->getNumberFormat()->setFormatCode('#,##0');
                    $sheet->getStyle('D' . $rowNum)->getNumberFormat()->setFormatCode('Rp #,##0');
                    $sheet->getStyle('E' . $rowNum)->getNumberFormat()->setFormatCode('Rp #,##0');

                    // Alignments
                    $sheet->getStyle('A' . $rowNum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('C' . $rowNum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle('D' . $rowNum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle('E' . $rowNum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                    $sheet->getStyle('A' . $rowNum . ':E' . $rowNum)->applyFromArray($dataStyle);
                    $rowNum++;
                }

                // Total Row
                $sheet->setCellValue('A' . $rowNum, 'Total');
                $sheet->mergeCells('A' . $rowNum . ':B' . $rowNum);
                $sheet->setCellValue('C' . $rowNum, '=SUM(C' . $startPenjualanRow . ':C' . ($rowNum - 1) . ')');
                $sheet->setCellValue('E' . $rowNum, '=SUM(E' . $startPenjualanRow . ':E' . ($rowNum - 1) . ')');

                $sheet->getStyle('C' . $rowNum)->getNumberFormat()->setFormatCode('#,##0');
                $sheet->getStyle('E' . $rowNum)->getNumberFormat()->setFormatCode('Rp #,##0');

                $sheet->getStyle('A' . $rowNum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('C' . $rowNum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle('E' . $rowNum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                $sheet->getStyle('A' . $rowNum . ':E' . $rowNum)->applyFromArray($totalStyle);
                
                // Enable filter on data columns
                $sheet->setAutoFilter('A' . ($startPenjualanRow - 1) . ':E' . ($rowNum - 1));
                
                $rowNum++;
            }
        }

        if ($reportType === 'Semua Data') {
            $rowNum += 2; // Spacing
        }

        // --- SECTION B: PRODUKSI ---
        if ($reportType === 'Produksi Susu' || $reportType === 'Semua Data') {
            $sheet->setCellValue('A' . $rowNum, 'B. PRODUKSI');
            $sheet->getStyle('A' . $rowNum)->applyFromArray($sectionHeaderStyle);
            $rowNum++;

            // Table Header
            $headersProduksi = ['Tanggal', 'ID Sapi', 'Produksi Pagi (L)', 'Produksi Sore (L)', 'Total Produksi (L)'];
            foreach ($headersProduksi as $colIdx => $header) {
                $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx + 1);
                $sheet->setCellValue($colLetter . $rowNum, $header);
                $sheet->getStyle($colLetter . $rowNum)->applyFromArray($tableHeaderStyle);
            }
            $sheet->getRowDimension($rowNum)->setRowHeight(26);
            $startProduksiRow = $rowNum + 1;
            $rowNum++;

            if ($produksis->isEmpty()) {
                $sheet->setCellValue('A' . $rowNum, 'Tidak ada data produksi.');
                $sheet->mergeCells('A' . $rowNum . ':E' . $rowNum);
                $sheet->getStyle('A' . $rowNum . ':E' . $rowNum)->applyFromArray($dataStyle);
                $sheet->getStyle('A' . $rowNum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $rowNum++;
            } else {
                // Group by date and sapi_code
                $groupedProd = [];
                foreach ($produksis as $pr) {
                    $tgl = $pr->tanggal;
                    $sapiCode = $pr->sapi ? $pr->sapi->code : '—';
                    $key = $tgl . '_' . $sapiCode;

                    if (!isset($groupedProd[$key])) {
                        $groupedProd[$key] = [
                            'tanggal' => $tgl,
                            'sapiCode' => $sapiCode,
                            'pagi' => 0,
                            'sore' => 0
                        ];
                    }

                    $vol = (float)$pr->jumlah_susu;
                    if ($pr->sesi === 'pagi') {
                        $groupedProd[$key]['pagi'] += $vol;
                    } else if ($pr->sesi === 'sore') {
                        $groupedProd[$key]['sore'] += $vol;
                    }
                }

                // Sort by date desc
                uksort($groupedProd, function($a, $b) {
                    return strcmp($b, $a); // Date descending
                });

                foreach ($groupedProd as $row) {
                    $friendlyDate = Carbon::parse($row['tanggal'])->locale('id')->isoFormat('D MMMM YYYY');
                    $sheet->setCellValue('A' . $rowNum, $friendlyDate);
                    $sheet->setCellValue('B' . $rowNum, $row['sapiCode']);
                    $sheet->setCellValue('C' . $rowNum, $row['pagi']);
                    $sheet->setCellValue('D' . $rowNum, $row['sore']);
                    
                    // Total Produksi Formula
                    $sheet->setCellValue('E' . $rowNum, '=C' . $rowNum . '+D' . $rowNum);

                    // Formatting
                    $sheet->getStyle('C' . $rowNum)->getNumberFormat()->setFormatCode('#,##0.0');
                    $sheet->getStyle('D' . $rowNum)->getNumberFormat()->setFormatCode('#,##0.0');
                    $sheet->getStyle('E' . $rowNum)->getNumberFormat()->setFormatCode('#,##0.0');

                    // Alignments
                    $sheet->getStyle('A' . $rowNum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('B' . $rowNum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('C' . $rowNum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle('D' . $rowNum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle('E' . $rowNum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                    $sheet->getStyle('A' . $rowNum . ':E' . $rowNum)->applyFromArray($dataStyle);
                    $rowNum++;
                }

                // Total Row
                $sheet->setCellValue('A' . $rowNum, 'Total');
                $sheet->mergeCells('A' . $rowNum . ':B' . $rowNum);
                $sheet->setCellValue('C' . $rowNum, '=SUM(C' . $startProduksiRow . ':C' . ($rowNum - 1) . ')');
                $sheet->setCellValue('D' . $rowNum, '=SUM(D' . $startProduksiRow . ':D' . ($rowNum - 1) . ')');
                $sheet->setCellValue('E' . $rowNum, '=SUM(E' . $startProduksiRow . ':E' . ($rowNum - 1) . ')');

                $sheet->getStyle('C' . $rowNum)->getNumberFormat()->setFormatCode('#,##0.0');
                $sheet->getStyle('D' . $rowNum)->getNumberFormat()->setFormatCode('#,##0.0');
                $sheet->getStyle('E' . $rowNum)->getNumberFormat()->setFormatCode('#,##0.0');

                $sheet->getStyle('A' . $rowNum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('C' . $rowNum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle('D' . $rowNum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle('E' . $rowNum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                $sheet->getStyle('A' . $rowNum . ':E' . $rowNum)->applyFromArray($totalStyle);
                
                $sheet->setAutoFilter('A' . ($startProduksiRow - 1) . ':E' . ($rowNum - 1));
                
                $rowNum++;
            }
        }

        if ($reportType === 'Semua Data') {
            $rowNum += 2; // Spacing
        }

        // --- SECTION C: REKAPITULASI TOTAL HARIAN ---
        if ($reportType === 'Semua Data') {
            $sheet->setCellValue('A' . $rowNum, 'C. REKAPITULASI TOTAL HARIAN');
            $sheet->getStyle('A' . $rowNum)->applyFromArray($sectionHeaderStyle);
            $rowNum++;

            // Table Header
            $headersRekap = ['Tanggal', 'Total Produksi (L)', 'Total Terjual (L)', 'Sisa Stok Susu (L)', 'Pendapatan'];
            foreach ($headersRekap as $colIdx => $header) {
                $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx + 1);
                $sheet->setCellValue($colLetter . $rowNum, $header);
                $sheet->getStyle($colLetter . $rowNum)->applyFromArray($tableHeaderStyle);
            }
            $sheet->getRowDimension($rowNum)->setRowHeight(26);
            $startRekapRow = $rowNum + 1;
            $rowNum++;

            // Get unique dates
            $uniqueDates = [];
            foreach ($produksis as $pr) {
                $uniqueDates[] = $pr->tanggal;
            }
            foreach ($penjualans as $p) {
                $uniqueDates[] = $p->tanggal;
            }
            $uniqueDates = array_values(array_unique($uniqueDates));
            rsort($uniqueDates); // Sort descending

            if (empty($uniqueDates)) {
                $sheet->setCellValue('A' . $rowNum, 'Tidak ada data rekapitulasi.');
                $sheet->mergeCells('A' . $rowNum . ':E' . $rowNum);
                $sheet->getStyle('A' . $rowNum . ':E' . $rowNum)->applyFromArray($dataStyle);
                $sheet->getStyle('A' . $rowNum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $rowNum++;
            } else {
                foreach ($uniqueDates as $tgl) {
                    // Calculate daily values in PHP to output
                    $dailyProd = $produksis->where('tanggal', $tgl)->sum('jumlah_susu');
                    $dailySales = $penjualans->where('tanggal', $tgl)->sum('jumlah_terjual');
                    $dailyRevenue = $penjualans->where('tanggal', $tgl)->sum('total_pendapatan');

                    $friendlyDate = Carbon::parse($tgl)->locale('id')->isoFormat('D MMMM YYYY');
                    $sheet->setCellValue('A' . $rowNum, $friendlyDate);
                    $sheet->setCellValue('B' . $rowNum, (float)$dailyProd);
                    $sheet->setCellValue('C' . $rowNum, (float)$dailySales);
                    
                    // Formula: Sisa Stok Susu = Total Produksi - Total Terjual
                    $sheet->setCellValue('D' . $rowNum, '=MAX(0, B' . $rowNum . '-C' . $rowNum . ')');
                    $sheet->setCellValue('E' . $rowNum, (float)$dailyRevenue);

                    // Formatting
                    $sheet->getStyle('B' . $rowNum)->getNumberFormat()->setFormatCode('#,##0.0');
                    $sheet->getStyle('C' . $rowNum)->getNumberFormat()->setFormatCode('#,##0.0');
                    $sheet->getStyle('D' . $rowNum)->getNumberFormat()->setFormatCode('#,##0.0');
                    $sheet->getStyle('E' . $rowNum)->getNumberFormat()->setFormatCode('Rp #,##0');

                    // Alignments
                    $sheet->getStyle('A' . $rowNum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('B' . $rowNum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle('C' . $rowNum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle('D' . $rowNum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle('E' . $rowNum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                    $sheet->getStyle('A' . $rowNum . ':E' . $rowNum)->applyFromArray($dataStyle);
                    $rowNum++;
                }

                // Total Row
                $sheet->setCellValue('A' . $rowNum, 'Total');
                $sheet->setCellValue('B' . $rowNum, '=SUM(B' . $startRekapRow . ':B' . ($rowNum - 1) . ')');
                $sheet->setCellValue('C' . $rowNum, '=SUM(C' . $startRekapRow . ':C' . ($rowNum - 1) . ')');
                $sheet->setCellValue('D' . $rowNum, '=SUM(D' . $startRekapRow . ':D' . ($rowNum - 1) . ')');
                $sheet->setCellValue('E' . $rowNum, '=SUM(E' . $startRekapRow . ':E' . ($rowNum - 1) . ')');

                // Formatting totals
                $sheet->getStyle('B' . $rowNum)->getNumberFormat()->setFormatCode('#,##0.0');
                $sheet->getStyle('C' . $rowNum)->getNumberFormat()->setFormatCode('#,##0.0');
                $sheet->getStyle('D' . $rowNum)->getNumberFormat()->setFormatCode('#,##0.0');
                $sheet->getStyle('E' . $rowNum)->getNumberFormat()->setFormatCode('Rp #,##0');

                // Alignments
                $sheet->getStyle('A' . $rowNum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('B' . $rowNum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle('C' . $rowNum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle('D' . $rowNum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle('E' . $rowNum)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

                $sheet->getStyle('A' . $rowNum . ':E' . $rowNum)->applyFromArray($totalStyle);
                
                $sheet->setAutoFilter('A' . ($startRekapRow - 1) . ':E' . ($rowNum - 1));
                
                $rowNum++;
            }
        }

        // Set auto column width for all columns
        foreach (range('A', 'E') as $colLetter) {
            $sheet->getColumnDimension($colLetter)->setAutoSize(true);
        }

        // Write file and stream download
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        
        $fileName = 'laporan_peternakan_' . Carbon::now()->format('Y-m-d_H-i-s') . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }
}
