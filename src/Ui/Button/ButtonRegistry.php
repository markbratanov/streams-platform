<?php namespace Anomaly\Streams\Platform\Ui\Button;

/**
 * Class ButtonRegistry
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\Button
 */
class ButtonRegistry
{

    /**
     * Available buttons.
     *
     * @var array
     */
    protected $buttons = [
        /**
         * Default Buttons
         */
        'default'     => [
            'type' => 'default'
        ],
        /**
         * Link Buttons
         */
        'cancel'      => [
            'text' => 'streams::button.cancel',
            'type' => 'link'
        ],
        /**
         * Success Buttons
         */
        'green'       => [
            'type' => 'success'
        ],
        'success'     => [
            'icon' => 'check',
            'type' => 'success'
        ],
        'save'        => [
            'text' => 'streams::button.save',
            'icon' => 'save',
            'type' => 'success'
        ],
        'create'      => [
            'text' => 'streams::button.create',
            'icon' => 'fa fa-asterisk',
            'type' => 'success'
        ],
        'new'         => [
            'icon' => 'fa fa-plus',
            'type' => 'success'
        ],
        'add'         => [
            'icon' => 'fa fa-plus',
            'type' => 'success'
        ],
        'send'        => [
            'text' => 'streams::button.send',
            'icon' => 'envelope',
            'type' => 'success'
        ],
        'submit'      => [
            'text' => 'streams::button.submit',
            'type' => 'success'
        ],
        'install'     => [
            'text' => 'streams::button.install',
            'icon' => 'download',
            'type' => 'success'
        ],
        'entries'     => [
            'text' => 'streams::button.entries',
            'icon' => 'list-ol',
            'type' => 'success'
        ],
        'done'        => [
            'text' => 'streams::button.done',
            'type' => 'success',
            'icon' => 'check'
        ],
        'select'      => [
            'text' => 'streams::button.select',
            'type' => 'success',
            'icon' => 'check'
        ],
        'finish'      => [
            'text' => 'streams::button.finish',
            'type' => 'success',
            'icon' => 'check'
        ],
        'finished'    => [
            'text' => 'streams::button.finished',
            'type' => 'success',
            'icon' => 'check'
        ],
        /**
         * Info Buttons
         */
        'blue'        => [
            'type' => 'info'
        ],
        'info'        => [
            'icon' => 'fa fa-info',
            'type' => 'info'
        ],
        'help'        => [
            'icon'        => 'circle-question-mark',
            'text'        => 'streams::button.help',
            'type'        => 'info',
            'data-toggle' => 'modal',
            'data-target' => '#modal'
        ],
        'view'        => [
            'text' => 'streams::button.view',
            'icon' => 'fa fa-eye',
            'type' => 'info'
        ],
        'fields'      => [
            'text' => 'streams::button.fields',
            'icon' => 'list-alt',
            'type' => 'info'
        ],
        'assignments' => [
            'text' => 'streams::button.fields',
            'icon' => 'list-alt',
            'type' => 'info'
        ],
        'settings'    => [
            'text' => 'streams::button.settings',
            'type' => 'info',
            'icon' => 'cog',
        ],
        'configure'   => [
            'text' => 'streams::button.configure',
            'icon' => 'wrench',
            'type' => 'info'
        ],
        /**
         * Warning Buttons
         */
        'orange'      => [
            'type' => 'warning'
        ],
        'warning'     => [
            'icon' => 'warning',
            'type' => 'warning'
        ],
        'edit'        => [
            'text' => 'streams::button.edit',
            'icon' => 'pencil',
            'type' => 'warning'
        ],
        /**
         * Danger Buttons
         */
        'red'         => [
            'type' => 'danger'
        ],
        'danger'      => [
            'icon' => 'fa fa-exclamation-circle',
            'type' => 'danger'
        ],
        'delete'      => [
            'text'       => 'streams::button.delete',
            'icon'       => 'trash',
            'type'       => 'danger',
            'attributes' => [
                'data-toggle'  => 'confirm',
                'data-message' => 'streams::message.confirm_delete'
            ]
        ],
        'confirm'     => [
            'type'       => 'danger',
            'attributes' => [
                'data-toggle'  => 'confirm',
                'data-message' => 'streams::message.confirm_delete'
            ]
        ],
        'prompt'      => [
            'type'       => 'danger',
            'attributes' => [
                'data-match'   => 'yes',
                'data-toggle'  => 'prompt',
                'data-message' => 'streams::message.prompt_delete'
            ]
        ],
        'uninstall'   => [
            'type'       => 'danger',
            'icon'       => 'times-circle',
            'text'       => 'streams::button.uninstall',
            'attributes' => [
                'data-toggle'  => 'confirm',
                'data-message' => 'streams::message.confirm_uninstall'
            ]
        ]
    ];

    /**
     * Get a button.
     *
     * @param  $button
     * @return array|null
     */
    public function get($button)
    {
        if (!$button) {
            return null;
        }

        return array_get($this->buttons, $button);
    }

    /**
     * Register a button.
     *
     * @param       $button
     * @param array $parameters
     * @return $this
     */
    public function register($button, array $parameters)
    {
        array_set($this->buttons, $button, $parameters);

        return $this;
    }
}
