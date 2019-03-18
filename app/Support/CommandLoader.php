<?php

namespace App\Support;

use Pimple\Container;
use Symfony\Component\Console\CommandLoader\CommandLoaderInterface;
use Symfony\Component\Console\Exception\CommandNotFoundException;

class CommandLoader implements CommandLoaderInterface
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function get($name)
    {
        if (!$this->has($name)) {
            throw new CommandNotFoundException(sprintf('Command "%s" does not exist.', $name));
        }

        return $this->container[$this->getKey($name)];
    }

    /**
     * {@inheritdoc}
     */
    public function has($name)
    {
        return isset($this->container[$this->getKey($name)]);
    }

    /**
     * {@inheritdoc}
     */
    public function getNames()
    {
        $result = [];
        foreach ($this->container->keys() as $key) {
            if (strpos($key, 'cli.') === 0) $result[] = substr($key, 4);
        }
        return $result;
    }

    private function getKey($name)
    {
        return 'cli.' . $name;
    }
}
