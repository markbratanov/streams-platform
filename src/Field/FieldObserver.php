<?php namespace Anomaly\Streams\Platform\Field;

use Anomaly\Streams\Platform\Field\Command\DeleteFieldAssignments;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Field\Event\FieldWasCreated;
use Anomaly\Streams\Platform\Field\Event\FieldWasDeleted;
use Anomaly\Streams\Platform\Field\Event\FieldWasSaved;
use Anomaly\Streams\Platform\Field\Event\FieldWasUpdated;
use Anomaly\Streams\Platform\Support\Observer;

/**
 * Class FieldObserver
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Field
 */
class FieldObserver extends Observer
{

    /**
     * Fired after creating a field.
     *
     * @param FieldInterface $model
     */
    public function created(FieldInterface $model)
    {
        $model->flushCache();

        $this->events->fire(new FieldWasCreated($model));
    }

    /**
     * Fired after a field is updated.
     *
     * @param FieldInterface $model
     */
    public function updated(FieldInterface $model)
    {
        $model->flushCache();

        $this->events->fire(new FieldWasUpdated($model));
    }

    /**
     * Fired after saving a field.
     *
     * @param FieldInterface $model
     */
    public function saved(FieldInterface $model)
    {
        $model->flushCache();
        $model->compileStreams();

        $this->events->fire(new FieldWasSaved($model));
    }

    /**
     * Fired just before deleting a field.
     *
     * @param FieldInterface $model
     */
    public function deleting(FieldInterface $model)
    {
        $this->commands->dispatch(new DeleteFieldAssignments($model));
    }

    /**
     * Fired after a field has been deleted.
     *
     * @param FieldInterface $model
     */
    public function deleted(FieldInterface $model)
    {
        $model->flushCache();

        $this->events->fire(new FieldWasDeleted($model));
    }
}
