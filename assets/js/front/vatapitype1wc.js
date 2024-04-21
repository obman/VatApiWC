import {VatIdToName} from "./VatApiCoreWC/VatIdToName.js";

((that) => {
    const
        document = that.document,
        vatapiwc = that.vatapiwc
    ;

    that.window.addEventListener('load', () => {
        const vatIdToName = new VatIdToName(
            document,
            vatapiwc.base_url + '/api/vat/v1/validate-vat-id',
            vatapiwc.bearer_token,
            vatapiwc.license_key,
            vatapiwc.domain,
            vatapiwc.company_name_field_id,
            vatapiwc.vatid_field_id,
            vatapiwc.country_field_id,
            vatapiwc.address_field_id,
            vatapiwc.zip_field_id,
            vatapiwc.city_field_id
        );

        vatIdToName.getVatIdElement().addEventListener('focusout', () => {
            vatIdToName.apiCallVatIdToName();
        });
    });
})(window);