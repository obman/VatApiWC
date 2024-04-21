export class VatIdToName {
    constructor(document, api_url, bearer_token, license, domain, company_target, vatid_target, country_target, address_target, zip_target, city_target) {
        this.apiUrl         = api_url;
        this.bearerToken    = bearer_token;
        this.license        = license;
        this.domain         = domain;
        this.companyElement = document.querySelector(company_target);
        this.vatidElement   = document.querySelector(vatid_target);
        this.countryElement = document.querySelector(country_target);
        this.addressElement = document.querySelector(address_target);
        this.zipElement     = document.querySelector(zip_target);
        this.cityElement    = document.querySelector(city_target);
    }

    getVatIdElement() {
        return this.vatidElement;
    }

    async apiCallVatIdToName() {
        const
            vatId       = this.vatidElement.value,
            countryCode = this.countryElement.options[this.countryElement.selectedIndex].value,
            response = await fetch(
                this.apiUrl,
                {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + this.bearerToken
                    },
                    body: JSON.stringify({
                        'vatid': vatId,
                        'country': countryCode,
                        'license': this.license,
                        'domain': this.domain
                    })
                }
            )
        ;

        if (! response.ok) {
            return false;
        }

        const companyData = await response.json();

        if (! companyData) {
            return false;
        }

        if (companyData.name) {
            this.companyElement.value = companyData.name;
        }
        if (companyData.address) {
            this.addressElement.value = companyData.address;
        }
        if (companyData.zip) {
            this.zipElement.value = companyData.zip;
        }
        if (companyData.city) {
            this.cityElement.value = companyData.city;
        }
    }
}