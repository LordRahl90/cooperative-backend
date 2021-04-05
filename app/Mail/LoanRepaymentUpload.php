<?php

namespace App\Mail;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class LoanRepaymentUpload extends Mailable
{
    use Queueable, SerializesModels;

    public $staffID;
    public $success;
    public $failures;
    public $incomplete;
    public $invalidStaff;
    public $duplicates;

    /**
     * Create a new message instance.
     *
     * @param $staffID
     * @param $success
     * @param $failures
     * @param $incomplete
     * @param $invalidStaff
     * @param $duplicates
     */
    public function __construct($staffID, $success, $failures, $incomplete, $invalidStaff, $duplicates)
    {
        $this->staffID = $staffID;
        $this->success = $success;
        $this->failures = $failures;
        $this->incomplete = $incomplete;
        $this->invalidStaff = $invalidStaff;
        $this->duplicates = $duplicates;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $otherEmails = [];
        $user = User::find($this->staffID);
        if ($user == null) {
            Log::info("invalid staff found for $this->staffID");
            return;
        }
        $staff = $user->staff;
        if ($staff == null) {
            Log::info("invalid staff");
        }
        $allStaff = Staff::where('company_id', $staff->company_id)->where('role', 'in', ['MANAGER', 'SUPERVISOR'])->get();
        foreach ($allStaff as $af) {
            $otherEmails[] = $af->email;
        }

        return $this
            ->from('tolaabbey009@gmail.com', 'Transactions')
            ->cc($otherEmails)
            ->subject('Monthly Repayment Schedule Upload')
            ->view('loan_repayments.emails.upload_done');
    }
}
