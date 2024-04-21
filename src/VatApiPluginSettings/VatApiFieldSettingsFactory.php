<?php

namespace VatApiPluginSettings;

use http\Exception\InvalidArgumentException;
use VatApiPluginSettings\FieldSettings\AddressField;
use VatApiPluginSettings\FieldSettings\CityField;
use VatApiPluginSettings\FieldSettings\CountryInputIdField;
use VatApiPluginSettings\FieldSettings\InterfaceFieldSettings;
use VatApiPluginSettings\FieldSettings\ApiBearerTokenField;
use VatApiPluginSettings\FieldSettings\ApiClientIdField;
use VatApiPluginSettings\FieldSettings\ApiClientSecretField;
use VatApiPluginSettings\FieldSettings\GetBearerTokenButton;
use VatApiPluginSettings\FieldSettings\LicenseKeyField;
use VatApiPluginSettings\FieldSettings\ApiTypeField;
use VatApiPluginSettings\FieldSettings\CompanyNameField;
use VatApiPluginSettings\FieldSettings\VatIdField;
use VatApiPluginSettings\FieldSettings\ZipField;

class VatApiFieldSettingsFactory
{
    public static function create(string $fieldType, string $options_name, string $field_name): InterfaceFieldSettings
    {
        return match ($fieldType) {
			'ApiClientIDField' => new ApiClientIdField($options_name, $field_name),
	        'ApiClientSecretField' => new ApiClientSecretField($options_name, $field_name),
	        'ApiBearerTokenField' => new ApiBearerTokenField($options_name, $field_name),
	        'GetBearerTokenButton' => new GetBearerTokenButton($options_name, $field_name),
	        'LicenseKeyField' => new LicenseKeyField($options_name, $field_name),
            'ApiTypeField' => new ApiTypeField($options_name, $field_name),
            'CountryField' => new CountryInputIdField($options_name, $field_name),
            'CompanyNameField' => new CompanyNameField($options_name, $field_name),
            'VatIdField' => new VatIdField($options_name, $field_name),
            'AddressField' => new AddressField($options_name, $field_name),
            'ZipField' => new ZipField($options_name, $field_name),
            'CityField' => new CityField($options_name, $field_name),
            default => throw new InvalidArgumentException("Invalid field type: $fieldType"),
        };
    }
}