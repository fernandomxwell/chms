<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunSetupTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs all necessary commands for application setup';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Starting application setup...');

        $this->call('key:generate');
        $this->call('migrate');
        $this->call('db:seed');
        $this->call('storage:link');

        $this->call('app:create-menu', ['menu' => 'Home']);
        $this->call('app:create-menu', ['menu' => 'Activities']);
        $this->call('app:create-menu', ['menu' => 'Congregants']);
        $this->call('app:create-menu', ['menu' => 'Service Types']);
        $this->call('app:create-menu', ['menu' => 'Schedule Management']);
        $this->call('app:create-menu', ['menu' => 'Congregant Services', '--parent' => 'Schedule Management']);
        $this->call('app:create-menu', ['menu' => 'Schedules', '--parent' => 'Schedule Management']);

        $this->info('✅ All setup tasks completed successfully!');

        return 0;
    }
}
