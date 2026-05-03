import type {
    LocationCity,
    LocationCountry,
    LocationDialCode,
    LocationKey,
    LocationState
} from './location'
import { PHONE_METADATA } from './phoneMetadata'

export function normalizeKey(value: LocationKey): string {
    return String(value ?? '')
        .trim()
        .toLowerCase()
        .replace(/[^a-z0-9]+/gi, '-')
        .replace(/^-+|-+$/g, '')
}

export function statesForCountry(
    states: LocationState[] = [],
    countryKey: LocationKey
): LocationState[] {
    const key = normalizeKey(countryKey)

    return states.filter((state) => normalizeKey(state.country_key) === key)
}

export function citiesForState(cities: LocationCity[] = [], stateKey: LocationKey): LocationCity[] {
    const key = normalizeKey(stateKey)

    return cities.filter((city) => normalizeKey(city.state_key) === key)
}

export function findCountry(
    countries: LocationCountry[] = [],
    countryKey: LocationKey
): LocationCountry | undefined {
    const key = normalizeKey(countryKey)

    return countries.find((country) =>
        [country.key, country.name, country.isoCode2, country.isoCode3, country.iso2, country.iso3]
            .filter(Boolean)
            .some((value) => normalizeKey(value as LocationKey) === key)
    )
}

export function callingCodeForCountry(
    countries: LocationCountry[] = [],
    countryKey: LocationKey
): string | null {
    const country = findCountry(countries, countryKey)
    const code = country?.countryCodes?.[0]

    return code ? `+${code}` : null
}

export function phoneLengthsForCountry(
    countries: LocationCountry[] = [],
    countryKey: LocationKey
): number[] {
    const country = findCountry(countries, countryKey)
    const configured = normalizeLengths(
        country?.phone_lengths ??
            country?.phoneLengths ??
            country?.phone_length ??
            country?.phoneLength ??
            country?.phone_max_length ??
            country?.phoneMaxLength
    )

    if (configured.length > 0) return configured

    const metadata = phoneMetadataForCountry(country)

    return metadata?.lengths ?? []
}

export function phoneMaxLengthForCountry(
    countries: LocationCountry[] = [],
    countryKey: LocationKey
): number | null {
    const lengths = phoneLengthsForCountry(countries, countryKey)
    const callingCode = callingCodeForCountry(countries, countryKey)

    if (lengths.length > 0) return Math.max(...lengths)

    if (callingCode) {
        return Math.max(1, 15 - callingCode.replace(/\D/g, '').length)
    }

    return null
}

export function localPhoneDigitsForCountry(
    countries: LocationCountry[] = [],
    countryKey: LocationKey,
    value: string
): string {
    const callingCode = callingCodeForCountry(countries, countryKey)
    const callingDigits = callingCode?.replace(/\D/g, '') ?? ''
    const digits = value.replace(/\D/g, '')
    const local =
        callingDigits && digits.startsWith(callingDigits)
            ? digits.slice(callingDigits.length)
            : digits
    const maxLength = phoneMaxLengthForCountry(countries, countryKey)

    return maxLength ? local.slice(0, maxLength) : local
}

export function findDialCode(
    dialCodes: LocationDialCode[] = [],
    countryKey: LocationKey
): LocationDialCode | undefined {
    const key = normalizeKey(countryKey)

    return dialCodes.find((dialCode) =>
        [
            dialCode.country,
            dialCode.country_code,
            dialCode.isoCode2,
            dialCode.isoCode3,
            dialCode.value
        ]
            .filter(Boolean)
            .some((value) => normalizeKey(value as LocationKey) === key)
    )
}

export function maskPhoneForCountry(
    countries: LocationCountry[] = [],
    countryKey: LocationKey,
    value: string
): string {
    const callingCode = callingCodeForCountry(countries, countryKey)
    const country = findCountry(countries, countryKey)
    const local = localPhoneDigitsForCountry(countries, countryKey, value)

    if (!callingCode) return groupDigits(local)

    return `${callingCode} ${formatLocalPhone(country, local)}`.trim()
}

function groupDigits(value: string, size = 3): string {
    const pattern = new RegExp(`(\\d{${size}})(?=\\d)`, 'g')

    return value.replace(pattern, '$1 ').trim()
}

function formatLocalPhone(country: LocationCountry | undefined, local: string): string {
    const metadata = phoneMetadataForCountry(country)
    const maxLength = Math.max(...(metadata?.lengths ?? [local.length]))

    if (maxLength === 10 && local.length === 10) {
        const iso2 = countryIso2(country)

        if (iso2 === 'US' || iso2 === 'CA') {
            return `(${local.slice(0, 3)}) ${local.slice(3, 6)}-${local.slice(6)}`
        }

        if (iso2 === 'IN') {
            return `${local.slice(0, 5)} ${local.slice(5)}`
        }
    }

    return groupByPattern(local, metadata?.groups ?? [])
}

function normalizeLengths(value: unknown): number[] {
    const values = Array.isArray(value) ? value : [value]

    return values
        .map((length) => Number(length))
        .filter((length) => Number.isInteger(length) && length > 0)
}

function phoneMetadataForCountry(
    country?: LocationCountry
): { lengths: number[]; groups: number[] } | null {
    const iso2 = countryIso2(country)

    if (!iso2) return null

    return PHONE_METADATA[iso2] ?? null
}

function groupByPattern(value: string, groups: number[]): string {
    if (value === '') return ''

    if (groups.length === 0) return groupDigits(value)

    const parts = []
    let cursor = 0

    for (const group of groups) {
        if (cursor >= value.length) break

        parts.push(value.slice(cursor, cursor + group))
        cursor += group
    }

    if (cursor < value.length) {
        parts.push(value.slice(cursor))
    }

    return parts.filter(Boolean).join(' ')
}

function countryIso2(country?: LocationCountry): string | null {
    const iso2 = String(country?.isoCode2 ?? country?.iso2 ?? '').toUpperCase()

    return /^[A-Z]{2}$/.test(iso2) ? iso2 : null
}
