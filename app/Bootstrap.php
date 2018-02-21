<?php
/**
 * Created by PhpStorm.
 * User: artarn
 * Date: 20.02.18
 * Time: 20:28
 */

namespace App;

use App\Core\Debug;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\ConfigRepository;
use App\Core\Container\Container;
use App\Core\Controller\ControllerResolver;

class Bootstrap
{
    protected static $application;

    /** @var Request */
    protected $request;

    /** @var Response */
    protected $response;

    /** @var ControllerResolver */
    protected $controllerResolver;

    /** @var ConfigRepository */
    protected $configs;

    /** @var Container */
    protected $container;

    /**
     * Bootstrap constructor.
     */
    public function __construct()
    {
        Debug::init();

        $this->initContainer()
             ->initConfigs()
             ->extendContainerBinding()
             ->initRequest()
             ->initControllerResolver();
    }

    /**
     * @return Bootstrap
     */
    public static function getInstance()
    {
        if (null === self::$application) {
            self::$application = new self();
        }

        return self::$application;
    }

    /**
     * @return Container
     */
    public function getContainer(): Container
    {
        return $this->container;
    }

    public function run()
    {
        ob_start();
        $response = $this->controllerResolver->resolve($this->request);
        ob_clean();

        $response->render();
    }

    protected function initContainer()
    {
        $this->container = new Container();

        return $this;
    }

    protected function extendContainerBinding()
    {
        foreach ($this->configs->getConfig('bindings') as $abstract => $binding) {
            $this->container->bind($abstract, $binding);
        }

        return $this;
    }

    protected function initConfigs()
    {
        $this->configs = new ConfigRepository(__DIR__ . '/../config/');

        $this->container->bind('configs', $this->configs);

        return $this;
    }

    protected function initRequest()
    {
        $this->request = new Request($_SERVER);

        $this->container->bind(Request::class, $this->request);

        return $this;
    }

    protected function initControllerResolver()
    {
        $this->controllerResolver = $this->container->resolve(ControllerResolver::class);

        return $this;
    }
}