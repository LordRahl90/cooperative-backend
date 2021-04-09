<?php

namespace App\Console\Commands;

use App\Utility\Transactions;
use Illuminate\Console\Command;

class CalculateInterest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coop:repayment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will calculate and generate the interest for a customer for each month.
     If one has been calculated for the month already, it becomes skipped.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Transactions::calculateMonthlyRepayment();
        $this->comment("hello calculating interest");
        return 0;
    }
}
