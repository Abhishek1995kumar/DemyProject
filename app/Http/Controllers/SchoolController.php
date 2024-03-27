<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use App\Models\School;
use App\Models\Student;
use App\Models\Country;
use App\Http\Resources\SchoolResource;
use Illuminate\Http\Request;
use Throwable;

class SchoolController extends Controller {
    public function index(Request $request) {
        try{
            // $student = Student::with('school.city.state.country')->get();
            // $cityName = $request->name;
            // $details = Student::whereHas('school', function ($query) use ($cityName) {
            //     return $query->whereHas('city',function ($q) use ($cityName) {
            //         return $q->where('city_name', $cityName);
            //     });
            // })->with(['school.city'])->get();
            
            $stateName = $request->name;
            // return Student::whereHas('school', function($query) use ($stateName) {
            //     $query->whereHas('city', function ($q) use ($stateName) {
            //         $q->whereHas('state', function ($q) use ($stateName) {
            //             $q->where('state_name', $stateName);
            //         });
            //     });
            // })->with(['school.city.state'])->get();

            // return Student::whereHas('school', function($query) use ($stateName) {
            //     $query->whereHas('city', function ($q) use ($stateName) {
            //         $q->where('city_name', $stateName);
            //     });
            // })->with(['school.city.state'])->get();

            // return response()->json(['details' => $details]);

            // $stateName = $request->has('state_name');
            // $details = Student::when($stateName, function ($query) use ($request) {
            //     $query->whereHas('school.city.state', function ($q) use ($request) {
            //         $q->where('state_name', 'like', '%' . $request->state_name . '%');
            //     });
            //     })->with(['school.city.state' => function($qm) {
            //         $qm->select('id','state_name');
            // }])->get();

            // return Student::when($request->has('city_name'), function ($query) use ($request) {
            //     $query->whereHas('school.city', function ($q) use ($request) {
            //         $q->where('city_name', 'like', '%' . $request->city_name . '%');
            //     });
            //     })->with(['school.city' => function($qm) {
            //         $qm->select('id','city_name');
            // }])->get();

            // return Student::when($request->has('state_name'), function ($query) use ($request) {
            //     $query->whereHas('school.city.state', function ($q) use ($request) {
            //         $q->where('state_name', 'like', '%' . $request->state_name . '%');
            //     });
            //     })->with(['school.city.state' => function($qm) {
            //         $qm->select('id','state_name');
            // }])->get();

            // return Student::when($request->has('state_name'), function ($query) use ($request) {
            //     $query->whereHas('school', function ($q) use ($request) {
            //         $q->where('school_name', 'like', '%' . $request->state_name . '%');
            //     });
            //     })->with(['school' => function($qm) {
            //         $qm->select('id','school_name');
            // }])->get();
            
            return Student::when($request->has('school_name'), function ($query) use ($request) {
                $query->whereHas('school', function ($q) use ($request) {
                    $q->where('school_name', 'like', '%' . $request->school_name . '%');
                });
                })->with('school:id,school_name,school_email')->get();

            $data = [];
            foreach ($details as $key => $value) {
                $data[$key]['student_name'] = $value->name;
                $data[$key]['student_email'] = $value->email;
                $data[$key]['state_name'] = $value->school->city->state->state_name;
                $data[$key]['city_name'] = $value->school->city->city_name;
                $data[$key]['school_name'] = $value->school->school_name;
                $data[$key]['school_email'] = $value->school->school_email;
            }
            return $data;
            if(!empty($details)){
                return response()->json([
                    'status' => true,
                    'data' => SchoolResource::collection($details)
                ]);
            } else {
                return response()->json([
                'status' => 404,
                'message' => 'No Data Found'
                ]);
            }

        } catch(Throwable $e) {
            return $e->getMessage();
        };
    }

    public function createSchool() {
        try{

        } catch(Throwable $e) {
            return $e->getMessage();
        };
    }

    public function update(Request $request, School $school) {
        try{

        } catch(Throwable $e) {
            return $e->getMessage();
        };
    }

    public function destroy(School $school) {
        try{

        } catch(Throwable $e) {
            return $e->getMessage();
        };
    }
}
