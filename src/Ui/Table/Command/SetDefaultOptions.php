<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Model\EloquentModel;
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
     *
     * @param ModuleCollection $modules
     */
    public function handle(ModuleCollection $modules)
    {
        $table = $this->builder->getTable();

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
         * Set the default sortable option.
         */
        if ($table->getOption('sortable') === null) {

            $model = $table->getModel();

            if ($model instanceof EntryModel) {
                if ($table->getOption('sortable')) {
                    $table->setOption('sortable', true);
                }
            }
        }

        /**
         * Set the default breadcrumb.
         */
        if ($table->getOption('breadcrumb') === null && $title = $table->getOption('title')) {
            $table->setOption('breadcrumb', $title);
        }

        /**
         * If the table ordering is currently being overridden
         * then set the values from the request on the builder
         * last so it actually has an effect.
         */
        if ($orderBy = $this->builder->getRequestValue('order_by')) {
            $table->setOption('order_by', [$orderBy => $this->builder->getRequestValue('sort', 'asc')]);
        }

        /**
         * If the permission is not set then
         * try and automate it.
         */
        if ($table->getOption('permission') === null && ($module = $modules->active(
            )) && ($stream = $this->builder->getTableStream())
        ) {
            $table->setOption('permission', $module->getNamespace($stream->getSlug() . '.read'));
        }
    }
}
