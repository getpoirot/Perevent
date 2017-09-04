<?php
/**
 * Created by PhpStorm.
 * User: mostafa
 * Date: 9/3/17
 * Time: 3:48 PM
 */

namespace Poirot\Perevent\Interfaces;


use Poirot\Perevent\CommandContainer;
use Poirot\Perevent\Entity\EntityPerevent;

interface iPerventManager
{

    /**
     * iperventManager constructor.
     *
     * @param CommandContainer $commandContainer
     * @param iRepoPerEvent $repoPerEvent
     */
    function __construct(CommandContainer $commandContainer ,iRepoPerEvent $repoPerEvent);
    /**
     * ivent stroing
     *
     * @param mixed     $uid      Affected uid
     * @param string $execMap    callable method
     * @param array    $args  argument for method
     * @param \DateTime $expairedAt      when event expire
     * @param \DateTime $createdAt    when event created
     *
     * @return $this
     */

    function saveEvent($uid,$execMap , $args=[],$expairedAt=null,$createdAt=null);

    /**
     * get code (uid) retrieve function and execute
     *
     * @param string $uid    uiniqe id of any event
     * @param CommandContainer $commandContainer build a container
     *
     */

    function fireEvent($uid, CommandContainer $commandContainer);

}