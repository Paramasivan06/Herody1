<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GigAppStatusExport implements FromCollection, WithHeadings
{
    /**
     * Fetch the data for export.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Use a single optimized query to fetch all required data
        return DB::table('gig_apps as g')
            ->select(
                'g.uid',
                'u.name as user_name',
                'u.email as user_email',
                'u.phone as user_phone',
                'u.balance as user_balance',
                DB::raw('MAX(g.updated_at) as last_updated_date')
            )
            ->join('users as u', 'g.uid', '=', 'u.id') // Adjust the join condition as per your schema
            ->where('g.status', 4) // Filter records with status = 4
            ->groupBy('g.uid', 'u.name', 'u.email', 'u.phone','u.balance')
            ->get()
            ->map(function ($record) {
                return [
                    'User ID' => $record->uid,
                    'User Name' => $record->user_name ?? 'N/A',
                    'User Email' => $record->user_email ?? 'N/A',
                    'User Phone' => $record->user_phone ?? 'N/A',
                    'User Balance' => $record->user_balance ?? 'N/A',
                    'Last Updated Date' => $record->last_updated_date,
                ];
            });
    }

    /**
     * Define the headings for the export.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'User ID',
            'User Name',
            'User Email',
            'User Phone',
            'User Balance',
            'Last Updated Date',
        ];
    }
}
