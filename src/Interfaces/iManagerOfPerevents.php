<?php
namespace Poirot\Perevent\Interfaces;


interface iManagerOfPerevents
{
    /**
     * Get EventCode(uid) and Execute related callable
     *
     * @param mixed $uid
     *
     * @return mixed
     */
    function fireEvent($uid);

    /**
     * Give Events Repository
     *
     * @param iRepoPerEvent $repo
     *
     * @return $this
     */
    function giveEventsRepo(iRepoPerEvent $repo);
}
