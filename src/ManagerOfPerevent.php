<?php
namespace Poirot\Perevent;

use Poirot\Ioc\Container\BuildContainer;
use Poirot\Perevent\Interfaces\Features\iRepositoryAware;
use Poirot\Perevent\Interfaces\iManagerOfPerevents;
use Poirot\Perevent\Interfaces\iRepoPerEvent;
use Poirot\Perevent\Manager\CommandPlugins;
use Poirot\Std\aConfigurable;
use Poirot\Std\Exceptions\exImmutable;


class ManagerOfPerevent
    extends aConfigurable
    implements iManagerOfPerevents
{
    /** @var iRepoPerEvent */
    protected $repo;
    /** @var CommandPlugins */
    protected $plugins;


    /**
     * Get EventCode(uid) and Execute related callable
     *
     * @param mixed $uid
     * @param array $args Override arguments
     *
     * @return mixed
     * @throws \Exception
     */
    function fireEvent($uid, array $args = [])
    {
        $entity = $this->repo->findOneByCmdHash($uid);
        if (! $entity )
            // Do Nothing; Entity Not Found.
            return null;

        $command = $entity->getCommand();
        if (! $this->plugins()->has($command) )
            throw new \Exception(sprintf(
                'Command %s is Unknown.'
                , $command
            ));

        $callable  = $this->plugins()->get($command);
        $arguments = $entity->getArgs();

        $arguments = ($args) ? array_merge($args, $arguments) : $arguments;
        if (! empty($arguments) )
            $callable = \Poirot\Std\Invokable\resolveCallableWithArgs($callable, $arguments);


        return call_user_func($callable);
    }

    /**
     * Give Events Repository
     *
     * @param iRepoPerEvent $repo
     *
     * @return $this
     */
    function giveEventsRepo(iRepoPerEvent $repo)
    {
        if ( $this->repo )
            throw new exImmutable('Repository is Immutable and cant be changed.');


        $this->repo = $repo;
        return $this;
    }

    /**
     * Command Plugins
     *
     * @return CommandPlugins
     */
    function plugins()
    {
        if (! $this->plugins ) {
            $this->plugins = new CommandPlugins;
            $this->_addContainerInitializers( $this->plugins );
        }

        return $this->plugins;
    }


    // Implement Configurable

    /**
     * Build Object With Provided Options
     *
     * @param array $options Associated Array
     * @param bool $throwException Throw Exception On Wrong Option
     *
     * @return $this
     * @throws \Exception
     * @throws \InvalidArgumentException
     */
    function with(array $options, $throwException = false)
    {
        # Repository
        #
        if ( isset($options['repository']) )
            $this->giveEventsRepo($options['repository']);


        # Plugins Container
        #
        if ( isset($options['plugins']) ) {
            $builder = new BuildContainer($options['plugins']);
            $builder->build( $this->plugins() );
        }
    }


    // ..

    private function _addContainerInitializers(CommandPlugins $plugins)
    {
        $repo = $this->repo;

        $plugins->initializer()
            ->addCallable(function($instance) use ($repo) {
                if ($instance instanceof iRepositoryAware)
                    $instance->setRepository($repo);
        });
    }
}
