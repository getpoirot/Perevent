<?php
namespace Poirot\Perevent\Interfaces;


interface iManagerOfPerevents
{
    /**
     * Get EventCode(uid) and Execute related callable
     *
     * @param mixed $uid
     * @param array $args Override arguments
     *
     * @return mixed
     * @throws \Exception
     */
    function fireEvent($uid, array $args = []);

    /**
     * Give Events Repository
     *
     * @param iRepoPerEvent $repo
     *
     * @return $this
     */
    function giveEventsRepo(iRepoPerEvent $repo);
}
