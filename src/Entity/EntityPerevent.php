<?php
namespace Poirot\Perevent\Entity;

use Poirot\Std\Struct\aDataOptions;

class EntityPerevent
{
    protected $uid;
    protected $arg=array();
    protected $execMap;
    protected $expairedAt;
    protected $createdAt;

    /**
     * return unique identifier of any event
     *
     * @return mixed
     */
    function getUid()
    {
        return $this->uid;
    }

    /**
     * set unique identifier of any event
     * @param mixed $uid
     * @return $this
     */
    function setUid($uid)
    {
        $this->uid = $uid;
        return $this;
    }

    /**
     * return a array of arguments for any callable function  need ;
     *
     * @return array
     */
    function getArg()
    {
        return $this->arg;
    }

    /**
     *
     * set a array of arguments for callable fanction
     *
     * @param array $arg
     *
     * @return $this
     *
     */
    function setArg($arg)
    {
        $this->arg = $arg;
        return $this;
    }

    /**
     * return string off callable function  need to execute;
     *
     * @return string
     */
    function getExecMap()
    {
        return $this->execMap;
    }

    /**
     * set string off callable function
     *
     * @param mixed $execMap
     *
     * @return $this
     */
    function setExecMap($execMap)
    {
        $this->execMap = $execMap;
        return $this;
    }

    /**
     * return  time of when a event expired
     *
     * @return \DateTime
     */
    function getExpairedAt()
    {
        if (! $this->expairedAt )
            $this->expairedAt = new \DateTime;

        return $this->expairedAt;

    }

    /**
     * set expiry time
     *
     * @param mixed $expairedAt
     * @return $this
     */
    function setExpairedAt($expairedAt)
    {
        $this->expairedAt = $expairedAt;
        return $this;
    }

    /**
     * datetime of when a record insreted
     *
     * @return \DateTime
     */
    function getCreatedAt()
    {
        if (! $this->createdAt )
            $this->createdAt = new \DateTime;

        return $this->createdAt;
    }

    /**
     * date time of when record inserted
     * @param \DateTime $createdAt
     */
    function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }






}