<?php

class MY_Controller extends CI_Controller
{
    protected $container;

    public function __construct()
    {
        parent::__construct();
        $this->container = require __DIR__ . '/Container.php';
    }

    public function _remap($method, $parameters)
    {
        return $this->container->call([$this, $method], $parameters);
    }
}