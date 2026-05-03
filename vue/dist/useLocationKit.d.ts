export declare function useLocationKit(): {
    locationKit: import("vue").ComputedRef<import(".").LocationKitSharedData>;
    countries: import("vue").ComputedRef<import(".").LocationCountry[]>;
    states: import("vue").ComputedRef<import(".").LocationState[]>;
    cities: import("vue").ComputedRef<import(".").LocationCity[]>;
    currencies: import("vue").ComputedRef<import(".").LocationCurrency[]>;
    timezones: import("vue").ComputedRef<import(".").LocationTimezone[]>;
    dialCodes: import("vue").ComputedRef<import(".").LocationDialCode[]>;
    statesForCountry: (countryKey: string | number) => import(".").LocationState[];
    citiesForState: (stateKey: string | number) => import(".").LocationCity[];
    findCountry: (countryKey: string | number) => import(".").LocationCountry | undefined;
    findDialCode: (countryKey: string | number) => import(".").LocationDialCode | undefined;
    callingCodeForCountry: (countryKey: string | number) => string | null;
    phoneMaxLength: (countryKey: string | number) => number | null;
    localPhoneDigits: (countryKey: string | number, value: string) => string;
    maskPhone: (countryKey: string | number, value: string) => string;
};
