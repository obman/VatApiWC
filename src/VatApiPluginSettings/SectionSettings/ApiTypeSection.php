<?php

namespace VatApiPluginSettings\SectionSettings;

class ApiTypeSection implements InterfaceSectionSettings
{
    public function setupSection(): void
    {
        add_settings_section(
            'api-type-radio-section',
            __('Which type of geocoding API', 'vatapiwc'),
            false,
	        VATAPI_MENU_SLUG
        );
    }
}