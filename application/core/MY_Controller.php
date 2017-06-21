<?php

require __DIR__ . '/Container.php';

class MY_Controller extends CI_Controller
{
    public function _remap($method, $parameters = [])
    {
        if (method_exists($this, $method) === false) {
            show_404();
        }

        return $this->ioc($method, $parameters);
    }

    protected function ioc($method, $parameters = [])
    {
        return CI_Container::getInstance()->call([$this, $method], $parameters);
    }
}
