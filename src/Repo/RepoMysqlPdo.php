<?php
namespace Poirot\Perevent\Repo;


use Poirot\Perevent\Interfaces\iRepoPerEvent;
use Poirot\Perevent\Entity\EntityPerevent;

class RepoMysqlPdo implements iRepoPerEvent
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
    function __construct(\PDO $connection,$table = 'perevents')
    {
        $this->conn   = $connection;
        $this->table = (string) $table;
    }

    /**
     * Persist Entity Objec
     * @param EntityPerevent $entityPerevent
     *
     * @return mixed UID
     */

    function insert(EntityPerevent $entityPerevent)
    {
        $uid          = $entityPerevent->getUid();
        $args         = $entityPerevent->getArg();
        $executeMap   = $entityPerevent->getExecMap();
        $expiredAt    = $entityPerevent->getExpairedAt()->format('Y-m-d H:i:s');
        $createdAt    = $entityPerevent->getCreatedAt()->format('Y-m-d H:i:s');


        $this->conn->beginTransaction();
        try{
            $sql    = 'INSERT INTO `'.$this->table.'` 
            ( `uid`, `exec_map`, `expaired_at`, `created_at`)
            VALUES (?,?,?,?)'
            ;


            $stm = $this->conn->prepare($sql);
            $stm->bindParam(1,$uid);
            $stm->bindParam(2,$executeMap);
            $stm->bindParam(3,$expiredAt);
            $stm->bindParam(4,$createdAt);


            if ( false === $stm->execute() )
            {
                throw new \Exception(sprintf(
                    'Error While Insert Into (%s).'
                    , $this->table
                ));
            }else
            {
                $pereventId=$this->conn->lastInsertId();
                foreach ($args as $k=>$v)
                {
                    $argssql    = 'INSERT INTO `'.$this->table.'_args` 
                    ( `perevent_id`, `key`, `value`)
                        VALUES (?,?,?)'
                    ;

                    $stmargs = $this->conn->prepare($argssql);
                    $stmargs->bindParam(1,$pereventId);
                    $stmargs->bindParam(2,$k);
                    $stmargs->bindParam(3,$v);
                    $stmargs->execute() ;



                }
                $this->conn->commit();
                return $pereventId;

            }




        }catch (\Exception $e){
        echo $e->getMessage();
        //Rollback the transaction.
            $this->conn->rollBack();
    }




    }

    /**
     * Find  Entity Match With Given uid
     * @param mixed   $uid

     * @return \Traversable
     */

    function find($uid)
    {

        $query = 'SELECT   *
          FROM        '.$this->table.'
          WHERE uid = :uid'
        ;



        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':uid', $uid, \PDO::PARAM_STR);


        $stmt->execute();
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        if ( false === $result = $stmt->fetch() )
            return 0;
        $queryargs = 'SELECT   *
          FROM        perevents_args
          WHERE perevent_id = :perevent_id'
        ;
        $stmt = $this->conn->prepare($queryargs);
        $stmt->bindParam(':perevent_id', $result['perevent_id'], \PDO::PARAM_STR);


        $stmt->execute();
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        if ( false === $args = $stmt->fetchAll() )
            return  $args =[];


        $result['args']=$args;
        kd($result);

       return $result;

    }

    /**
     * delete  all Entities Match With Given uid
     * @param array   $uid

     * @return mixed UID
     */

    function delete($uid)
    {

    }


}