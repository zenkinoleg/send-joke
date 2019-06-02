<?php

namespace App\Service;

use App\Contract\JokerStorageInterface;
use Symfony\Component\Filesystem\Filesystem;

class FileJokerStorage implements JokerStorageInterface
{
    private $fs;

    private const LOG_FILE = 'sent-jokes.csv';
    private const LOG_FIELDS = 'date,category,email,joke'.PHP_EOL;

    public function __construct(Filesystem $fs)
    {
        $this->fs = $fs;
        $this->init();
    }

    private function init() : void
    {
        if (!$this->fs->exists(self::LOG_FILE)) {
            $this->fs->appendToFile(self::LOG_FILE, self::LOG_FIELDS);
        }
    }

    public function save($data) : void
    {
        $this->fs->appendToFile(self::LOG_FILE, $data.PHP_EOL);
    }
}
