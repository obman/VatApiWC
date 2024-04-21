<?php

namespace VatApiPluginSettings\FieldSettings;

interface InterfaceFieldSettings
{
    public function setupFields(): void;
    public function renderFieldsHTML(): void;
}