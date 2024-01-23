<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Company;
use Carbon\Carbon;
use App\Mail\CompanyInactive;
class CompanyPeriod extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'comapny:period';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = ' Send mail Expired company list to ompl';

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

        $date = new \DateTime();
        $from = $date->modify('-80 days')->format('Y-m-d H:i:s');
        

        
          $companies =   Company::whereDate('start_date', '>=', $from)->get();
          info($from);
          info($companies);
        
        $data = $companies;
        Mail::to('nagaraj@ochre-media.com')
        ->send(new CompanyInactive($data));
         $this->info('Mail has been send successfully');
 
    }
}
