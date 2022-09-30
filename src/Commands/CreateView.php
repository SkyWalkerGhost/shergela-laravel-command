<?php

namespace Shergela\LaravelCommand\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Shergela\LaravelCommand\Commands\Support\FileGenerator;
use Shergela\LaravelCommand\Commands\Support\FileCreator;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Exception;

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

    public function __construct(protected FileGenerator $fileGenerator) {
        parent::__construct();
    }

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
        $lowerCaseDirectoryName = $this->fileGenerator->upperOrLowerCaseDirectoryName(
            $this->getFileName(), 
            '/', 
            'lower'
        );

        return resource_path(). '/views/'. $lowerCaseDirectoryName;
    }

    protected function getStubFilePath(): string
    {
        return __DIR__ . '/stubs/blade.stub';
    }

    public function handle()
    {
        $style = new OutputFormatterStyle('white', 'green', ['bold']);
        $this->output->getFormatter()->setStyle('info', $style);

        $path = Str::replace('\\', '/', $this->getDestinationFilePath());

        $this->fileGenerator->createDirectory($path);

        $data = [
            '@welcomeMsg' => 'Hello World',
        ];

        $stubFilePath = $this->getStubFilePath();

        $contents = $this->getContents($stubFilePath, $data);


        try {
            
            (new FileCreator($path, $contents))->generate();

            $this->info('Directories and blade file are successfully created!');
            $this->info('Path: ' . $path);

        } catch (Exception $e) {
            $this->error("File : {$e->getMessage()}");
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
