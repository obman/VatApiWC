<?php

namespace VatApiPluginSettings;

use http\Exception\InvalidArgumentException;
use VatApiPluginSettings\SectionSettings\InterfaceSectionSettings;
use VatApiPluginSettings\SectionSettings\ApiCredentials;
use VatApiPluginSettings\SectionSettings\LicenseKey;
use VatApiPluginSettings\SectionSettings\ApiTypeSection;
use VatApiPluginSettings\SectionSettings\EventHandlerFieldsSection;

class VatApiSectionSettingsFactory
{
    public static function create(string $sectionType): InterfaceSectionSettings
    {
        return match ($sectionType) {
			'ApiCredentials' => new ApiCredentials(),
	        'LicenseKey' => new LicenseKey(),
            'ApiType' => new ApiTypeSection(),
            'EventHandlerFields' => new EventHandlerFieldsSection(),
            default => throw new InvalidArgumentException("Invalid section type: $sectionType"),
        };
    }
}