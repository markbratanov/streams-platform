<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Component\Action\Command\BuildActions;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\Command\SetActiveAction;
use Anomaly\Streams\Platform\Ui\Form\Component\Button\Command\BuildButtons;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\Command\BuildFields;
use Anomaly\Streams\Platform\Ui\Form\Component\Section\Command\BuildSections;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class BuildForm
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class BuildForm implements SelfHandling
{

    use DispatchesJobs;

    /**
     * The form builder.
     *
     * @var FormBuilder
     */
    protected $builder;

    /**
     * Create a new BuildFormColumnsCommand instance.
     *
     * @param FormBuilder $builder
     */
    public function __construct(FormBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        /**
         * Setup some objects and options using
         * provided input or sensible defaults.
         */
        $this->dispatch(new SetFormModel($this->builder));
        $this->dispatch(new SetFormStream($this->builder));
        $this->dispatch(new SetDefaultParameters($this->builder));
        $this->dispatch(new SetRepository($this->builder));

        $this->dispatch(new SetFormOptions($this->builder));
        $this->dispatch(new SetDefaultOptions($this->builder));
        $this->dispatch(new SetFormEntry($this->builder)); // Do this last.

        /**
         * Before we go any further, authorize the request.
         */
        $this->dispatch(new AuthorizeForm($this->builder));

        /*
         * Build form fields.
         */
        $this->dispatch(new BuildFields($this->builder));

        /**
         * Build form sections.
         */
        $this->dispatch(new BuildSections($this->builder));

        /**
         * Build form actions and flag active.
         */
        $this->dispatch(new BuildActions($this->builder));
        $this->dispatch(new SetActiveAction($this->builder));

        /**
         * Build form buttons.
         */
        $this->dispatch(new BuildButtons($this->builder));
    }
}
