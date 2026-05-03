export declare function useLocationKit(): {
    locationKit: import(".").LocationKitSharedData;
    countries: import(".").LocationCountry[];
    states: import(".").LocationState[];
    cities: import(".").LocationCity[];
    currencies: import(".").LocationCurrency[];
    timezones: import(".").LocationTimezone[];
    dialCodes: import(".").LocationDialCode[];
    statesForCountry: (countryKey: string | number) => import(".").LocationState[];
    citiesForState: (stateKey: string | number) => import(".").LocationCity[];
    findCountry: (countryKey: string | number) => import(".").LocationCountry | undefined;
    findDialCode: (countryKey: string | number) => import(".").LocationDialCode | undefined;
    callingCodeForCountry: (countryKey: string | number) => string | null;
    phoneMaxLength: (countryKey: string | number) => number | null;
    localPhoneDigits: (countryKey: string | number, value: string) => string;
    maskPhone: (countryKey: string | number, value: string) => string;
};
