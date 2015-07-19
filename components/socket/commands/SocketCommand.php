<?php
/**
 * SocketCommand.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace cookyii\socket\commands;

/**
 * Class SocketCommand
 * @package cookyii\socket\commands
 */
abstract class SocketCommand extends \yii\console\Controller
{

    protected $loadRoutesFromModules = true;

    /**
     * @return array
     */
    protected function getRoutes()
    {
        return [
            [
                'path' => '/udp',
                'controller' => new \cookyii\socket\controllers\UdpController,
            ],
//          [
//              'path' => '/some',
//              'controller' => new \cookyii\socket\controllers\SomeController,
//              'allowedOrigins' => [],
//              'httpHost' => null,
//          ],
//          [
//              ...
//          ],
        ];
    }

    /**
     * @param string $domain
     * @param int $port
     * @param string $address
     * @throws \yii\base\InvalidConfigException
     */
    protected function runSocket($domain, $port = 18665, $address = '0.0.0.0')
    {
        echo 'New web socket listening...';

        $Socket = new \Ratchet\App($domain, $port, $address);

        $routes = $this->getRoutes();

        if ($this->loadRoutesFromModules) {
            $modules = \Yii::$app->modules;
            if (!empty($modules)) {
                foreach ($modules as $module => $conf) {
                    $Module = null;

                    if (is_string($conf)) {
                        $Module = new $conf($module);
                    }

                    if (is_object($conf)) {
                        $Module = $conf;
                    }

                    if ($Module instanceof \cookyii\socket\interfaces\SocketListInterface) {
                        $routes = array_merge($routes, $Module->getSockets());
                    }
                }
            }
        }

        if (!empty($routes)) {
            foreach ($routes as $route) {
                if (!isset($route['path'])) {
                    throw new \yii\base\InvalidConfigException(\Yii::t('yii', 'Missing required parameters: {params}', [
                        'params' => '$route[path]',
                    ]));
                }

                if (!isset($route['controller'])) {
                    throw new \yii\base\InvalidConfigException(\Yii::t('yii', 'Missing required parameters: {params}', [
                        'params' => '$route[controller]',
                    ]));
                }

                $allowedOrigins = isset($route['allowedOrigins']) ? $route['allowedOrigins'] : [];
                $httpHost = isset($route['httpHost']) ? $route['httpHost'] : null;

                $Socket->route($route['path'], $route['controller'], $allowedOrigins, $httpHost);
            }
        }

        $Socket->run();
    }
}