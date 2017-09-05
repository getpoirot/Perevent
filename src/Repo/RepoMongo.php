<?php
namespace Poirot\Perevent\Repo;

use MongoDB\BSON\ObjectID;
use Poirot\Perevent\Interfaces\iRepoPerEvent;
use Poirot\Perevent\Entity\PereventEntity;

use Poirot\Perevent\Repo\Mongo;
use Module\MongoDriver\Model\Repository\aRepository;


/*
 * Predefined Mongo Indexes
 * db.database_name.collection_name.createIndex({"datetime_expiration_mongo": 1}, {expireAfterSeconds: 0});
 *
 */

class RepoMongo
    extends aRepository
    implements iRepoPerEvent
{
    /**
     * Initialize Object
     *
     */
    protected function __init()
    {
        if (! $this->persist )
            $this->setModelPersist(new Mongo\PereventEntity());
    }

    /**
     * Generate next unique identifier to persist
     * data with
     *
     * @param null|string $id
     *
     * @return mixed
     * @throws \Exception
     */
    function attainNextIdentifier($id = null)
    {
        try {
            $objectId = ($id !== null) ? new ObjectID( (string)$id ) : new ObjectID;
        } catch (\Exception $e) {
            throw new \Exception(sprintf('Invalid Persist (%s) Id is Given.', $id));
        }

        return $objectId;
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
        $pEntity = new Mongo\PereventEntity;
        $pEntity
            ->setUid( $entityPerevent->getUid() )
            ->setCommand( $entityPerevent->getCommand() )
            ->setArgs( $entityPerevent->getArgs() )
            ->setDatetimeExpiration( $entityPerevent->getDatetimeExpiration() )
            ->setDatetimeCreated( $entityPerevent->getDatetimeCreated() )
        ;

        $r = $this->_query()->insertOne($pEntity);

        $rEntity = new PereventEntity;
        $rEntity
            ->setUid( $entityPerevent->getUid() )
            ->setCommand( $entityPerevent->getCommand() )
            ->setArgs( $entityPerevent->getArgs() )
            ->setDatetimeExpiration( $entityPerevent->getDatetimeExpiration() )
            ->setDatetimeCreated( $entityPerevent->getDatetimeCreated() )
        ;

        return $rEntity;
    }

    /**
     * Find an Entity Match With Given uid
     *
     * !! consider expiration time
     *
     * @param mixed $uid

     * @return PereventEntity|null
     */
    function findOneByUID($uid)
    {
        // TODO Consider Datetime Expiration

        /** @var Mongo\PereventEntity $e */
        $e = $this->_query()->findOne(
            [
                'uid' => $uid
            ]
        );


        if (! $e)
            return null;


        $rEntity = new PereventEntity;
        $rEntity
            ->setUid( $e->getUid() )
            ->setCommand( $e->getCommand() )
            ->setArgs( $e->getArgs() )
            ->setDatetimeExpiration( $e->getDatetimeExpiration() )
            ->setDatetimeCreated( $e->getDatetimeCreated() )
        ;

        return $rEntity;
    }

    /**
     * Delete an Entities Match With Given uid
     *
     * @param mixed $uid

     * @return void
     */
    function deleteOneByUID($uid)
    {
        $this->_query()->deleteOne(
            [
                'uid' => $uid
            ]
        );
    }
}
