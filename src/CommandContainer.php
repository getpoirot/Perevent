<?php
namespace Poirot\Perevent;

use Poirot\Ioc\Container\aContainerCapped;
use Poirot\Ioc\Container\Exception\exContainerInvalidServiceType;

class CommandContainer extends aContainerCapped
{

    /**
     * Validate Plugin Instance Object
     *
     * @param mixed $pluginInstance
     *
     * @throws exContainerInvalidServiceType
     * @return void
     */
    function validateService($pluginInstance)
    {
            if (! is_callable($pluginInstance))
                throw new exContainerInvalidServiceType("given instance not callable");



    }





}