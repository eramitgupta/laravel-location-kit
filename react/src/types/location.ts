export type LocationKey = string | number | null | undefined

export interface LocationCountry {
    name: string
    key: string
    countryCodes?: string[]
    isoCode2?: string
    isoCode3?: string
    iso2?: string
    iso3?: string
    flag?: string
    flag_url?: string
    currency_code?: string
    phone_length?: number
    phone_lengths?: number[]
    phone_max_length?: number
    phoneLength?: number
    phoneLengths?: number[]
    phoneMaxLength?: number
    [key: string]: unknown
}

export interface LocationState {
    name: string
    key: string
    country_key?: string | null
    [key: string]: unknown
}

export interface LocationCity {
    name: string
    key: string
    state_key?: string | null
    [key: string]: unknown
}

export interface LocationCurrency {
    code: string
    name?: string
    symbol?: string
    countries?: string[]
    [key: string]: unknown
}

export interface LocationTimezone {
    name: string
    key: string
    offset?: string
    [key: string]: unknown
}

export interface LocationDialCode {
    label?: string
    value?: string
    country?: string
    country_code?: string
    dial_code?: string
    countryCodes?: string[]
    isoCode2?: string
    isoCode3?: string
    [key: string]: unknown
}

export interface LocationKitSharedData {
    countries?: LocationCountry[]
    states?: LocationState[]
    cities?: LocationCity[]
    currencies?: LocationCurrency[]
    timezones?: LocationTimezone[]
    dialCodes?: LocationDialCode[]
}
