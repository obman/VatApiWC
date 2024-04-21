<?php

namespace VatApiPluginSettings\SectionSettings;

class EventHandlerFieldsSection implements InterfaceSectionSettings
{
    public function setupSection(): void
    {
        add_settings_section(
            'event-handler-fields-section',
            __('IDs of checkout fields', 'vatapiwc'),
            array($this, 'additionalSectionInfo'),
	        VATAPI_MENU_SLUG
        );
    }

    public function additionalSectionInfo(): ?string
    {
        return __('Enter the ID values of the input badges adapted to your needs', 'vatapiwc');
    }
}