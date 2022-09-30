<?php 

namespace Shergela\LaravelCommand\Commands\Support;

use Illuminate\Support\Facades\File;
use Illuminate\Filesystem\Filesystem;
use Exception;

class FileCreator
{
    public function __construct(protected $path, protected $contents, protected $filesystem = null)
    {
        $this->path = $path;
        $this->contents = $contents;
        $this->filesystem = $filesystem ?: new Filesystem();
    }

    protected function getFilePath(): string
    {
    	return $this->path = $this->path;
    }

    protected function getContents(): string
    {
    	return $this->contents = $this->contents;
    }

    public function generate()
    {
        $path = $this->getFilePath();

        if (! $this->filesystem->exists($path)) {
            return $this->filesystem->put($path, $this->getContents());
        }

        throw new Exception('File already exists!');
    }
}