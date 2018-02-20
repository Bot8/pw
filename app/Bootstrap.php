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

    /**
     * Bootstrap constructor.
     */
    public function __construct()
    {
        $this->configs = new ConfigRepository(__DIR__ . '/../config/');

        $this->request = new Request($_SERVER);
        
        $this->controllerResolver =
            (new ControllerResolver())
                ->setRoutes($this->configs->getConfig('routes'));

        Debug::init();
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
     * @return ConfigRepository
     */
    public function getConfigs(): ConfigRepository
    {
        return $this->configs;
    }

    public function run()
    {
        ob_start();
        $response = $this->controllerResolver->resolve($this->request);
        ob_clean();

        $response->render();
    }
}