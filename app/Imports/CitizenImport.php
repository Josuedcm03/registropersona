<?php

namespace App\Imports;

use App\Models\Citizen;
use App\Models\City;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class CitizenImport implements ToModel, WithHeadingRow, WithMapping
{

    public function map($row): array
    {
        // Evita errores si birth_date viene vacío o como string ya formateado
        $birthDate = null;
        if (!empty($row['birth_date'])) {
            if (is_numeric($row['birth_date'])) {
                $birthDate = Date::excelToDateTimeObject($row['birth_date'])->format('Y-m-d');
            } else {
                $birthDate = $row['birth_date'];
            }
        }

        return [
            'first_name' => $row['first_name'] ?? null,
            'last_name'  => $row['last_name'] ?? null,
            'birth_date' => $birthDate,
            'city_id'    => $row['city_id'] ?? null,
            'address'    => $row['address'] ?? null,
            'phone'      => $row['phone'] ?? null,
        ];
    }

    public function model(array $row)
    {
        // Ignorar filas totalmente vacías
        if (empty($row['first_name']) && empty($row['last_name'])) {
            return null;
        }

        // Validar ciudad existente
        if (!City::where('id', $row['city_id'])->exists()) {
            throw new \Exception("La ciudad con ID {$row['city_id']} no existe.");
        }

        return new Citizen($row);
    }
}

