<?php 

namespace Shergela\LaravelCommand\Commands\Support;

use Illuminate\Support\Facades\File;

class DataTable
{
    public function tableHeaders(): array
    {
        return ['Full Path', 'File Name', 'Extension', 'Size'];
    }

    protected function getFileData(array $lists): array
    {
        $results = [];

        foreach ($lists as $file) {
            $results[] = [
                $file->getPathname(),
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

    public function getTableData(string $folderPath): array
    {
        $lists = $this->getFileLists($folderPath);

        return $this->getFileData($lists);
    }

    protected function getFileLists(string $folderPath): array
    {
        return File::allFiles($folderPath);
    }
}