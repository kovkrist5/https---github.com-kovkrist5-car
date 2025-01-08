<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $car= Car::with('owner')->get();
        return response()->json($car);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator=> Validator::make($request->all(),[
            'brand' => 'string',
            'model' => 'string',
            'license_plate' => 'string',
            'owner_id' => 'exists:owners,id',
        ]);
        if($validator->fails()){
            return response()>json(['errors'=>$validator->errors()], 422);
        }
        $car= Car::create($request->all());
        return response()->json($car);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        if(!$car){
            return response()->json(['message' => 'car not found'], 404);
        }
        return response()->json($car);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
        {
            $validator = Validator::make($request->all(),[
                'brand' => 'string',
                'model' => 'string',
                'license_plate' => 'string',
                'owner_id'=>'exist:owner, id',
            ]);
            if($validator->fails()){
                return response()->json(['errors'=>$validator->errors()], 422);
            }
            $car= Car::find($id);
            if(!$car){
                return response()->json(['message'=> 'Car not found'], 404);
            }
            $car->update($request->all());
            return response()->json($car);
        }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        $car = Car::find($id);
        if(!$car) {
        return response()->json(['message' => 'Car not found'], 404);
        }
        $car->delete();
        return response()->json(['message' => 'Car deleted success']);
    }
}
