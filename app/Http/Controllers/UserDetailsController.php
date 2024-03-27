<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreUserDetailsRequest;
use App\Http\Requests\UpdateUserDetailsRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
class UserDetailsController extends Controller {
    public function index() {
        
    }

    public function storeUserTempleteDetails(Request $request){
        try{
            $rules = [
                'json_data' => 'required|array',
            ];
            $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ]);

            } else {
                
                return response()->json([
                   'status' => true,
                   'message' => 'User Details Saved Successfully',
                ]);
            }
        } catch(Exception $e) {
            Log::info('Add user details '. $e->getMessage());
            throw new HttpResponseException (response()->json([
                'status' => false, 
                'message' => 'Error while adding user details'
            ]));
        }
    }

    public function updateUserTempleteDetails(Request $request){
        try{
            $rules = [
                'type_id' => 'required|numeric',
                'username' => 'required|min:5|max:255',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                throw new HttpResponseException(response()->json([
                    'errors' => $validator->errors()
                ], 422));

            } else {
                $userDetailsTemplate = UserDetails::where('id', $request->id)->first();
                $userDetailsTemplate->type_id = $request->type_id;
                $userDetailsTemplate->username = $request->username ?? $userDetailsTemplate->username;
                if($userDetailsTemplate->type_id == 1){
                    $userDetailsTemplate->is_processed = 1;
                    $userDetailsTemplate->is_validated = 1;
                    $userDetailsTemplate->updata();
                }
                return response()->json([
                   'status' => true,
                   'message' => 'User details updated successfully',
                ]);
            }
        } catch(Exception $e) {
            Log::info('Add user details '. $e->getMessage());
            throw new HttpResponseException (response()->json([
                'status' => false, 
                'message' => 'Error while updating user details'
            ]));
        }
    }


    // public function storeUserTempleteDetails(Request $request){
    //     try{
    //         $rules = [
    //             'type_id' => 'required|numeric',
    //             'username' => 'required|min:5|max:255',
    //         ];
    //         $validator = Validator::make($request->all(), $rules);
    //         if ($validator->fails()) {
    //             throw new HttpResponseException(response()->json([
    //                 'errors' => $validator->errors()
    //             ], 422));

    //         } else {
    //             $userDetailsTemplate = new UserDetails();
    //             $userDetailsTemplate->type_id = $request->type_id;
    //             $userDetailsTemplate->username = $request->username;
    //             if($userDetailsTemplate->type_id == 1){
    //                 $userDetailsTemplate->is_processed = 1;
    //                 $userDetailsTemplate->is_validated = 1;
    //                 $userDetailsTemplate->save();
    //             }
    //             return response()->json([
    //                'status' => true,
    //                'message' => 'User Details Saved Successfully',
    //             ]);
    //         }
    //     } catch(Exception $e) {
    //         Log::info('Add user details '. $e->getMessage());
    //         throw new HttpResponseException (response()->json([
    //             'status' => false, 
    //             'message' => 'Error while adding user details'
    //         ]));
    //     }
    // }

    // public function updateUserTempleteDetails(Request $request){
    //     try{
    //         $rules = [
    //             'type_id' => 'required|numeric',
    //             'username' => 'required|min:5|max:255',
    //         ];
    //         $validator = Validator::make($request->all(), $rules);
    //         if ($validator->fails()) {
    //             throw new HttpResponseException(response()->json([
    //                 'errors' => $validator->errors()
    //             ], 422));

    //         } else {
    //             $userDetailsTemplate = UserDetails::where('id', $request->id)->first();
    //             $userDetailsTemplate->type_id = $request->type_id;
    //             $userDetailsTemplate->username = $request->username ?? $userDetailsTemplate->username;
    //             if($userDetailsTemplate->type_id == 1){
    //                 $userDetailsTemplate->is_processed = 1;
    //                 $userDetailsTemplate->is_validated = 1;
    //                 $userDetailsTemplate->updata();
    //             }
    //             return response()->json([
    //                'status' => true,
    //                'message' => 'User details updated successfully',
    //             ]);
    //         }
    //     } catch(Exception $e) {
    //         Log::info('Add user details '. $e->getMessage());
    //         throw new HttpResponseException (response()->json([
    //             'status' => false, 
    //             'message' => 'Error while updating user details'
    //         ]));
    //     }
    // }

    // public function storeUserTempleteDetails(Request $request) {
    //     try{
    //         $rules = [
    //             'type_id' => 'required|integer',
    //             'username' => 'required|min:5|max:255',
    //         ];
    
    //         $validator = Validator::make($request->all(), $rules);
            
    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'status' => true,
    //                 'message' => $validator->errors(),
    //             ]);
    //         } else {
    //             if($request->type == 1){
    //                 UserDetailsController::createUserDetails($request);
    //                 return response()->json([
    //                     'status' => true,
    //                     'message' => 'User details created successfully',
    //                 ]);
    //             } elseif($request->type == 2) {
    //                 UserDetailsController::updateUserDetails($request);
    //                 return response()->json([
    //                     'status' => true,
    //                     'message' => 'User details updated successfully',
    //                 ]);
    //             } elseif($request->type == 3) {
    //                 UserDetailsController::deleteUserDetails($request);
    //                 return response()->json([
    //                     'status' => true,
    //                     'message' => 'User details deleted successfully',
    //                 ]);
    //             }
    //         }
    //     } catch(Exception $e){
    //         Log::info('Add product brand details '. $e->getMessage());
    //         throw new HttpResponseException (response()->json([
    //             'status' => false, 
    //             'message' => 'Error While Adding product brand Details'
    //         ]));
    //     }
    // }

    // public function createUserDetails($request) {
    //     try{
    //         return "hello world";
    //         $userDetails = UserDetails::where('is_validated', 0)->where('has_errors', 1);
    //         $userDetailsTemplate = new UserDetails();
    //         $userDetailsTemplate->type_id = $request->type;
    //         $userDetailsTemplate->username = $request->username;
    //         if($userDetails){
    //             $userDetailsTemplate->is_validated = 1;
    //             $userDetailsTemplate->is_processed = 1;
    //         }
    //     } catch(Exception $e){
    //         Log::info('Add product brand details '. $e->getMessage());
    //         throw new HttpResponseException (response()->json([
    //             'status' => false, 
    //             'message' => 'Error While Adding product brand Details'
    //         ]));
    //     }
    // }

    // public function updateUserDetails($request) {
    //     try{
    //         $userDetails = UserDetails::where('is_validated', 0)->where('is_processed', 0);
    //         $userDetailsTemplate = new UserDetails();
    //         $userDetailsTemplate->type_id = UserDetails::DATA_CREATED;
    //         $userDetailsTemplate->username = $request->username;

    //     } catch(Exception $e){
    //         Log::info('Add product brand details '. $e->getMessage());
    //         throw new HttpResponseException (response()->json([
    //             'status' => false, 
    //             'message' => 'Error While Adding product brand Details'
    //         ]));
    //     }
    // }

    
    // public function deleteUserDetails($request) {

    // }

    
}
