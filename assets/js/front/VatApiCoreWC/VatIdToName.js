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

    getApiUrl() {
        return this.apiUrl;
    }

    getBearerToken() {
        return this.bearerToken;
    }

    getLicense() {
        return this.license;
    }

    getDomain() {
        return this.domain;
    }

    getCompanyElement() {
        return this.companyElement;
    }

    getVatIdElement() {
        return this.vatidElement;
    }

    getCountryElement() {
        return this.countryElement;
    }

    getAddressElement() {
        return this.addressElement;
    }

    getZipElement() {
        return this.zipElement;
    }

    getCityElement() {
        return this.cityElement;
    }

    async apiCallVatIdToName() {
        const
            vatId       = this.vatidElement.value,
            countryCode = this.countryElement.options[this.countryElement.selectedIndex].value,
            response = await fetch(
                this.getApiUrl(),
                {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + this.getBearerToken()
                    },
                    body: JSON.stringify({
                        'vatid': vatId,
                        'country': countryCode,
                        'license': this.getLicense(),
                        'domain': this.getDomain()
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

        if (! companyData.name || ! companyData.address) {
            return false;
        }

        const addressArray = companyData.address.split(', ');
        const fullString = addressArray[2];
        const zipCodeMatch = fullString.match(/^\d{4}/);

        if (zipCodeMatch) {
            const zipCode = zipCodeMatch[0];
            this.getZipElement().value = zipCodeMatch[0];
        } else {
            // console.log("No zip code found");
        }

        this.getCompanyElement().value = companyData.name;
        this.getAddressElement().value = addressArray[0];
        this.getCityElement().value = addressArray[1];
    }
}