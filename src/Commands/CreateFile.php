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
        $explodeFileName = explode('/', $this->getFileName());

        $upperCaseDirectoryName = [];

        foreach ($explodeFileName as $name) {
            $upperCaseDirectoryName[] = ucfirst($name);
        }

        $directoryPath = implode('/', $upperCaseDirectoryName);

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

        $namespace = $this->getDefaultNamespace();

        $namespace .= '\\' . $name;

        $namespace = Str::replace('/', '\\', $namespace);

        return 'app\\' . trim($namespace, '\\');
    }


    protected function getClasName(): string
    {
        return class_basename($this->argument('name'));
    }

    public function handle()
    {
        $path = Str::replace('\\', '/', $this->getDestinationFilePath());

        $getClass = class_basename($this->getFileName());
        $className = Str::replace('.php', '', Str::ucfirst($getClass));

        if (! File::isDirectory($dir = dirname($path))) {
            File::makeDirectory($dir, 0777, true);
        }

        $stubFilePath = $this->getStubFilePath();
        $data = [
            'CLASS_NAMESPACE' => $this->getClassNamespace(),
            'CLASS' => $className,
        ];

        $path = Str::replace(lcfirst($className), ucfirst($className), $path);

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
}
