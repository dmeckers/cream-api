<?php

declare(strict_types=1);

class TrackNotUploadedException extends Exception
{
    public function __construct()
    {
        parent::__construct('File not uploaded');
    }
}