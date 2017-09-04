<?php
namespace Poirot\Perevent\Interfaces\Features;

use Poirot\Perevent\Interfaces\iRepoPerEvent;

interface iRepositoryAware
{
    /**
     * @param iRepoPerEvent $repo
     * @return mixed
     */
    function setRepository(iRepoPerEvent $repo);
}
