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
        return response([
            'status'=> 200,
            'makes' => $makes,
            'messages'=> 'Get data success'
        ]);

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

        return response([
            'status' => 200,
            'models'=>$models,
            'messages'=> 'Get data success'
        ]);
    }

    public function series(Request $req){
        $make = $req->input('make');
        $model = $req->input('model');
//        $badge = $req->input('badge');
        $series = CarPart::selectRaw('upper(VehicleSeries) as VehicleSeries ,count(VehicleSeries) as CountSerie')
            ->where('VehicleMake',$make)
            ->where('VehicleModel',$model)
//            ->where('VehicleBadge',$badge)
            ->where('VehicleSeries','<>',"")
            ->where('VehicleSeries','<>',".")
            ->groupBy('VehicleSeries')
            ->orderBy('CountSerie','DESC')
            ->skip(0)
            ->take(100)
            ->get();
        return response([
            'status'=> 200,
            'series'=> $series,
            'messages'=> 'Get data success'
        ]);
    }
    public function badge(Request $req) {
        $make = $req->input('make');
        $model = $req->input('model');
        $serie = $req->input('series');
        $badge = CarPart::selectRaw('upper(VehicleBadge) as VehicleBadge ,count(VehicleBadge) as CountBadge')
            ->where('VehicleMake',$make)
            ->where('VehicleModel',$model)
            ->where('VehicleSeries',$serie)
            ->where('VehicleBadge','<>',"")
            ->where('VehicleBadge','<>',".")
            ->groupBy('VehicleBadge')

            ->orderBy('CountBadge','DESC')
            ->skip(0)
            ->take(100)
            ->get();
        return response([
            'status'=> 200,
            'badges'=> $badge,
            'messages'=> 'Get data success'
        ]);
    }

    public function NumberPrice(Request $req){

        $make = $req->input('make');
        $model = $req->input('model');
        $series = $req->input('series');
        $badge = $req->input('badge');

        $getId = CarPart::select('ID')
            ->where(function($query) use ($make, $model, $badge, $series) {
                if ($make) {
                    $query->where('VehicleMake', $make);
                }
                if ($model) {
                    $query->where('VehicleModel', $model);
                }
                if ($series) {
                    $query->where('VehicleSeries', $series);
                }
                if ($badge) {
                    $query->where('VehicleBadge', $badge);
                }
            })
            ->skip(0)
            ->take(50)
            ->get()
            ->pluck('ID');
        $numberprices = Part::whereIn('aiCarPartId', $getId)
//            ->where("partnumber","LIKE","%{$req->get('search')}%")
            ->skip(0)
            ->take(50)
            ->orderBy('Description','ASC')
            ->get();
//        dd($numberprices);
        return response([
            'status'=> 200,
            'numberprices'=> $numberprices,
            'messages'=> 'Get data success'
        ]);
    }

    public function searchPartNumber(Request $req) {
        $search = CarPart::with('parts')
            ->where("partnumber","LIKE","%{$req->get('search')}%")
            ->get();

         return response([
            'status'=> 200,
            'messages'=>'Get data success',
            'search'=> $search
        ]);
    }

}
