<?php

namespace VatApiPluginSettings\SectionSettings;

class LicenseKey implements InterfaceSectionSettings
{
    public function setupSection(): void
    {
        add_settings_section(
            'license-key-section',
            __('License Key', 'vatapiwc'),
            false,
	        VATAPI_MENU_SLUG
        );
    }
}