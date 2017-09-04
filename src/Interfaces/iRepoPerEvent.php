<?php
namespace Poirot\Perevent\Interfaces;

use Poirot\Perevent\Entity\PereventEntity;


interface iRepoPerEvent
{
    /**
     * Persist Entity Object
     *
     * @param PereventEntity $entityPerevent
     *
     * @return PereventEntity
     */
    function insert(PereventEntity $entityPerevent);

    /**
     * Find an Entity Match With Given uid
     *
     * !! consider expiration time
     *
     * @param mixed $uid

     * @return PereventEntity|null
     */
    function findOneByUID($uid);

    /**
     * Delete an Entities Match With Given uid
     *
     * @param mixed $uid

     * @return void
     */
    function deleteOneByUID($uid);

}