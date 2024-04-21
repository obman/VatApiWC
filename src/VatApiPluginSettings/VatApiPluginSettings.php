<?php

namespace VatApiPluginSettings;

class VatApiPluginSettings
{
    public function renderSettingsSection(string $sectionType): void
    {
        $sectionSettings = VatApiSectionSettingsFactory::create($sectionType);
        $sectionSettings->setupSection();
    }

    public function renderSettingsFields(string $fieldType, string $options_name, string $field_name): void
    {
        $fieldSettings = VatApiFieldSettingsFactory::create($fieldType, $options_name, $field_name);
        $fieldSettings->setupFields();
    }
}