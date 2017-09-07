<?php declare(strict_types = 1);

if (!function_exists('uuid')) {
    /**
     * Generate a UUID string
     * @return string
     */
    function uuid() : string
    {
        return (string) \Ramsey\Uuid\Uuid::uuid4();
    }
}