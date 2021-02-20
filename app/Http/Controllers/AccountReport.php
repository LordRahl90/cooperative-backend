<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\OrgAccountHead;
use App\Models\OrgBankAccount;
use App\Models\Transaction;
use App\Utility\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PDF;

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

        $accountInfo = OrgAccountHead::with(['category'])->find($accountHead);
        $category = $accountInfo->category;

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
        $sheet->getStyle('A' . $rowCount . ':' . 'G' . $rowCount)->getFont()->setBold(true);


        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);

        $sheet->getStyle('A' . $rowCount . ':' . 'F' . $rowCount)->getFont()->setBold(true);
        $sheet->getStyle('D' . $rowCount . ':F' . $rowCount)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $balance = 0;

        foreach ($records as $record) {
            if ($category->account_type === 'DEBIT') {
                $balance = $balance + ($record->debit_amount - $record->credit_amount);
            } else {
                $balance = $balance + ($record->credit_amount - $record->debit_amount);
            }
            $rowCount++;
            $sheet->getStyle('D' . $rowCount . ':F' . $rowCount)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

            $sheet->setCellValue('A' . $rowCount, $record->created_at->format('d/m/Y'));
            $sheet->setCellValue('B' . $rowCount, $record->reference);
            $sheet->setCellValue('C' . $rowCount, $record->narration);
            $sheet->setCellValue('D' . $rowCount, number_format($record->debit_amount, 2));
            $sheet->setCellValue('E' . $rowCount, number_format($record->credit_amount, 2));
            $sheet->setCellValue('F' . $rowCount, number_format(abs($balance), 2));
        }
        $rowCount++;

        $sheet->getStyle('A' . $rowCount . ':F' . $rowCount)->getFont()->setBold(true);
        $sheet->getStyle('A' . $rowCount . ':F' . $rowCount)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $sheet->mergeCells('A' . $rowCount . ':E' . $rowCount);
        $sheet->setCellValue('A' . $rowCount, 'Total:');
        $sheet->setCellValue('F' . $rowCount, number_format($balance, 2));

        $f = public_path("/reports/") . uniqid('em-') . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($f);

//        dd($records);
        return response()->download($f);
    }

    public function showBankReport()
    {
        $companies = Company::orderBy('name', 'desc')->pluck('name', 'id');
        $bankAccounts = OrgBankAccount::orderBy('account_name', 'asc')->pluck('account_name', 'account_head_id');
        return view('reports.bank_report', [
            'companies' => $companies,
            'bank_accounts' => $bankAccounts
        ]);
    }

    public function bankReport(Request $request)
    {
        $input = $request->all();
        $companyID = $input['company_id'];
        $bankAccount = $input['bank_account_id'];
        $startDate = $input['start_date'];
        $endDate = $input['end_date'];

        $records = Transaction::whereRaw('company_id=? AND account_head_id=? AND DATE(created_at) BETWEEN ? and ?', [
            $companyID, $bankAccount, $startDate, $endDate
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
        $sheet->getStyle('A' . $rowCount . ':' . 'G' . $rowCount)->getFont()->setBold(true);


        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);

        $sheet->getStyle('A' . $rowCount . ':' . 'F' . $rowCount)->getFont()->setBold(true);
        $sheet->getStyle('D' . $rowCount . ':F' . $rowCount)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $balance = 0;

        foreach ($records as $record) {
            $balance = $balance + ($record->credit_amount - $record->debit_amount);
            $rowCount++;
            $sheet->getStyle('D' . $rowCount . ':F' . $rowCount)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

            $sheet->setCellValue('A' . $rowCount, $record->created_at->format('d/m/Y'));
            $sheet->setCellValue('B' . $rowCount, $record->reference);
            $sheet->setCellValue('C' . $rowCount, $record->narration);
            $sheet->setCellValue('D' . $rowCount, number_format($record->debit_amount, 2));
            $sheet->setCellValue('E' . $rowCount, number_format($record->credit_amount, 2));
            $sheet->setCellValue('F' . $rowCount, number_format($balance, 2));
        }

        $rowCount++;

        $sheet->getStyle('A' . $rowCount . ':F' . $rowCount)->getFont()->setBold(true);
        $sheet->getStyle('A' . $rowCount . ':F' . $rowCount)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $sheet->mergeCells('A' . $rowCount . ':E' . $rowCount);
        $sheet->setCellValue('A' . $rowCount, 'Total:');
        $sheet->setCellValue('F' . $rowCount, number_format($balance, 2));

        $f = public_path("/reports/") . uniqid('em-') . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($f);

        return response()->download($f);
    }

    public function showDailyReport()
    {

    }

    public function staffDailyReport()
    {

    }

    public function showTrialBalance()
    {
        $companies = Company::orderBy('name', 'desc')->pluck('name', 'id');
        return view('reports.show_trial_balance', [
            'companies' => $companies
        ]);
    }

    public function trialBalance(Request $request)
    {
        $input = $request->all();

        $companyID = $input['company_id'];
        $startDate = $input['start_date'] . ' 00:00:00';
        $endDate = $input['end_date'] . ' 23:59:59';

        $company = Company::find($companyID);
        $results = DB::table('transactions')
            ->selectRaw('account_head_id,org_account_heads.code as code, sum(debit_amount) as debit, sum(credit_amount) as credit')
            ->join("org_account_heads", "org_account_heads.id", "=", "account_head_id")
            ->where('transactions.company_id', $companyID)
            ->whereBetween('transactions.created_at', [$startDate, $endDate])
            ->groupBy('account_head_id')
            ->orderBy('code', 'asc')
            ->get();

        $pdf = PDF::loadView('reports.trial_balance', [
            'company' => $company,
            'results' => $results,
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
        $pdf->stream('trial_balance.pdf');
    }
}
