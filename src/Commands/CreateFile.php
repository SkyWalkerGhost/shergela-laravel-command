<?php

namespace Shergela\LaravelCommand\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Shergela\LaravelCommand\Commands\Support\FileGenerator;
use Shergela\LaravelCommand\Commands\Support\FileCreator;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Exception;

class CreateFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:file {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate directory and file';

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
        $file = Str::camel($this->argument('name'));

        if (Str::contains(strtolower($file), '.php') === false) {
            $file .= '.php';
        }

        return $file;
    }

    protected function getDestinationFilePath(): string
    {
        $directoryPath = $this->fileGenerator->upperOrLowerCaseDirectoryName($this->getFileName(), '/', 'upper');

        return app_path(). '/'. $directoryPath;
    }

    protected function getStubFilePath(): string
    {
        return __DIR__ . '/stubs/file.stub';
    }

    protected function getDefaultNamespace(): string
    {
        return '';
    }

    protected function getClassNamespace(): string
    {
        $name = Str::replace(
            array($this->getClasName(), '/'), 
            array('', '\\'), 
            $this->argument('name')
        );

        $directoryPath = $this->fileGenerator->upperOrLowerCaseDirectoryName($name, '\\', 'upper');

        $namespace = $this->getDefaultNamespace();

        $namespace .= '\\' . $directoryPath;

        $namespace = Str::replace('/', '\\', $namespace);

        return 'App\\' . trim($namespace, '\\');
    }


    protected function getClasName(): string
    {
        return class_basename($this->argument('name'));
    }

    public function handle()
    {
        $style = new OutputFormatterStyle('white', 'green', ['bold']);
        $this->output->getFormatter()->setStyle('info', $style);

        $path = Str::replace('\\', '/', $this->getDestinationFilePath());
        
        $this->fileGenerator->createDirectory($path);
        
        $getClass = class_basename($this->getFileName());
        $className = Str::replace('.php', '', Str::ucfirst($getClass));

        $data = [
            'CLASS_NAMESPACE' => $this->getClassNamespace(),
            'CLASS' => $className,
        ];

        $path = Str::replace(lcfirst($className), ucfirst($className), $path);

        $stubFilePath = $this->getStubFilePath();
        $contents = $this->getContents($stubFilePath, $data);

        try {
            
            (new FileCreator($path, $contents))->generate();

            $this->info('Folder and file created successfully!');
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
            $contents = str_replace('{{ ' . strtoupper($search) . ' }}', $replace, $contents);
        }

        return $contents;
    }
}
