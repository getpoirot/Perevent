<?php
namespace Poirot\Perevent\Interfaces;

use Poirot\Perevent\Entity\EntityPerevent;

interface iRepoPerEvent
{



    /**
     * Persist Entity Object
     *
     * @param EntityPerevent $entityWallet
     *
     * @return mixed UID
     */

    function insert(EntityPerevent $entityPerevent);

    /**
     * Find  Entity Match With Given uid
     * @param mixed   $uid

     * @return \Traversable
     */

    function find($uid);

    /**
     * delete  all Entities Match With Given uid
     * @param array   $uid

     * @return mixed UID
     */

    function delete($uid);

}