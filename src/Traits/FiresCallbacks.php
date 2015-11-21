<?php namespace Anomaly\Streams\Platform\Traits;

use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class FiresCallbacks
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Traits
 */
trait FiresCallbacks
{

    /**
     * The registered callbacks.
     *
     * @var array
     */
    protected $callbacks = [];

    /**
     * Register a new callback.
     *
     * @param $trigger
     * @param $callback
     * @return $this
     */
    public function on($trigger, $callback)
    {
        if (!isset($this->callbacks[$trigger])) {
            $this->callbacks[$trigger] = [];
        }

        $this->callbacks[$trigger][] = $callback;

        return $this;
    }

    /**
     * Fire a set of closures by trigger.
     *
     * @param       $trigger
     * @param array $parameters
     * @return $this
     */
    public function fire($trigger, array $parameters = [])
    {
        $method = camel_case('on_' . $trigger);

        if (method_exists($this, $method)) {
            app()->call([$this, $method], $parameters);
        }

        $handler = get_class($this) . ucfirst(camel_case('on_' . $trigger));

        if (class_exists($handler)) {
            app()->call($handler . '@handle', $parameters);
        }

        $observer = get_class($this) . 'Callbacks';

        if (class_exists($observer) && $observer = app($observer, $parameters)) {
            if (method_exists($observer, $method)) {
                app()->call([$observer, $method], $parameters);
            }
        }

        foreach (array_get($this->callbacks, $trigger, []) as $callback) {

            if (is_string($callback) || $callback instanceof \Closure) {
                app()->call($callback, $parameters);
            }

            if ($callback instanceof SelfHandling) {
                call_user_func_array([$callback, 'handle'], $parameters);
            }
        }

        return $this;
    }

    /**
     * Set the callbacks.
     *
     * @param array $callbacks
     * @return $this
     */
    public function setCallbacks(array $callbacks)
    {
        $this->callbacks = $callbacks;

        return $this;
    }
}
