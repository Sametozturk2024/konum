<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MapLocationRequest;
use App\Http\Requests\StoreLocationRequest;
use App\Models\Location;
use App\Services\DistanceCalculation;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Integer;

class LocationsController extends Controller
{
    public function index()
    {
        $locations = Location::where('user_id', auth()->id())->orderBy('orders', 'ASC' )->get();

        return response()->json($locations, 200);
    }

    public function store(StoreLocationRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = auth()->id();

        try {
            $location = Location::create($validatedData);

            return response()->json([
                'message'  => 'Konum başarıyla kaydedildi',
                'location' => $location,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Bir hata oluştu: ' . $e->getMessage()], 500);
        }
    }

    public function show(int $id)
    {
        $location = Location::find($id);

        if (!$location) {
            return response()->json(['error' => 'Konum bulunamadı'], 404);
        }

        return response()->json($location, 200);
    }

    public function update(StoreLocationRequest $request, int $id)
    {
        $location = Location::find($id);

        if (!$location) {
            return response()->json(['error' => 'Konum bulunamadı'], 404);
        }

        $validatedData = $request->validated();
        $validatedData['user_id'] = auth()->id();

        try {
            $location->update($validatedData);

            return response()->json([
                'message'  => 'Konum başarıyla güncellendi',
                'location' => $location,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Bir hata oluştu: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(int $id)
    {
        $location = Location::find($id);


        if (!$location) {
            return response()->json(['error' => 'Konum bulunamadı'], 404);
        }

        try {
            $location->delete();

            return response()->json(['message' => 'Konum başarıyla silindi'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Bir hata oluştu: ' . $e->getMessage()], 500);
        }
    }

    public function maps(MapLocationRequest $request)
    {

        $locations = Location::where('user_id', auth()->id())->get();

        $distanceCalculator = new DistanceCalculation();
        $maps  = $distanceCalculator->mapsDistanceList($locations, $request->latitude ,  $request->longitude);

        return response()->json(['data' => $maps]);
    }
}
