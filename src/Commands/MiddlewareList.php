<?php

namespace Shergela\LaravelCommand\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

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

    protected function tableHeaders(): array
    {
        return ['Full Path', 'File Name', 'Extension', 'Size'];
    }

    protected function getMiddlewarePath(): string
    {
        return app_path() . '\\Http\\Middleware';
    }

    protected function getFileData(array $files): array
    {
        $results = [];

        foreach ($files as $file) {
            $results[] = [
                $file->getPathInfo(),
                $file->getBasename(),
                '.'.$file->getExtension(),
                $this->getFileSize($file->getSize()),
            ];
        }

        return $results;
    }

    protected function getFileSize(int $fileSize): string
    {
        return $fileSize / 1000 . ' kb';
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $allFiles = File::files($this->getMiddlewarePath());
        $data = $this->getFileData($allFiles);
       
        $style = new OutputFormatterStyle('white', 'green', ['bold']);
        $this->output->getFormatter()->setStyle('info', $style);

        $this->newLine(1);
        $this->info('Found ' . count($data) . ' files in middleware list');
        $this->newLine(1);

        $this->table(
            $this->tableHeaders(),
            $data
        );

        return 0;
    }
}
