<?php

namespace VatApiPluginSettings\FieldSettings;

use VatApiPluginSettings\FieldSettings\InterfaceFieldSettings;

class ApiBearerTokenField implements InterfaceFieldSettings
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
            'vatapi-api-bearer-token-field',
            __('Bearer Token:', 'vatapiwc'),
            array($this, 'renderFieldsHTML'),
	        VATAPI_MENU_SLUG,
            'api-credentials-section'
        );
    }

    public function renderFieldsHTML(): void
    {
        $options = get_option($this->options_name);

        if (isset($options[$this->field_name])) {
            echo sprintf('<input id="%1$s" name="%2$s[%1$s]" type="text" value="%3$s" readonly>', $this->field_name, $this->options_name, $options[$this->field_name]);
        }
        else {
            echo sprintf('<input id="%1$s" name="%2$s[%1$s]" type="text" value="" readonly>', $this->field_name, $this->options_name);
        }
    }
}