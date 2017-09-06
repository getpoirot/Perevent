<?php
namespace Poirot\Perevent\Entity;

use Poirot\Std\Struct\aDataOptions;


class PereventEntity
    extends aDataOptions
{
    protected $cmdHash;
    protected $command;
    protected $arg = [];
    protected $datetimeExpiration;
    protected $datetimeCreated;


    /**
     * Set unique identifier of an event
     *
     * @param mixed $cmdHash
     *
     * @return $this
     */
    function setCmdHash($cmdHash)
    {
        $this->cmdHash = $cmdHash;
        return $this;
    }

    /**
     * Get unique identifier of an event
     *
     * @return mixed
     */
    function getCmdHash()
    {
        return $this->cmdHash;
    }

    /**
     * Set string map to callable function
     *
     * @param string $command
     *
     * @return $this
     */
    function setCommand($command)
    {
        $this->command = (string) $command;
        return $this;
    }

    /**
     * Get string map to callable function
     *
     * @return string
     */
    function getCommand()
    {
        return $this->command;
    }

    /**
     * Set Default Arguments For Exec Map Callable
     *
     * @param array $arg Associated array
     *
     * @return $this
     *
     */
    function setArgs($arg)
    {
        $this->arg = $arg;
        return $this;
    }

    /**
     * List an associated array of arguments related
     * to exec map callable function
     *
     * @return array
     */
    function getArgs()
    {
        return $this->arg;
    }

    /**
     * Set Event Expiration Time
     *
     * @param \DateTime|null $datetimeExpiration
     *
     * @return $this
     */
    function setDatetimeExpiration($datetimeExpiration)
    {
        $this->datetimeExpiration = $datetimeExpiration;
        return $this;
    }

    /**
     * Expiration Time of an event
     *
     * @return \DateTime
     */
    function getDatetimeExpiration()
    {
        return $this->datetimeExpiration;

    }

    /**
     * Datetime when record inserted
     *
     * @param \DateTime $datetimeCreated
     */
    function setDatetimeCreated($datetimeCreated)
    {
        $this->datetimeCreated = $datetimeCreated;
    }

    /**
     * Datetime when record inserted
     *
     * @return \DateTime
     */
    function getDatetimeCreated()
    {
        if (! $this->datetimeCreated )
            $this->datetimeCreated = new \DateTime;

        return $this->datetimeCreated;
    }
}
