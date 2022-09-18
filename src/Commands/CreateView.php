<?php

namespace Shergela\LaravelCommand\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class CreateView extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:view {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create blade views and directories';

    /**
     * Execute the console command.
     *
     * @return int
     */

    protected function getFileName(): string
    {
        $view = Str::camel($this->argument('name'));

        if (Str::contains(strtolower($view), '.blade.php') === false) {
            $view .= '.blade.php';
        }

        return $view;
    }

    protected function getDestinationFilePath(): string
    {
        $explodeFileName = explode('/', $this->getFileName());

        $upperCaseDirectoryName = [];

        foreach ($explodeFileName as $name) {
            $upperCaseDirectoryName[] = Str::lower($name);
        }

        $directoryPath = implode('/', $upperCaseDirectoryName);

        return resource_path(). '/views/'. $directoryPath;
    }

    protected function getStubFilePath(): string
    {
        return __DIR__ . '/stubs/blade.stub';
    }

    public function handle()
    {
        $path = Str::replace('\\', '/', $this->getDestinationFilePath());

        if (! File::isDirectory($dir = dirname($path))) {
            File::makeDirectory($dir, 0777, true);
        }

        $data = [
            '@welcomeMsg' => 'Hello World',
        ];

        $stubFilePath = $this->getStubFilePath();

        $contents = $this->getContents($stubFilePath, $data);

        $filesystem = new Filesystem();

        if (! $filesystem->exists($path)) {
            $filesystem->put($path, $contents);

            $this->info('Directories and blade file are successfully created!');
            $this->info('Path: ' . $path);
        } else {
            $this->error('File already exists!');
            $this->error('Path: ' . $path);
        }

        return 0;
    }

    public function getContents(string $stubFilePath, array $data): string
    {
        $contents = file_get_contents($stubFilePath);
        
        foreach ($data as $search => $replace) {
            $contents = str_replace('@welcomeMsg', $replace, $contents);
        }

        return $contents;
    }
}
