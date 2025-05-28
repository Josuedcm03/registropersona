<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Imports\CityImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $cities = City::orderBy('created_at', 'desc')->paginate(6);
            return view('cities.index', compact('cities'));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch cities: ' . $e->getMessage()], 500);
        }
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('cities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try{
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            City::create($request->all());

            return redirect()->route('cities.index')->with('success', 'City created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create city: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        try{
            $city = City::findOrFail($id);
            return view('cities.show', compact('city'));
        } catch (\Exception $e) {
            return response()->json(['error' => 'City not found: ' . $e->getMessage()], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        try{
            $city = City::findOrFail($id);
            return view('cities.edit', compact('city'));
        } catch (\Exception $e) {
            return response()->json(['error' => 'City not found: ' . $e->getMessage()], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        try{
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $city = City::findOrFail($id);
            $city->update($request->all());

            return redirect()->route('cities.index')->with('success', 'City updated successfully.');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update city: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try{
            $city = City::findOrFail($id);
            $city->delete();

            return redirect()->route('cities.index')->with('success', 'City deleted successfully.');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete city: ' . $e->getMessage()], 500);
        }
    }


    
public function import(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:xlsx,csv',
    ]);

    try {
        $tmpPath = public_path('tmp');
        if (!File::exists($tmpPath)) {
            File::makeDirectory($tmpPath, 0755, true);
        }

        $extension = $request->file('file')->getClientOriginalExtension();
        $uniqueName = Str::uuid() . '.' . $extension;
        $filePath = $request->file('file')->move($tmpPath, $uniqueName);

        Excel::import(new CityImport, $filePath);

        File::delete($filePath);

        return back()->with('success', 'Importación de ciudades completada exitosamente.');
    } catch (\Throwable $e) {
        return back()->with('error', 'Error en la importación: ' . $e->getMessage());
    }
}

}
