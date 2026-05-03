<?php

namespace Erag\LocationKit\Support;

use Illuminate\Support\Facades\Blade;

class BladeDirectives
{
    public static function register(): void
    {
        Blade::directive('locationCountries', fn () => '<?php echo e(json_encode(location_countries())); ?>');
        Blade::directive('locationStates', fn ($expression) => "<?php echo e(json_encode(location_states({$expression}))); ?>");
        Blade::directive('locationCities', fn ($expression) => "<?php echo e(json_encode(location_cities({$expression}))); ?>");
    }
}
