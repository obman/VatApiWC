<?php

namespace VatApiPluginSettings\FieldSettings;

use VatApiPluginSettings\FieldSettings\InterfaceFieldSettings;

class GetBearerTokenButton implements InterfaceFieldSettings
{
    private string $options_name;
    private string $field_name;

    public function __construct(string $options_name, string $field_name)
    {
        $this->options_name = $options_name;
        $this->field_name   = $field_name;
    }

    public function setupFields(): void
    {
        add_settings_field(
            'vatapi-get-bearer-token-button',
            __('Activate API', 'vatapiwc'),
            array($this, 'renderFieldsHTML'),
	        VATAPI_MENU_SLUG,
            'api-credentials-section'
        );
    }

    public function renderFieldsHTML(): void
    {
        $options = get_option($this->options_name);

		echo '<button type="button" id="vatapi-get-bearer-token-button" class="button button-primary">' . __('Activate API', 'vatapiwc') . '</button>';
    }
}