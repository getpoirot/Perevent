<?php
namespace Poirot\Perevent\Repo;

use Poirot\Perevent\Interfaces\iRepoPerEvent;
use Poirot\Perevent\Entity\PereventEntity;


class RepoMysqlPdo
    implements iRepoPerEvent
{
    /** @var \PDO */
    private $conn;
    private $table;


    /**
     * RepoPerevrnt constructor.
     *
     * @param \PDO   $connection
     * @param string $table
     */
    function __construct(\PDO $connection, $table = 'perevents')
    {
        $this->conn  = $connection;
        $this->table = (string) $table;
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
        $uid          = $entityPerevent->getUid();
        $args         = $entityPerevent->getArgs();
        $executeMap   = $entityPerevent->getCommand();
        $createdAt    = $entityPerevent->getDatetimeCreated()->format('Y-m-d H:i:s');
        $expiredAt    = ($entityPerevent->getDatetimeExpiration())
            ? $entityPerevent->getDatetimeExpiration()->format('Y-m-d H:i:s')
            : null;


        $this->conn->beginTransaction();

        try {
            $sql = 'INSERT INTO `'.$this->table.'` 
            ( `uid`, `exec_map`, `expaired_at`, `created_at`)
            VALUES (?,?,?,?)';

            $stm = $this->conn->prepare($sql);
            $stm->bindParam(1,$uid);
            $stm->bindParam(2,$executeMap);
            $stm->bindParam(3,$expiredAt);
            $stm->bindParam(4,$createdAt);

            if ( false === $stm->execute() ) {
                throw new \Exception(sprintf(
                    'Error While Insert Into (%s).'
                    , $this->table
                ));

            }

            $pereventId = $this->conn->lastInsertId();

            foreach ($args as $k => $v) {
                $argssql = 'INSERT INTO `'.$this->table.'_args` 
                ( `perevent_id`, `key`, `value`)
                    VALUES (?,?,?)';

                $stmargs = $this->conn->prepare($argssql);
                $stmargs->bindParam(1,$pereventId);
                $stmargs->bindParam(2,$k);
                $stmargs->bindParam(3,$v);
                $stmargs->execute() ;
            }

            $this->conn->commit();

        } catch (\Exception $e) {
            $this->conn->rollBack();

            throw $e;
        }


        return clone $entityPerevent;
    }

    /**
     * Find an Entity Match With Given uid
     *
     * - consider expiration time
     *
     * @param mixed $uid

     * @return PereventEntity|null
     */
    function findOneByUID($uid)
    {
        // TODO Implement this
    }

    /**
     * Delete an Entities Match With Given uid
     *
     * @param mixed $uid

     * @return void
     */
    function deleteOneByUID($uid)
    {
        // TODO Implement this
    }
}
