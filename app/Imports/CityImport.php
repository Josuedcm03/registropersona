<?php

namespace App\Imports;

use App\Models\City;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CityImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Validamos datos mínimos
        if (empty($row['name'])) {
            return null;
        }

        return new City([
            'name' => $row['name'],
            'description' => $row['description'] ?? null,
        ]);
    }
}
