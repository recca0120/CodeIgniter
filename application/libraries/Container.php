<?php

class Container
{
    protected $core = [
        'Benchmark',
        'Hooks',
        'Config',
        'Utf8',
        'URI',
        'Router',
        'Output',
        'Security',
        'Input',
        'Lang',
				'Loader',
    ];
    
    public function __construct()
    {
        $this->container = new \Illuminate\Container\Container();
        $this->registerCodeignerCore($this->container);
        Container::setInstance($this->container);
    }

    protected function registerCodeignerCore($container)
    {
        foreach ($this->core as $core) {
            $this->container->singleton('CI_'.$core, function () use ($core) {
                return load_class($core, 'core');
            });
						
						$this->container->alias('CI_'.$core, $core);
        }
				
        $this->container->singleton('CI_Controller', function () use ($core) {
            return get_instance();
        });
    }

    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->container, $method], $parameters);
    }
}
