<?php

namespace App\Http\Controllers;

use App\Models\RegionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class RegionController extends Controller
{
    public function view() {
        $data = RegionModel::all();
        return view('region/regionList', ['data' => $data]);
    }

    public function detail($id) {
        $id     = Crypt::decrypt($id);
        $data   = RegionModel::where('regsion_id','=', $id)->limit(1)->get();
        return view('region/regionDetail', ['data' => $data]);
    }
}
