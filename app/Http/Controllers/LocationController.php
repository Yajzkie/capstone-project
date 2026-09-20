<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LocationsExport;  // Make sure to import your export class


class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::all();
        return view('admin.location', compact('locations'));
    }

    public function dashboard(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $query = Location::query()
            ->when($from, fn ($q) => $q->whereDate('date_of_sighting', '>=', $from))
            ->when($to, fn ($q) => $q->whereDate('date_of_sighting', '<=', $to));

        // Sum of number_of_cots per municipality (ignore blank municipalities)
        $municipalityCots = (clone $query)
            ->whereNotNull('municipality')
            ->where('municipality', '!=', '')
            ->select('municipality', \DB::raw('sum(number_of_cots) as total_cots'))
            ->groupBy('municipality')
            ->get();

        // Cast to int so the chart receives numbers, not strings
        $totalCots = (int) $municipalityCots->sum('total_cots');

        // Prepare data for the chart
        $municipalities = $municipalityCots->pluck('municipality')->values();
        $totalCotsArray = $municipalityCots->map(fn ($item) => (int) $item->total_cots)->values();
        $percentages = $municipalityCots->map(function ($item) use ($totalCots) {
            return $totalCots > 0 ? ($item->total_cots / $totalCots) * 100 : 0; // Calculate percentage
        })->values();

        // Monthly sightings for the bar chart (respect the active date filter)
        $monthly = (clone $query)
            ->whereNotNull('date_of_sighting')
            ->select(\DB::raw("DATE_FORMAT(date_of_sighting, '%Y-%m') as month"), \DB::raw('count(*) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthLabels = $monthly->map(fn ($m) => \Carbon\Carbon::createFromFormat('Y-m', $m->month)->format('M Y'))->values();
        $monthCounts = $monthly->map(fn ($m) => (int) $m->total)->values();

        // Get the total number of users
        $userCount = \App\Models\User::count();

        // Summary counts (respect the active date filter)
        $totalSightings = (clone $query)->count();
        $thisMonth = (clone $query)
            ->whereYear('date_of_sighting', now()->year)
            ->whereMonth('date_of_sighting', now()->month)
            ->count();

        // Pass data to the view
        return view('admin.index', compact(
            'municipalities', 'totalCotsArray', 'percentages',
            'userCount', 'totalCots', 'totalSightings', 'thisMonth', 'from', 'to',
            'monthLabels', 'monthCounts'
        ));
    }


    public function destroy($id)
    {
        $location = Location::find($id);

        if ($location) {
            $location->delete();
            return response()->json(['message' => 'Location deleted successfully.']);
        } else {
            return response()->json(['message' => 'Location not found.'], 404);
        }
    }

    // Method to generate the report
    public function report(Request $request)
    {
        // Get all unique municipalities
        $municipalities = Location::distinct()->pluck('municipality');

        // If a municipality is selected, filter by that municipality
        $locations = Location::when($request->municipality, function ($query) use ($request) {
            return $query->where('municipality', $request->municipality);
        })
        ->paginate(10);  // Limit to 10 rows per page

        return view('admin.report', compact('locations', 'municipalities'));
    }

    public function export(Request $request)
    {
        // Get the selected municipality from the request
        $municipality = $request->input('municipality');

        // Fetch the locations, optionally filtered by municipality
        $locations = Location::when($municipality, function ($query, $municipality) {
            return $query->where('municipality', $municipality);
        })->get();

        // Generate the filename based on the selected municipality
        $filename = $municipality ? 'report_' . strtolower($municipality) . '.xlsx' : 'report_all_locations.xlsx';

        // Export the filtered locations and download the file with the dynamic filename
        return Excel::download(new LocationsExport($locations), $filename);
    }

    // Inside DashboardController.php
    public function getDashboardData()
    {
        // Get the sum of number_of_cots by municipality
        $municipalityCots = Location::select('municipality', \DB::raw('sum(number_of_cots) as total_cots'))
                                    ->groupBy('municipality')
                                    ->get();

        // Calculate the total number of cots
        $totalCots = $municipalityCots->sum('total_cots');

        // Prepare data for the chart
        $municipalities = $municipalityCots->pluck('municipality');
        $totalCotsArray = $municipalityCots->pluck('total_cots');

        // Get the total number of users
        $userCount = \App\Models\User::count();

        // Return as JSON
        return response()->json([
            'userCount' => $userCount,
            'totalCots' => $totalCots,
            'municipalities' => $municipalities,
            'totalCotsArray' => $totalCotsArray,
        ]);
    }


}
