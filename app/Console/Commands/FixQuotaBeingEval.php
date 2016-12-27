<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class FixQuotaBeingEval extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fixquotabeingeval';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manual bug fix. Do not use until absolutly sure!!!';

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
        if($this->confirm('Are you sure you wish to continue? [y|N]')){
            DB::collection('applicants')
            ->where('quota_being_evaluated', 1)
            ->where('evaluation_status', 0)
            ->whereNotNull('comments')
            ->update([
                'quota_being_evaluated' => 0,
            ]);

            $this->info('Updated');
        }else{
            $this->info('Terminated');
        }
    }
}
