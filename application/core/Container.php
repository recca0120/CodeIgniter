<?php

class CI_Container
{
    protected $core = [
        'Benchmark',
        'Config',
        'Exceptions',
        'Hooks',
        'Input',
        'Lang',
        'Loader',
        'Log',
        'Model',
        'Output',
        'Router',
        'Security',
        'URI',
        'Utf8',
    ];
        
    protected $library = [
        'Calendar',
        'Cart',
        'Driver',
        'Email',
        'Encrypt',
        'Encryption',
        'Form_validation',
        'Ftp',
        'Image_lib',
        'Javascript',
        'Migration',
        'Pagination',
        'Parser',
        'Profiler',
        'Table',
        'Trackback',
        'Typography',
        'Unit_test',
        'Upload',
        'User_agent',
        'Xmlrpc',
        'Xmlrpcs',
        'Zip',
    ];
    
    public function __construct()
    {
        $this->container = new \Illuminate\Container\Container();
        $this->registerCodeignerCore($this->container);
        $this->registerCodeignerLibrary($this->container);
        $this->registerCodeigniterDatabase($this->container);
        \Illuminate\Container\Container::setInstance($this->container);
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

    protected function registerCodeigniterDatabase($container)
    {
        $container->singleton('CI_DB', function ($container) {
            $ci = get_instance();
            $ci->load->database();
                    
            return $ci->db;
        });
    }
        
    protected function registerCodeignerLibrary($container)
    {
        foreach ($this->library as $library) {
            $this->container->singleton('CI_'.$library, function () use ($library) {
                return load_class($library, 'libraries');
            });
                        
            $this->container->alias('CI_'.$library, $library);
        }
    }
        
    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->container, $method], $parameters);
    }
        
    public static function registerAutoload()
    {
        spl_autoload_register(function ($class) {
            $directories = ['core', 'libraries'];
            foreach ($directories as $directory) {
                $file = BASEPATH.'/'.$directory.'/'.str_replace('CI_', '', $class).'.php';
                if (file_exists($file) === true) {
                    require $file;
                        
                    return;
                }
            }
        });
    }
        
    public static function getInstance()
    {
        static $instance;
                
        return is_null($instance) === true
            ? $instance = new static()
            : $instance;
    }
}

CI_Container::registerAutoload();
