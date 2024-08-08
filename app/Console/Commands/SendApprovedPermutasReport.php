<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Permuta;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PermutasExport;
use Illuminate\Support\Facades\Mail;
use App\Mail\PermutasReportMail;
use Carbon\Carbon;
use Log;

class SendApprovedPermutasReport extends Command
{
    protected $signature = 'report:send-approved-permutas';
    protected $description = 'Send an Excel report of permutas approved by trade today';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $today = Carbon::today();
        $permutas = Permuta::whereDate('trade_approved_at', $today)
                            ->where('trade_status', 'Approved')
                            ->get();

        Log::debug($permutas);

        if ($permutas->isEmpty()) {
            $this->info('No approved permutas found for today.');
            return;
        }

        $filePath = storage_path('app/public/permutas_approved_today.xlsx');
        Excel::store(new PermutasExport($permutas), 'public/permutas_approved_today.xlsx');

        Mail::to('agrimaldopci18@gmail.com')->send(new PermutasReportMail($filePath));

        $this->info('Report sent successfully.');
    }
}