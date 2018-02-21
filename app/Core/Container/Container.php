<?php

namespace App\Core\Container;

use App\Core\Exceptions\NoBindingException;

class Container
{
    protected $bindings = [];

    /**
     * Container constructor.
     */
    public function __construct()
    {
        $coreBindings = include __DIR__ . '/core.php';

        if (!empty($coreBindings)) {
            foreach ($coreBindings as $abstract => $binding) {
                $this->bind($abstract, $binding);
            }
        }
    }

    public function bind(string $abstract, $concrete)
    {
        $this->bindings[$abstract] = $concrete;
    }

    public function hasBind(string $abstract)
    {
        return isset($this->bindings[$abstract]);
    }

    public function resolve(string $abstract)
    {
        if (!isset($this->bindings[$abstract])) {
            throw new NoBindingException($abstract);
        }

        $concrete = $this->bindings[$abstract];

        if ($concrete instanceof \Closure) {
            $this->bindings[$abstract] = $concrete($this);
        }

        return $this->bindings[$abstract];
    }
}