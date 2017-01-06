<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RetrieveDocument extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'retrievedocument {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save file back from R410';

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
        //pullback FHz58u3cpnXGssdkFVe4QMUTJdJCXk
        exec('scp pullback@10.100.101.200:/doc_dump/'.$this->argument('filename').' '.storage_path('uploaded_documents/'));
        sleep(1);
        exec('FHz58u3cpnXGssdkFVe4QMUTJdJCXk');
    }
}
