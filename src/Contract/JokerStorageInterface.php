<?php

namespace App\Contract;

/**
 * Interface for Storage
 */
interface JokerStorageInterface
{
    /**
     * Save method for clients to store data
     * Return void
     *
     * @param mixed $data
     * @return void
     */
    public function save($data) : void;
}
