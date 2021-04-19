<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class NewStaffRegistered extends Mailable
{
    use Queueable, SerializesModels;

    public $company;
    public $staff;
    public $password;
    public $token;

    /**
     * Create a new message instance.
     *
     * @param $company
     * @param $staff
     * @param $password
     */
    public function __construct($company, $staff, $password)
    {
        $this->company = $company;
        $this->staff = $staff;
        $this->password = $password;
        $this->token = uniqid('tk-');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $newPasswordReset = DB::table('password_resets')->insert([
            'email' => $this->staff->email,
            'token' => Hash::make($this->token),
            'created_at' => now()
        ]);
        if (!$newPasswordReset) {
            Log::info("cannot create a new reset password token");
        }
        $host = explode(config('app.url'), "://");
        Log::info($host);
        return $this
            ->subject("New Staff Registration")
            ->from('registrations@' . $host[1], 'Staff Registration')
//            ->from('registration@coop-account.com', 'Staff Registration')
            ->view('staff.welcome');
    }
}
