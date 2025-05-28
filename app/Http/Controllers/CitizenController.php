<?php

namespace App\Http\Controllers;
use App\Models\Citizen;
use App\Models\City;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CitizenImport;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class CitizenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $citizens = Citizen::orderBy('first_name', 'asc')->paginate(20);
            return view('citizens.index', compact('citizens'));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch citizens: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $cities = City::orderBy('name', 'asc')->get();
            return view('citizens.create', compact('cities'));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch cities: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'first_name' => 'required|string|max:60',
                'last_name' => 'required|string|max:60',
                'birth_date' => 'required|date',
                'city_id' => 'required|exists:cities,id',
                'address' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:8',
            ]);

            Citizen::create($request->all());

            return redirect()->route('citizens.index')->with('success', 'Citizen created successfully.');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create citizen: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $citizen = Citizen::findOrFail($id);
            return view('citizens.show', compact('citizen'));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch citizen: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $citizen = Citizen::findOrFail($id);
            $cities = City::orderBy('name', 'asc')->get();
            return view('citizens.edit', compact('citizen', 'cities'));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch citizen: ' . $e->getMessage()], 500);
        }   
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'first_name' => 'required|string|max:60',
                'last_name' => 'required|string|max:60',
                'birth_date' => 'required|date',
                'city_id' => 'required|exists:cities,id',
                'address' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:8',
            ]);

            $citizen = Citizen::findOrFail($id);
            $citizen->update($request->all());

            return redirect()->route('citizens.index')->with('success', 'Citizen updated successfully.');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update citizen: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $citizen = Citizen::findOrFail($id);
            $citizen->delete();

            return redirect()->route('citizens.index')->with('success', 'Citizen deleted successfully.');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete citizen: ' . $e->getMessage()], 500);
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

        $originalName = $request->file('file')->getClientOriginalName();
        $extension = $request->file('file')->getClientOriginalExtension();
        $uniqueName = \Illuminate\Support\Str::uuid() . '.' . $extension;

        $filePath = $request->file('file')->move($tmpPath, $uniqueName);

        
        Excel::import(new \App\Imports\CitizenImport, $filePath);
        

        File::delete($filePath);

        return back()->with('success', 'Importación completada exitosamente.');
    } catch (\Throwable $e) {
        Log::error('Error de importación: ' . $e->getMessage());
        return back()->with('error', 'Error en la importación: ' . $e->getMessage());
    }
}








}
