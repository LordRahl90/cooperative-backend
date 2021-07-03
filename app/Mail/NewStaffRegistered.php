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
    public $link;

    /**
     * Create a new message instance.
     *
     * @param $company
     * @param $staff
     * @param $password
     * @param $token
     * @param $link
     */
    public function __construct($company, $staff, $password, $token, $link)
    {
        $this->company = $company;
        $this->staff = $staff;
        $this->password = $password;
        $this->link = $link;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        Log::info("Received token: $this->token");
        Log::info($this->link);
        $newPasswordReset = DB::table('password_resets')->insert([
            'email' => $this->staff['email'],
            'token' => $this->token,
            'created_at' => now()
        ]);
        if (!$newPasswordReset) {
            Log::error("cannot create a new reset password token");
        }
        $host = explode("://", config('app.url'));
        $from = 'registrations@' . $host[1];
        return $this
            ->subject("New Staff Registration")
            ->from($from, 'Staff Registration')
//            ->from('registration@coop-account.com', 'Staff Registration')
            ->view('staff.welcome');
    }
}
