<?php namespace Anomaly\Streams\Platform\Assignment;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Model\EloquentCollection;

/**
 * Class AssignmentCollection
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Assignment
 */
class AssignmentCollection extends EloquentCollection
{

    /**
     * Find an assignment by it's field slug.
     *
     * @param  $slug
     * @return AssignmentInterface
     */
    public function findByFieldSlug($slug)
    {
        foreach ($this->items as $item) {
            /* @var AssignmentInterface $item */
            if ($item->getFieldSlug() == $slug) {
                return $item;
            }
        }

        return null;
    }


    /**
     * Find all fields using
     * the provided field type.
     *
     * @param $namespace
     * @return static
     */
    public function findAllByFieldType($namespace)
    {
        return new static(
            array_filter(
                $this->items,
                function (AssignmentInterface $assignment) use ($namespace) {
                    return $assignment->getFieldTypeValue() == $namespace;
                }
            )
        );
    }

    /**
     * Return assignments only included the provided fields.
     *
     * @param array $fields
     * @return AssignmentCollection
     */
    public function withFields(array $fields)
    {
        return new static(
            array_filter(
                array_map(
                    function (AssignmentInterface $assignment) use ($fields) {
                        return in_array($assignment->getFieldSlug(), $fields) ? $assignment : null;
                    },
                    $this->items
                )
            )
        );
    }

    /**
     * Return assignments not included the provided fields.
     *
     * @param array $fields
     * @return AssignmentCollection
     */
    public function withoutFields(array $fields)
    {
        return new static(
            array_filter(
                array_map(
                    function (AssignmentInterface $assignment) use ($fields) {
                        return !in_array($assignment->getFieldSlug(), $fields) ? $assignment : null;
                    },
                    $this->items
                )
            )
        );
    }

    /**
     * Return only assignments that have relation fields.
     *
     * @return AssignmentCollection
     */
    public function relations()
    {
        $relations = [];

        /* @var AssignmentInterface $item */
        /* @var FieldType $type */
        foreach ($this->items as $item) {

            $type = $item->getFieldType();

            if (method_exists($type, 'getRelation')) {
                $relations[] = $item;
            }
        }

        return self::make($relations);
    }

    /**
     * Return only assignments that have date fields.
     *
     * @return AssignmentCollection
     */
    public function dates()
    {
        $dates = [];

        /* @var AssignmentInterface $item */
        /* @var FieldType $type */
        foreach ($this->items as $item) {

            $type = $item->getFieldType();

            if (in_array($type->getColumnType(), ['date', 'datetime'])) {
                $dates[] = $item;
            }
        }

        return self::make($dates);
    }

    /**
     * Return only assignments that are translatable.
     *
     * @return AssignmentCollection
     */
    public function translatable()
    {
        $translatable = [];

        /* @var AssignmentInterface $item */
        foreach ($this->items as $item) {
            if ($item->isTranslatable()) {
                $translatable[] = $item;
            }
        }

        return self::make($translatable);
    }

    /**
     * Return only assignments that are NOT translatable.
     *
     * @return AssignmentCollection
     */
    public function notTranslatable()
    {
        $translatable = [];

        /* @var AssignmentInterface $item */
        foreach ($this->items as $item) {
            if (!$item->isTranslatable()) {
                $translatable[] = $item;
            }
        }

        return self::make($translatable);
    }

    /**
     * Return an array of field slugs.
     *
     * @return array
     */
    public function fieldSlugs()
    {
        $slugs = [];

        /* @var AssignmentInterface $item */
        foreach ($this->items as $item) {
            $slugs[] = $item->getFieldSlug();
        }

        return $slugs;
    }

    /**
     * Return only assignments with locked fields.
     *
     * @return AssignmentCollection
     */
    public function locked()
    {
        $items = [];

        foreach ($this->items as $item) {
            if ($item instanceof AssignmentInterface && $field = $item->getField()) {
                if ($field->isLocked()) {
                    $items[] = $item;
                }
            }
        }

        return new static($items);
    }

    /**
     * Return only assignments with fields
     * that are not locked.
     *
     * @return AssignmentCollection
     */
    public function notLocked()
    {
        $items = [];

        foreach ($this->items as $item) {
            if ($item instanceof AssignmentInterface && $field = $item->getField()) {
                if (!$field->isLocked()) {
                    $items[] = $item;
                }
            }
        }

        return new static($items);
    }
}
