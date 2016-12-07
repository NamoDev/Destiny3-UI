<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class ClearOldData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clearolddata';

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
        $this->info('Start retrieving data');
        $all = DB::collection('applicants')->whereNull('evaluation_id')->get();
        $this->info('Data retrieval completed');

        $bar = $this->output->createProgressBar(count($all));
        $errors = [];

        foreach($all as $individual){
            $new = array_intersect($individual['steps_completed'], [1, 2, 3]);

            $update = DB::collection('applicants')
                        ->where('_id', $individual['_id'])
                        ->update([
                            'steps_completed' => $new,
                        ]);

            if($update != 1){
                $errors[] = [
                    'object' => $individual['_id'],
                    'affected_row' => $update,
                ];
            }

            $bar->advance();
        }

        $bar->finish();
        $this->info("\nAll data updated");
    }
}
