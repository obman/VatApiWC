<?php

namespace VatApiPluginSettings\SectionSettings;

class ApiCredentials implements InterfaceSectionSettings {

	public function setupSection(): void
	{
		add_settings_section(
			'api-credentials-section',
			__('API Credentials', 'vatapiwc'),
			false,
			VATAPI_MENU_SLUG
		);
	}
}