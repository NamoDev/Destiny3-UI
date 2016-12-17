<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ReportController;
use Storage;
use Mail;

class ReportApplicant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reportapplicant {destination_email* : Destination email address}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Report applicant';

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
        $targetMail = $this->argument('destination_email');

        $this->info('Generating report...');
        $path = (new ReportController)->generateExcelReport();
        $this->info('Report generated!');

        $this->info('Start sending mail(s)');
        $bar = $this->output->createProgressBar(count($targetMail));

        for($i=0;$i<count(2);$i++){
            $destination = (string) $targetMail[$i];
            Mail::send('emails.report', [], function ($m) use ($destination, $path) {
                $m->from('no-reply@apply.triamudom.ac.th', 'ระบบรับสมัครนักเรียนโควตาจังหวัด โรงเรียนเตรียมอุดมศึกษา');
                $m->to($destination)->subject('ข้อมูลโควตาจังหวัด');
                $m->attach($path);
            });

            $bar->advance();
        }

        Storage::delete($path);

        $bar->finish();
        $this->info("\nSend completed");
    }
}
