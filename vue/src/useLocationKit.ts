import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import type { PageProps } from './types/page'
import {
    callingCodeForCountry,
    citiesForState,
    findCountry,
    findDialCode,
    localPhoneDigitsForCountry,
    maskPhoneForCountry,
    phoneMaxLengthForCountry,
    statesForCountry
} from './types/helpers'

export function useLocationKit() {
    const page = usePage<PageProps>()
    const locationKit = computed(() => page.props.locationKit ?? {})

    const countries = computed(() => locationKit.value.countries ?? [])
    const states = computed(() => locationKit.value.states ?? [])
    const cities = computed(() => locationKit.value.cities ?? [])
    const currencies = computed(() => locationKit.value.currencies ?? [])
    const timezones = computed(() => locationKit.value.timezones ?? [])
    const dialCodes = computed(() => locationKit.value.dialCodes ?? [])

    return {
        locationKit,
        countries,
        states,
        cities,
        currencies,
        timezones,
        dialCodes,
        statesForCountry: (countryKey: string | number) =>
            statesForCountry(states.value, countryKey),
        citiesForState: (stateKey: string | number) => citiesForState(cities.value, stateKey),
        findCountry: (countryKey: string | number) => findCountry(countries.value, countryKey),
        findDialCode: (countryKey: string | number) => findDialCode(dialCodes.value, countryKey),
        callingCodeForCountry: (countryKey: string | number) =>
            callingCodeForCountry(countries.value, countryKey),
        phoneMaxLength: (countryKey: string | number) =>
            phoneMaxLengthForCountry(countries.value, countryKey),
        localPhoneDigits: (countryKey: string | number, value: string) =>
            localPhoneDigitsForCountry(countries.value, countryKey, value),
        maskPhone: (countryKey: string | number, value: string) =>
            maskPhoneForCountry(countries.value, countryKey, value)
    }
}
