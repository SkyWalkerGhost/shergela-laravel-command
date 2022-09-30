<?php 

namespace Shergela\LaravelCommand\Commands\Support;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FileGenerator
{
    public function upperOrLowerCaseDirectoryName(
        string $fileName, 
        string $parameter, 
        string $upperOrLowerCase
    ): string
    {
        $explodeFilePath = explode($parameter, $fileName);

        $results = [];

        foreach ($explodeFilePath as $name) {
            $results[] = $this->upperOrLowerCaseName($name, $upperOrLowerCase);
        }

        $directoryPath = implode('/', $results);

        return $directoryPath;
    }

    protected function upperOrLowerCaseName(string $name, string $upperOrLowerCase): string
    {
        return $upperOrLowerCase == 'upper' ? Str::ucfirst($name) : Str::lower($name);
    }

    public function createDirectory(string $path): bool
    {
        $returnValue = false;

        $dir = dirname($path);

        if (! File::isDirectory($dir)) {
            $returnValue = File::makeDirectory($dir, 0777, true);
        }

        return $returnValue;
    }
}