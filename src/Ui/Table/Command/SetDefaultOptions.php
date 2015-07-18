<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Ui\Table\Multiple\MultipleTableBuilder;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class SetDefaultOptions
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Command
 */
class SetDefaultOptions implements SelfHandling
{

    /**
     * The table builder.
     *
     * @var TableBuilder
     */
    protected $builder;

    /**
     * Create a new SetDefaultOptions instance.
     *
     * @param TableBuilder $builder
     */
    public function __construct(TableBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $table = $this->builder->getTable();

        /**
         * Set the default options handler based
         * on the builder class. Defaulting to
         * no handler.
         */
        if (!$table->getOption('options')) {

            $options = str_replace('TableBuilder', 'TableOptions', get_class($this->builder));

            if (class_exists($options)) {
                app()->call($options . '@handle', compact('builder', 'table'));
            }
        }

        /**
         * Set the default data handler based
         * on the builder class. Defaulting to
         * no handler.
         */
        if (!$table->getOption('data')) {

            $options = str_replace('TableBuilder', 'TableData', get_class($this->builder));

            if (class_exists($options)) {
                $table->setOption('data', $options . '@handle');
            }
        }

        /**
         * Set a optional entries handler based
         * on the builder class. Defaulting to
         * no handler in which case we will use
         * the model and included repositories.
         */
        if (!$table->getOption('entries')) {

            $entries = str_replace('TableBuilder', 'TableEntries', get_class($this->builder));

            if (class_exists($entries)) {
                $table->setOption('entries', $entries . '@handle');
            }
        }

        /**
         * Set the default options handler based
         * on the builder class. Defaulting to
         * no handler.
         */
        if (!$table->getOption('repository')) {

            $model = $table->getModel();

            if (!$table->getOption('repository') && $model instanceof EntryModel) {
                $table->setOption('repository', 'Anomaly\Streams\Platform\Entry\EntryTableRepository');
            } elseif (!$table->getOption('repository') && $model instanceof EloquentModel) {
                $table->setOption('repository', 'Anomaly\Streams\Platform\Model\EloquentTableRepository');
            }
        }

        /**
         * Set the default ordering options.
         */
        if (!$table->getOption('order_by')) {

            $model = $table->getModel();

            if ($model instanceof EntryModel) {
                if ($table->getOption('sortable') || $model->titleColumnIsTranslatable()) {
                    $table->setOption('order_by', ['sort_order' => 'asc']);
                } else {
                    $table->setOption('order_by', [$model->getTitleName() => 'asc']);
                }
            } elseif ($model instanceof EloquentModel) {
                $table->setOption('order_by', ['id' => 'asc']);
            }
        }

        /**
         * If the table ordering is currently being overridden
         * then set the values from the request on the builder
         * last so it actually has an effect.
         */
        if ($orderBy = $this->builder->getRequestValue('order_by')) {
            $table->setOption('order_by', [$orderBy => $this->builder->getRequestValue('sort', 'asc')]);
        }
    }
}
