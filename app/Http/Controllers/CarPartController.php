<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarPart;
use App\Models\Part;
use DB;

use App\Http\Requests;

class CarPartController extends Controller
{
    public function make(){

        $makes = CarPart::selectRaw('upper(VehicleMake) as VehicleMake ,count(VehicleMake) as countMake')
            ->groupBy('VehicleMake')
            ->orderBy('countMake','DESC')
            ->take(100)
            ->get();
        return response(['makes' => $makes ]);

    }


    public function model(Request $req){
        $make = $req->input('make');
        $models = CarPart::selectRaw ('upper(VehicleModel) as VehicleModel ,count(VehicleModel) as CountModel')
            ->where('VehicleMake',$make)
            ->where('VehicleModel','<>',"")
            ->groupBy('VehicleModel')
            ->orderBy('CountModel','DESC')
            ->skip(0)
            ->take(100)
            ->get();

        return response(['models'=>$models]);
    }

    public function badge(Request $req) {
        $make = $req->input('make');
        $model = $req->input('model');
        $badge = CarPart::selectRaw('upper(VehicleBadge) as VehicleBadge ,count(VehicleBadge) as CountBadge')
            ->where('VehicleMake',$make)
            ->where('VehicleModel',$model)
            ->where('VehicleBadge','<>',"")
            ->where('VehicleBadge','<>',".")
            ->groupBy('VehicleBadge')

            ->orderBy('CountBadge','DESC')
            ->skip(0)
            ->take(100)
            ->get();
        return response(['badges'=>$badge]);
    }

    public function series(Request $req){
        $make = $req->input('make');
        $model = $req->input('model');
        $badge = $req->input('badge');
        $series = CarPart::selectRaw('upper(VehicleSeries) as VehicleSeries ,count(VehicleSeries) as CountSerie')
            ->where('VehicleMake',$make)
            ->where('VehicleModel',$model)
            ->where('VehicleBadge',$badge)
            ->where('VehicleSeries','<>',"")
            ->where('VehicleSeries','<>',".")
            ->groupBy('VehicleSeries')
            ->orderBy('CountSerie','DESC')
            ->skip(0)
            ->take(100)
            ->get();
        return response(['series'=>$series]);
    }

    public function NumberPrice(Request $req){

        $make = $req->input('make');
        $model = $req->input('model');
        $badge = $req->input('badge');
        $series = $req->input('series');

        $getId = CarPart::select('ID')
            ->where('VehicleMake',$make)
            ->where('VehicleModel', $model)
            ->where('VehicleBadge', $badge)
            ->where('VehicleSeries', $series)
            ->skip(0)
            ->take(50)
            ->get()
            ->pluck('ID');
        // return $getId;
        //
        $numberprices = Part::whereIn('aiCarPartId',$getId)
            ->skip(0)
            ->take(50)
            ->orderBy('LowPrice','DESC')
            ->get();
        // ->toSql();
        return response(['numberprices'=>$numberprices]);
    }

    public function EditNumberPrice($id){

        $pricenumber=Part::find($id);

        return response(['pricenumber'=>$pricenumber]);
    }




}
