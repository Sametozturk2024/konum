<?php

namespace App\Services;

/**
 * Class distanceCalculation.
 */
class distanceCalculation
{
public  function distance($lat1, $lon1, $lat2, $lon2): float{

        $unit = 'km';
        // Dünya yarıçapı (km veya mile göre)
        $earthRadius = ($unit === 'mi') ? 3959 : 6371;

        // Dereceyi Radyana çevir
        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        // Farklar
        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        // Haversine Formülü
        $angle = 2 * asin(
                sqrt(
                    pow(sin($latDelta / 2), 2) +
                    cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)
                )
            );

        // Mesafe
        $distance = round($angle * $earthRadius, 2);

        return $distance;


}



}
