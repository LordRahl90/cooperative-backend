<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Transaction;
use App\Utility\Utility;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AccountReport extends Controller
{
    public function showGeneralLedger()
    {
        $companies = Company::orderBy('name', 'desc')->pluck('name', 'id');
        //TODO: Abiodun, sort the account heads with login companies
        $accountHeads = Utility::getAccountHeads(1);
        return view('reports.general_ledger', [
            'companies' => $companies,
            'account_heads' => [0 => 'Select Account'] + $accountHeads->toArray()
        ]);
    }

    public function generalLedger(Request $request)
    {
        $input = $request->all();
        $companyID = $input['company_id'];
        $accountHead = $input['account_head_id'];
        $startDate = $input['start_date'];
        $endDate = $input['end_date'];

        $records = Transaction::whereRaw('company_id=? AND account_head_id=? AND DATE(created_at) BETWEEN ? and ?', [
            $companyID, $accountHead, $startDate, $endDate
        ])->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $rowCount = 1;
        $sheet->setCellValue('A' . $rowCount, 'Date');
        $sheet->setCellValue('B' . $rowCount, 'Reference');
        $sheet->setCellValue('C' . $rowCount, 'Narration');
        $sheet->setCellValue('D' . $rowCount, 'Debit');
        $sheet->setCellValue('E' . $rowCount, 'Credit');
        $sheet->setCellValue('F' . $rowCount, 'Balance');
        $balance = 0;


        foreach ($records as $record) {
            $balance = $balance + ($record->debit_amount - $record->credit_amount);
            $rowCount++;
            $sheet->setCellValue('A' . $rowCount, $record->created_at->format('d/m/Y'));
            $sheet->setCellValue('B' . $rowCount, $record->reference);
            $sheet->setCellValue('C' . $rowCount, $record->narration);
            $sheet->setCellValue('D' . $rowCount, number_format($record->debit_amount, 2));
            $sheet->setCellValue('E' . $rowCount, number_format($record->credit_amount, 2));
            $sheet->setCellValue('F' . $rowCount, number_format($balance, 2));
        }
        $rowCount++;

        $sheet->setCellValue('A' . $rowCount, 'Total:');
        $sheet->setCellValue('B' . $rowCount, '');
        $sheet->setCellValue('C' . $rowCount, '');
        $sheet->setCellValue('D' . $rowCount, '');
        $sheet->setCellValue('E' . $rowCount, '');
        $sheet->setCellValue('F' . $rowCount, number_format($balance, 2));

        $writer = new Xlsx($spreadsheet);
        $writer->save("report.xlsx");

        dd($records);
    }

    public function showBankReport()
    {

    }

    public function bankReport(Request $request)
    {

    }

    public function showDailyReport()
    {

    }

    public function staffDailyReport()
    {

    }

    public function trialBalance()
    {

    }
}
