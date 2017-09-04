<?php
namespace Poirot\Perevent\Manager;

use Poirot\Ioc\Container\aContainerCapped;
use Poirot\Ioc\Container\Exception\exContainerInvalidServiceType;


class CommandPlugins
    extends aContainerCapped
{
    /**
     * Validate Plugin Instance Object
     *
     * @param mixed $pluginInstance
     *
     * @throws exContainerInvalidServiceType|\Exception
     * @return void
     */
    function validateService($pluginInstance)
    {
        if (!is_object($pluginInstance))
            throw new \Exception(sprintf('Can`t resolve to (%s) Instance.', $pluginInstance));

        if (! is_callable($pluginInstance) )
            throw new exContainerInvalidServiceType('Invalid Plugin Of Prevent Callable Provided.');
    }
}
