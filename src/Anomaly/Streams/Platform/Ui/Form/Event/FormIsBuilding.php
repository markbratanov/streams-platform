<?php namespace Anomaly\Streams\Platform\Ui\Form\Event;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

class FormIsBuilding
{

    protected $builder;

    function __construct(FormBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function getBuilder()
    {
        return $this->builder;
    }
}
 