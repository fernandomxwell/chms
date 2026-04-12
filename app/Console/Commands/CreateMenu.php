<?php

namespace App\Console\Commands;

use App\Services\MenuService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateMenu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-menu {menu} {--parent=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Artisan to create new menu';

    /**
     * Execute the console command.
     */
    public function handle(MenuService $service)
    {
        $menu = ucwords($this->argument('menu'));
        $parent = ucwords($this->option('parent'));

        DB::beginTransaction();
        try {
            $service->updateOrCreate($menu, $parent);

            DB::commit();

            $this->line("  <bg=blue> INFO </> Menu {$menu} processed successfully");

            $this->newLine();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("  <bg=red> ERROR </>" . $e->getMessage());
        }
    }
}
