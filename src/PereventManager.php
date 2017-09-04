<?php
/**
 * Created by PhpStorm.
 * User: mostafa
 * Date: 9/4/17
 * Time: 9:57 AM
 */

namespace Poirot\Perevent;


use Poirot\Ioc\Container\Service\ServiceFactory;
use Poirot\Perevent\Entity\EntityPerevent;
use Poirot\Perevent\Interfaces\iPerventManager;
use Poirot\Perevent\Interfaces\iRepoPerEvent;

class PereventManager implements iPerventManager
{
    protected $commandContainer;
    protected $repoPerEvent;


    /**
     * iperventManager constructor.
     *
     * @param CommandContainer $commandContainer
     * @param iRepoPerEvent $repoPerEvent
     */
    public function __construct(CommandContainer $commandContainer, iRepoPerEvent $repoPerEvent)
    {
       $this->commandContainer=$commandContainer;
       $this->repoPerEvent=$repoPerEvent;
    }

    /**
     * event stroing
     *
     * @param mixed $uid Affected uid
     * @param string $execMap callable method
     * @param array $args argument for method
     * @param \DateTime $expairedAt when event expire
     * @param \DateTime $createdAt when event created
     *
     * @return $this
     */
    function saveEvent($uid, $execMap, $args = [], $expairedAt = null, $createdAt = null)
    {
        $entityPerevent = new EntityPerevent();
        $entityPerevent
            ->setUid($uid)
            ->setArg($args)
            ->setExecMap($execMap)
            ->setExpairedAt($expairedAt)
            ->setCreatedAt($createdAt);
        $this->repoPerEvent->insert($entityPerevent);
        return $this;


    }

    /**
     * get code (uid) retrieve function and execute
     *
     * @param string $uid uiniqe id of any event
     * @param CommandContainer $commandContainer build a container
     *
     */
    function fireEvent($uid, CommandContainer $commandContainer)
    {
        $result=$this->repoPerEvent->find($uid);

        $this->commandContainer->get($result['exec_map'],['args'=>$result['args']]);


    }
}