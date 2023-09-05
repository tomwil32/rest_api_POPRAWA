<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\People;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\PeopleResource;
use App\Http\Requests\StorePeopleRequest;
use Illuminate\Support\Facades\Validator;

class PeopleController extends Controller
{
    public function index()
    {
        $people = People::all();
        return PeopleResource::collection($people);
    }

    public function store(StorePeopleRequest $request)
    {
        $people = People::create($request->all());
        return new PeopleResource($people);
    }

    public function show($id)
    {
        $people = People::find($id);

        if ($people) {
            return new PeopleResource($people);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Person not found'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'phone' => 'required|digits:9',
            'email' => 'required|email|max:191',
            'address' => 'required|string|max:191',
            'city' => 'required|string|max:191',
            'state' => 'required|string|max:191',
            'postal_code' => 'required|digits:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }

        $people = People::find($id);

        if ($people) {
            $people->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'postal_code' => $request->postal_code,
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'People updated successfully :)'
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'People not found :('
            ], 404);
        }
    }

    protected function prepareForValidation() { 
        if ($this->postalCode) {
            $this->merge([
                'postal_code' => $this->postalCode
            ]);
        }
    }

    public function destroy($id)
    {
        $people = People::find($id);
        if($people){

            $people->delete();
            return response()->json([
                'status' => 200,
                'message' => 'People deleted :)'
            ], 200);
            
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'People not found :('
            ], 404);
        }
    }

    public function getAll()
    {
        $people = People::all();
        return PeopleResource::collection($people);
    }
}
