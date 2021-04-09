<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords {
        resetPassword as traitResetPassword;
    }

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    protected function resetPassword($user, $password)
    {
        DB::beginTransaction();
        $this->traitResetPassword($user, $password);

        $staff = $user->staff;
        if ($staff !== null) {
            try {
                $staff->password = $user->password;
                $staff->active = true;
                $staff->save();
                session(['company_id' => $staff->company_id, 'staff_id' => $staff->id]);
            } catch (\Exception $ex) {
                Log::info($ex);
                DB::rollBack();
                return response("invalid password reset attempt.", 500);
            }
        }
        DB::commit();
    }
}
