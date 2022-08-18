<?php

namespace App\Services;

abstract class BaseService
{
    protected $repository;

    /**
     * Handle dynamic method calls into the service.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->repository->$method(...$parameters);
    }
}
