<?php
namespace Poirot\Perevent\Repo\Mongo;

use Module\MongoDriver\Model\tPersistable;
use MongoDB\BSON\Persistable;
use MongoDB\BSON\UTCDatetime;


class PereventEntity
    extends \Poirot\Perevent\Entity\PereventEntity
    implements Persistable
{
    use tPersistable;


    /** @var  \MongoId */
    protected $_id;


    // Mongonize Options

    function set_Id($id)
    {
        $this->_id = $id;
    }

    function get_Id()
    {
        return $this->_id;
    }

    function set__Pclass()
    {
        // Ignore Values
    }

    /**
     * Set Created Date
     *
     * @param UTCDatetime $date
     *
     * @return $this
     */
    function setDatetimeCreatedMongo(UTCDatetime $date)
    {
        $this->setDatetimeCreated($date->toDateTime());
        return $this;
    }

    /**
     * Get Created Date
     * note: persist when serialize
     *
     * @return UTCDatetime
     */
    function getDatetimeCreatedMongo()
    {
        $dateTime = $this->getDatetimeCreated();
        return new UTCDatetime($dateTime->getTimestamp() * 1000);
    }

    /**
     * @override Ignore from persistence
     * @ignore
     *
     * Date Created
     *
     * @return \DateTime
     */
    function getDatetimeCreated()
    {
        return parent::getDatetimeCreated();
    }

    /**
     * @param UTCDatetime $date
     *
     * @return $this
     */
    function setDatetimeExpirationMongo(UTCDatetime $date)
    {
        $this->setDatetimeExpiration($date->toDateTime());
        return $this;
    }

    /**
     * note: persist when serialize
     *
     * @return UTCDatetime|null
     */
    function getDatetimeExpirationMongo()
    {
        if ($dateTime = $this->getDatetimeExpiration())
            return new UTCDatetime($dateTime->getTimestamp() * 1000);

    }

    /**
     * @override Ignore from persistence
     * @ignore
     *
     * @return \DateTime|null
     */
    function getDatetimeExpiration()
    {
        return parent::getDatetimeExpiration();
    }


    // ...

    /**
     * @inheritdoc
     */
    function bsonUnserialize(array $data)
    {
        if (isset($data['args'])) {
            $args = \Poirot\Std\toArrayObject($data['args']);
            $data['args'] = $args;
        }

        $this->import($data);
    }

}
