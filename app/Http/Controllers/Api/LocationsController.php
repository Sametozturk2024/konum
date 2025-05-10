<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\Locations;
use App\Http\Requests\StoreLocationRequest;

class LocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $location =  Locations::where('user_id', auth()->id())->get();

        return json_encode($location)  ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLocationRequest $request)
    {

        $validatedData = $request->validated(); // Geçerli verileri al
        $validatedData['user_id'] = auth()->id();
        try {
            $location = Locations::create($validatedData);
            return response()->json(['message' => 'Konum başarıyla kaydedildi', 'location' => $location], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Bir hata oluştu: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $location =  Locations::find($id);

        if (!$location) {
            return response()->json(['error' => 'Konum bulunamadı'], 404);
        }else{
            return json_encode($location);

        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreLocationRequest $request, string $id)
    {
        $location = Locations::find($id);

        // Eğer konum bulunamazsa hata döndür
        if (!$location) {
            return response()->json(['error' => 'Konum bulunamadı'], 404);
        }
        $validatedData = $request->validated();

        $validatedData['user_id'] = auth()->id();
        try {
            // Konumu güncelle
            $location->update($validatedData);
            return response()->json(['message' => 'Konum başarıyla güncellendi', 'location' => $location], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Bir hata oluştu: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Silinecek konumu bul
        $location = Locations::find($id);

        // Eğer konum bulunamazsa hata döndür
        if (!$location) {
            return response()->json(['error' => 'Konum bulunamadı'], 404);
        }

        try {
            // Konumu sil
            $location->delete();
            return response()->json(['message' => 'Konum başarıyla silindi'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Bir hata oluştu: ' . $e->getMessage()], 500);
        }
    }

    public  function routing (string $id)
    {

        return response()->json(['message' => 'Konum bulunamad'], 201);

    }
}
