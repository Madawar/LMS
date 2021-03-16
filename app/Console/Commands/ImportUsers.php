<?php

namespace App\Console\Commands;

use App\Imports\StaffImport;
use Illuminate\Console\Command;
use Storage;

class ImportUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'staff:import';

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
     * @return int
     */
    public function handle()
    {
        $this->output->title('Starting import');
        (new StaffImport)->withOutput($this->output)->import(app_path('employees.csv'));
        $this->output->success('Import successful');
        return 0;
    }
}
