# Perevent
Event Store


```php

$client = new \MongoDB\Client('mongodb://db-master-mongo:27017/');
$db     = $client->selectDatabase('apanaj');

$repo   = new \Poirot\Perevent\Repo\RepoMongo($db, 'perevents');

$insert = function () use ($repo) {
    $repo->insert(new \Poirot\Perevent\Entity\PereventEntity([
        'uid'      => 'x12345',
        'exec_map' => 'time',
        'args'     => [
            'a1' => 1,
            'a2' => 2,
        ],
        'datetime_expiration' => new DateTime(time()+1000)
    ]));
};

class ci
    implements \Poirot\Perevent\Interfaces\Features\iRepositoryAware
{
    /** @var \Poirot\Perevent\Interfaces\iRepoPerEvent */
    protected $repo;

    function __invoke($a1, $a2, $uid)
    {
        if ($this->repo)
            echo 'Repository injected.';


        $this->repo->deleteOneByUID($uid);
        return time();
    }

    /**
     * @param \Poirot\Perevent\Interfaces\iRepoPerEvent $repo
     * @return mixed
     */
    function setRepository(\Poirot\Perevent\Interfaces\iRepoPerEvent $repo)
    {
        $this->repo = $repo;
    }
}


$m = new \Poirot\Perevent\ManagerOfPerevents([
    'repository' => $repo,
    'plugins'    => [
        'services' => [
            'time' => 'ci'
        ],
    ],
]);

$r = $m->fireEvent('x12345');

```
