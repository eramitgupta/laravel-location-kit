import { useMemo } from 'react'
import { usePage } from '@inertiajs/react'
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
  const { locationKit = {} } = usePage<PageProps>().props

  const countries = locationKit.countries ?? []
  const states = locationKit.states ?? []
  const cities = locationKit.cities ?? []
  const currencies = locationKit.currencies ?? []
  const timezones = locationKit.timezones ?? []
  const dialCodes = locationKit.dialCodes ?? []

  return useMemo(
    () => ({
      locationKit,
      countries,
      states,
      cities,
      currencies,
      timezones,
      dialCodes,
      statesForCountry: (countryKey: string | number) => statesForCountry(states, countryKey),
      citiesForState: (stateKey: string | number) => citiesForState(cities, stateKey),
      findCountry: (countryKey: string | number) => findCountry(countries, countryKey),
      findDialCode: (countryKey: string | number) => findDialCode(dialCodes, countryKey),
      callingCodeForCountry: (countryKey: string | number) =>
        callingCodeForCountry(countries, countryKey),
      phoneMaxLength: (countryKey: string | number) =>
        phoneMaxLengthForCountry(countries, countryKey),
      localPhoneDigits: (countryKey: string | number, value: string) =>
        localPhoneDigitsForCountry(countries, countryKey, value),
      maskPhone: (countryKey: string | number, value: string) =>
        maskPhoneForCountry(countries, countryKey, value)
    }),
    [cities, countries, currencies, dialCodes, locationKit, states, timezones]
  )
}
