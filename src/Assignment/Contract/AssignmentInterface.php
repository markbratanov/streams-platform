<?php namespace Anomaly\Streams\Platform\Assignment\Contract;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Interface AssignmentInterface
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Assignment\Contract
 */
interface AssignmentInterface
{

    /**
     * Get the ID.
     *
     * @return null|integer
     */
    public function getId();

    /**
     * Get the related stream.
     *
     * @return StreamInterface
     */
    public function getStream();

    /**
     * Get the related stream's slug.
     *
     * @return string
     */
    public function getStreamSlug();

    /**
     * Get the related stream's prefix.
     *
     * @return string
     */
    public function getStreamPrefix();

    /**
     * Get the related field.
     *
     * @return FieldInterface
     */
    public function getField();

    /**
     * Get the related field ID.
     *
     * @return null|int
     */
    public function getFieldId();

    /**
     * Get the label.
     *
     * @return string
     */
    public function getLabel();

    /**
     * Get the warning.
     *
     * @return string
     */
    public function getWarning();

    /**
     * Get the instructions.
     *
     * @return string
     */
    public function getInstructions();

    /**
     * Get the placeholder.
     *
     * @return string
     */
    public function getPlaceholder();

    /**
     * Get the unique flag.
     *
     * @return bool
     */
    public function isUnique();

    /**
     * Get the required flag.
     *
     * @return bool
     */
    public function isRequired();

    /**
     * Get the translatable flag.
     *
     * @return bool
     */
    public function isTranslatable();

    /**
     * Get the field slug.
     *
     * @return mixed
     */
    public function getFieldSlug();

    /**
     * Get the assignment's field's type.
     *
     * @return FieldType
     */
    public function getFieldType();

    /**
     * Get the field type value. This helps
     * avoid spinning up a type instance
     * if you don't really need it.
     *
     * @return string
     */
    public function getFieldTypeValue();

    /**
     * Get the assignment's field's name.
     *
     * @return string
     */
    public function getFieldName();

    /**
     * Get the assignment's field's config.
     *
     * @return string
     */
    public function getFieldConfig();

    /**
     * Get the assignment's field's rules.
     *
     * @return array
     */
    public function getFieldRules();

    /**
     * Get the column name.
     *
     * @return mixed
     */
    public function getColumnName();

    /**
     * Get all attributes.
     *
     * @return mixed
     */
    public function getAttributes();

    /**
     * Get an attribute.
     *
     * @param  $key
     * @return mixed
     */
    public function getAttribute($key);

    /**
     * Flush the entry model's cache.
     *
     * @return AssignmentInterface
     */
    public function flushCache();

    /**
     * Compile the assignment's stream.
     *
     * @return AssignmentInterface
     */
    public function compileStream();
}
