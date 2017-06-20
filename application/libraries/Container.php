<?php

class Container {
    public function __construct() {
        $this->container = new \Illuminate\Container\Container();
        Container::setInstance($this->container);
    }

    protected function register($container) {
        // register
    }

    public function __call($method, $parameters) {
        return call_user_func_array([$this->container, $method], $parameters);
    }
}
