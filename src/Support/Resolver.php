<?php namespace Anomaly\Streams\Platform\Support;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Container\Container;

/**
 * Class Resolver
 *
 * This is a handy class for getting input from
 * a callable target.
 *
 * $someArrayConfig = 'MyCallableClass@handle'
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
class Resolver
{

    /**
     * The IoC container.
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * Create a new Resolver instance.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Resolve the target.
     *
     * @param        $target
     * @param array  $arguments
     * @param array  $options
     * @return mixed
     */
    public function resolve($target, array $arguments = [], array $options = [])
    {
        $method = array_get($options, 'method', 'handle');

        if (is_string($target) && str_contains($target, '@')) {
            $target = $this->container->call($target, $arguments);
        } elseif (is_string($target) && class_exists($target) && class_implements($target, SelfHandling::class)) {
            $target = $this->container->call($target . '@' . $method, $arguments);
        }

        return $target;
    }
}
