<?php

namespace Shergela\LaravelCommand\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Shergela\LaravelCommand\Commands\Support\DataTable;
use Exception;

class MiddlewareList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'middleware:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display all middleware lists';

    /**
     * Execute the console command.
     *
     * @return int
     */

    protected function getFolderPath(): string
    {
        return app_path() . '\\Http\\Middleware';
    }

    public function handle()
    {
        $style = new OutputFormatterStyle('white', 'green', ['bold']);
        $this->output->getFormatter()->setStyle('info', $style);

        try {
            $dataTable = new DataTable();

            $data = $dataTable->getTableData($this->getFolderPath());
            $tableHeaders = $dataTable->tableHeaders();

            $this->newLine(1);
            $this->info('Found ' . count($data) . ' files in middleware list');
            $this->newLine(1);

            $this->table(
                $tableHeaders,
                $data
            );

        } catch (Exception $e) {
            $this->error("Error : {$e->getMessage()}");
        }

        return 0;
    }
}
