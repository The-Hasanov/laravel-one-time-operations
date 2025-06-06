<?php

namespace TimoKoerber\LaravelOneTimeOperations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use SplFileInfo;
use TimoKoerber\LaravelOneTimeOperations\Models\ModelFactory;

class OneTimeOperationFile
{
    protected SplFileInfo $file;

    protected ?OneTimeOperation $classObject = null;

    public static function make(SplFileInfo $file): self
    {
        return new self($file);
    }

    public function __construct(SplFileInfo $file)
    {
        $this->file = $file;
    }

    public function getOperationName(): string
    {
        $pathElements = explode(DIRECTORY_SEPARATOR, $this->file->getRealPath());
        $filename = end($pathElements);

        return Str::remove('.php', $filename);
    }

    public function getClassObject(): OneTimeOperation
    {
        if (! $this->classObject) {
            $this->classObject = File::getRequire($this->file);
        }

        return $this->classObject;
    }

    public function getModel(): ?Model
    {
        return ModelFactory::instance()->whereName($this->getOperationName())->first();
    }
}
