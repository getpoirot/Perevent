<?php
namespace Poirot\Perevent\Repo;

use Poirot\Perevent\Interfaces\iRepoPerEvent;
use Poirot\Perevent\Entity\PereventEntity;
use Poirot\Storage\Interchange\SerializeInterchange;

use Predis;


class RepoRedis
    implements iRepoPerEvent
{
    const PREFIX = 'perevent.';


    /** @var  Predis\Client */
    private $client;
    /** @var SerializeInterchange */
    private $_interchangable;


    /**
     * Construct
     *
     * @param Predis\Client $client
     */
    protected function __construct(Predis\Client $client)
    {
        $this->client = $client;

        $this->_interchangable = new SerializeInterchange;
    }


    /**
     * Persist Entity Object
     *
     * @param PereventEntity $entityPerevent
     *
     * @return PereventEntity
     * @throws \Exception
     */
    function insert(PereventEntity $entityPerevent)
    {
        $uid          = $entityPerevent->getCmdHash();
        $expiredAt    = ($entityPerevent->getDatetimeExpiration())
            ? strtotime($entityPerevent->getDatetimeExpiration()) - time()
            : null;

        $this->client->set(
            self::PREFIX.$uid,
            $this->_interchangable->makeForward($entityPerevent)
        );

        if(!is_null($expiredAt)) {
            $this->client->expire(
                self::PREFIX . $uid,
                $expiredAt
            );
        }

        return $entityPerevent;
    }

    /**
     * Find an Entity Match With Given uid
     *
     * !! consider expiration time
     *
     * @param mixed $uid

     * @return PereventEntity|null
     */
    function findOneByCmdHash($uid)
    {
        $result = $this->client->get(self::PREFIX.$uid);

        if (! $result)
            return null;

        $e = $this->_interchangable->retrieveBackward($result);

        $rEntity = new PereventEntity;
        $rEntity
            ->setCmdHash( $e['cmdhash'] )
            ->setCommand( $e['command'] )
            ->setArgs( $e['args'] )
            ->setDatetimeExpiration( $e['datetimeexpiration'] )
            ->setDatetimeCreated( $e['datetimecreated'] )
        ;

        return $rEntity;
    }

    /**
     * Delete an Entities Match With Given uid
     *
     * @param mixed $uid

     * @return mixed
     */
    function deleteOneByUID($uid)
    {
        $delete = $this->client->del([self::PREFIX.$uid]);
        return (is_null($delete)) ? false :  $delete;
    }
}
