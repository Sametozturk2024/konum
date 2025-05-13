<?php

namespace App\Services;

class DistanceCalculation
{
    public function distance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $unit = 'km';
        $earthRadius = $unit === 'mi' ? 3959 : 6371;

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo   = deg2rad($lat2);
        $lonTo   = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(
                sqrt(
                    pow(sin($latDelta / 2), 2) +
                    cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)
                )
            );

        return round($angle * $earthRadius, 2);
    }


    public function mapsDistanceList($locations, $latitude, $longitude)
    {

        $maps = [];

        foreach ($locations as $location) {
            $distance = $this->distance(
                $latitude,
                $longitude,
                $location->latitude,
                $location->longitude
            );

            $maps[] = [
                'name'         => $location->name,
                'marker_color' => $location->marker_color,
                'km'           => $distance,
            ];
        }

        usort($maps, fn($a, $b) => $a['km'] <=> $b['km']);

        return $maps;
    }

}
