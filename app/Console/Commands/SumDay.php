<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use App\Models\TransactionsDaySummary;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SumDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api-test:sum-day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        $date = Carbon::yesterday()->toDateString();
        $sum = Transaction::whereDate('created_at', $date)
            ->sum('amount');

        TransactionsDaySummary::create([
            'summary' => $sum,
            'date' => $date
        ]);
    }
}
