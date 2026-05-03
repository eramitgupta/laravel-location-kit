import type { PageProps as InertiaPageProps } from '@inertiajs/core';
import type { LocationKitSharedData } from './location';
export interface PageProps extends InertiaPageProps {
    locationKit?: LocationKitSharedData;
}
