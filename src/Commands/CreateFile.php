<?php

namespace Shergela\LaravelCommand\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

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
        $directoryPath = $this->upperCase($this->getFileName(), '/');

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

        $directoryPath = $this->upperCase($name, '\\');

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
        $path = Str::replace('\\', '/', $this->getDestinationFilePath());

        if (! File::isDirectory($dir = dirname($path))) {
            File::makeDirectory($dir);
        }
        
        $getClass = class_basename($this->getFileName());
        $className = Str::replace('.php', '', Str::ucfirst($getClass));

        $data = [
            'CLASS_NAMESPACE' => $this->getClassNamespace(),
            'CLASS' => $className,
        ];

        $path = Str::replace(lcfirst($className), ucfirst($className), $path);

        $stubFilePath = $this->getStubFilePath();
        $contents = $this->getContents($stubFilePath, $data);

        $filesystem = new Filesystem();

        if (! $filesystem->exists($path)) {
            $filesystem->put($path, $contents);

            $this->info('Folder and file created successfully!');
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
            $contents = str_replace('{{ ' . strtoupper($search) . ' }}', $replace, $contents);
        }

        return $contents;
    }

    public function upperCase(string $fileName, string $parameter): string
    {
        $explodeFilePath = explode($parameter, $fileName);

        $upperCaseDirectoryName = [];

        foreach ($explodeFilePath as $name) {
            $upperCaseDirectoryName[] = ucfirst($name);
        }

        $directoryPath = implode('/', $upperCaseDirectoryName);

        return $directoryPath;
    }
}
