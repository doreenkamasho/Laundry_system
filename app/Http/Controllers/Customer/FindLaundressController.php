<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FindLaundressController extends Controller
{
    private const MAX_DISTANCE = 10; // Maximum distance in kilometers

    public function index(Request $request)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        $laundresses = User::where('role_id', Role::where('name', 'laundress')->first()->id)
            ->with(['laundressDetail'])
            ->whereHas('laundressDetail', function ($query) {
                $query->where('availability_status', true);
            })
            ->when($latitude && $longitude, function ($query) use ($latitude, $longitude) {
                return $query->whereHas('laundressDetail', function ($query) use ($latitude, $longitude) {
                    $haversine = "(6371 * acos(cos(radians($latitude)) 
                                 * cos(radians(latitude)) 
                                 * cos(radians(longitude) 
                                 - radians($longitude)) 
                                 + sin(radians($latitude)) 
                                 * sin(radians(latitude))))";
                    
                    $query->whereRaw("{$haversine} <= ?", [self::MAX_DISTANCE]);
                    $query->selectRaw("{$haversine} as distance");
                });
            })
            ->get();

        return view('customer.find-laundress.index', compact('laundresses'));
    }
}