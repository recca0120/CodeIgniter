<?php

class MY_Controller extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->library('container');
    }

    public function _remap($method, $parameters)
    {
        if (method_exists($this, $method) === false) {
            show_404();
        }

        return $this->ioc($method, $parameters);
    }

    protected function ioc($method, $parameters) {
        return $this->container->call([$this, $method], $parameters);
    }
}