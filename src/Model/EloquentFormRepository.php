<?php namespace Anomaly\Streams\Platform\Model;

use Anomaly\Streams\Platform\Ui\Form\Contract\FormRepository;
use Anomaly\Streams\Platform\Ui\Form\Form;

/**
 * Class EloquentFormRepository
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Model
 */
class EloquentFormRepository implements FormRepository
{

    /**
     * The form model.
     *
     * @var EloquentModel
     */
    protected $model;

    /**
     * Create a new EloquentFormRepository instance.
     *
     * @param EloquentModel $model
     */
    public function __construct(EloquentModel $model)
    {
        $this->model = $model;
    }

    /**
     * Find an entry.
     *
     * @param $id
     * @return EloquentModel
     */
    public function findOrNew($id)
    {
        $entry = $this->model->find($id);

        if (!$entry) {
            $entry = $this->model->newInstance();
        }

        return $entry;
    }

    /**
     * Save the form.
     *
     * @param Form $form
     */
    public function save(Form $form)
    {
        throw new \Exception('Not implemented.');
    }
}