<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\DataType;
use App\Models\Validation;
use App\Models\TemplateName;
use Illuminate\Http\Request;
use App\Models\TemplateFields;
use App\Models\TemplatePayloadData;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Exists;

class TemplateDetailsController extends Controller {
    public function showTemplateDetails(Request $request) {
        try{
            // return $templateName = TemplateFields::when($request->has('template_id'), function($query) use ($request) {
            //     $query->whereHas('templateName', function($q) use ($request) {
            //         $q->where('id', $request->template_id);
            //     });
            // })->with('templateName')->get();

            $templateName = TemplateName::when($request->has('template_name_id'), function($query) use ($request) {
                $query->whereHas('templateField', function($q) use ($request) {
                    $q->where('template_name_id', $request->template_name_id);
                });
            })->with('templateField')->get();

            if($templateName->isNotEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'data' => $templateName
                ]);

            } else {
                return response()->json([
                   'status' => 'error',
                   'message' => 'Template not found'
                ]);
            }

        } catch(Exception $e) {
            return response()->json([
                'status' => false,
                'errors' => $e->getMessage()
            ]);
        }
    }

    public function saveTemplateNameFields(Request $request) {
        try {
            $rules = [
                'template_name' => 'required',
                'data.*.validation_id' =>'required|exists:validations,id', // when i want to send multiple data in databse on that time we need to check validation, this reason we use this method
                'data.*.data_type_id'  =>'required|exists:data_types,id', // we getting data from postman 
                'data.*.field_name'    =>'required',   // * -- mean indexing, Indexing the records in the data where I am setting
                'data.*.is_mandatory'  =>'required',
            ];

            $message = [
                'template_name.required' => 'The : Templete name id field is required, please fill template name',
                'validation_id.required' => 'The : Validation id field is required, please select validation',
                'validation_id.integer'  => 'The : Validation id field must be integer type, please set value in integer',
                'data_type_id.required'  => 'The : Data type id field is required, please select data type',
                'data_type_id.integer'   => 'The : Data type id field must be integer type, please set value in integer',
                'field_name.required'    => 'The : Field name field is required, please select field name',
                'is_mandatory.required'  => 'The : Is mandatory field is required, please fill is mandatory',
            ];

            $validator = Validator::make($request->all(), $rules, $message);

            if($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ]);

            } else {
                $templateDetails = new TemplateName();
                $templateDetails->templete_name = $request->template_name;
                $templateDetails->status = $request->status ?? 1;
                $templateDetails->created_at = now() ?? NULL;
                $templateDetails->updated_at = now() ?? NULL;
                $templateDetails->save();

                if(!empty($templateDetails->id)){
                    if($request->has('payload')) {
                        foreach($request->payload as $key => $value) {
                            $details = [
                                'template_name_id' => $templateDetails->id,
                                'validation_id' => $value['validation_id'],
                                'data_type_id' => $value['data_type_id'],
                                'field_name' => $value['field_name'],
                                'is_mandatory' => $value['is_mandatory'] ?? 2,
                                'status' => $value['status'] ?? 1,
                                'created_at' => now() ?? NULL,
                                'updated_at' => now() ?? NULL
                            ];

                            TemplateFields::insert($details);

                        };

                    } else {
                        $templateDetails = new TemplateName();
                        $templateDetails->templete_name = $request->template_name;
                        $templateDetails->status = $request->status ?? 1;
                        $templateDetails->created_at = now() ?? NULL;
                        $templateDetails->updated_at = now() ?? NULL;
                        $templateDetails->save();

                        if($templateDetails->id) {
                            $templateFields = new TemplateFields();
                            $templateFields->template_name_id = $templateDetails->id;
                            $templateFields->validation_id = $request->validation_id;
                            $templateFields->data_type_id = $request->data_type_id;
                            $templateFields->field_name = $request->field_name;
                            $templateFields->status = $request->is_mandatory;
                            $templateFields->status = $request->status ?? 1;
                            $templateFields->created_at = now() ?? NULL;
                            $templateFields->updated_at = now() ?? NULL;
                            $templateFields->save();

                        }
                    }

                    return response()->json([
                        'status' => true,
                        'data' => "Template field and template name created successfully",
                    ]);

                } else {
                    return response()->json([
                        'status' => true,
                        'data' => "Template is not created properly, please you can check and create again",
                    ]);
                }

            }

        } catch (Exception $e) {
            return response()->json([
               'status' => false,
                'errors' => $e->getMessage()
            ]);
        }
    }

    public function updateTemplateNameField(Request $request) {
        try{
            $rules = [
                // 'id' => 'required|exists:template_names,id',
            ];

            $messages = [
                'id.required' => 'Template id field is required, please manually check the template id',
                'id' => 'Provided template id does not exist in database, please provide valid template id',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ]);
            } else {

                $templateDetails = TemplateName::where('id', $request->id)->with('templateField')->first();

                if ($templateDetails) {
                    if ($request->has('payload')) {
                        $templateFieldNames = $templateDetails->templateField->pluck('field_name')->toArray();
                        $payloadFields = collect($request->payload);
                        $deletePluckedDetails = $payloadFields->pluck('field_name')->toArray();

                        $newFields = $payloadFields->filter(function ($payloadField) use ($templateFieldNames) {
                            return !in_array($payloadField['field_name'], $templateFieldNames);
                        });

                        $deffierenceFieldDatabase = array_diff($templateFieldNames, $deletePluckedDetails);

                        if(!empty($deffierenceFieldDatabase)) {
                            $del = TemplateFields::where('template_name_id', $request->id)
                                        ->whereIn('field_name', $deffierenceFieldDatabase)->delete(); // whereIn -- jab data as a array/collection me ho tab ham whereIn ka use karte hai

                        }

                        foreach($newFields as $value) {
                            $templateField = new TemplateFields();
                            $templateField->template_name_id = $templateDetails->id;
                            foreach($value as $field) {
                                $templateField->field_name = $value['field_name'];
                                $templateField->validation_id = $value['validation_id'];
                                $templateField->data_type_id = $value['data_type_id'];
                                $templateField->is_mandatory = $value['is_mandatory'];
                                $templateField->status = 1;
                                $templateField->created_at = now();
                                $templateField->updated_at = now();
                            }
                            $templateField->save();

                        }

                        return response()->json([
                            'status' => true,
                            'message' => 'Template field is updated successfully', 
                        ]);
                    }

                } else {
                    return response()->json([
                       'status' => false,
                       'message' => 'Template id is not found, please you can check template id is manually.',
                    ]);
                }
            }
        } catch(Exception $e) {
            return response()->json([
                'status' => false,
                'errors' => $e->getMessage()
            ]);
        }
    }

    public function templatePayloadDetails(Request $request) {
        $rules = [
            'template_id' => 'required|exists:template_names,id',
        ];
    
        $messages = [
            'template_id.required' => 'Template id is required.',
            'template_id.exists' => 'Invalid template id.',
        ];
    
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
        
        $templateDetails = TemplateFields::where('template_name_id', $request->template_id)->get();
        
        if ($templateDetails->isEmpty()) { 
            return response()->json([
                'status' => false,
                'error' => "No template fields found for the given template id.",
            ]);
        }
    
        $errors = [];
        
        foreach ($templateDetails as $detail) {
            $fieldName = $detail->field_name;
            $isMandatory = $detail->is_mandatory;
            $dataType = DataType::find($detail->data_type_id);
            $validation = Validation::find($detail->validation_id);
            $expectedDataType = $dataType->data_type_value;
            // Check if field is mandatory and missing in the request
            if ($isMandatory == 1 && !isset($request->$fieldName)) {
                $errors[] = [
                    "field_name" =>  $fieldName,
                    'error' => "Field $fieldName is mandatory."
                ];
            }
            
            // Check if field data type in request matches the expected data type
            if (isset($request->$fieldName) && $expectedDataType != gettype($request->$fieldName)) {
                $errors[] = [
                    "field_name" =>  $fieldName,
                    'error' => "Invalid data type for field $fieldName. Expected {$expectedDataType}."
                ];
            }
            
            // Validate field data based on validation rules
            if ($validation && !empty($validation->validation_value)) {
                if (!Validator::make([$fieldName => $request->$fieldName], [$fieldName => $validation->validation_value])->passes()) {
                    $errors[] = [
                        "field_name" =>  $fieldName,
                        'error' => "Validation failed for field $fieldName"
                    ];
                }
            }
        }
    
        if (!empty($errors)) {
            return response()->json($errors);
        }
    
        // Proceed with saving the payload data
        $templatePayloadData = new TemplatePayloadData();
        $templatePayloadData->template_name_id = $request->template_id;
        $templatePayloadData->data = $request->all();
        // $templatePayloadData->save();
    
        return response()->json([
            'status' => true,
            'message' => 'Payload data saved successfully',
        ]);
    }
    

    public function getTemplatePayloadDetails(Request $request) {
            $rules = [
                'data' => 'array',
                'template_id' => 'integer|exists:template_names,id',
            ];

            $message = [
                'data' => 'Data field is like array, please use the valid data type',
                'template_id' => 'Template id field is required, please select a template id'
            ];

            $validator = Validator::make($request->all(), $rules, $message);

            if($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ]);
            }

            $templateDetails = TemplateFields::where('template_name_id', $request->template_id)->get();

            if(empty($templateDetails)) { 
                return response()->json([
                    'status' => false,
                    'error' => "No template fields found for the given template id",
                ]);
            }
            $fieldNameFromDB = $templateDetails->pluck('field_name')->toArray();
            $fieldNameWithMandatory = $templateDetails->where('is_mandatory', 1)->pluck('field_name')->toArray();

            // Request getting from Row than we use this
            $rowFieldName = array_keys($request->payload);
            $missingMandatoryFields = array_diff($fieldNameWithMandatory, $rowFieldName);
            $defferWithoutMandatoryRequestFields = array_diff($rowFieldName, $fieldNameFromDB);

            // Request getting from Form-data than we use this
            $formDataFieldName = array_keys($request->all());
            $valueFormData = array_values($request->all());
            $defferFormDataRequestFields = array_diff(array_keys($request->except('template_id')), ['template_id']);
            $missingFormDataMandatoryFields = array_diff($fieldNameWithMandatory, $defferFormDataRequestFields);
            // $defferWithoutMandatoryRequestFields = array_diff(array_keys($request->except('template_id')), ['template_id']);

            if($request->has('payload')) {
                $errors = [];
                if($missingMandatoryFields){
                    foreach ($missingMandatoryFields as $fieldName) {
                        $errors[] = [
                            "field_name" => $fieldName,
                            'error' => "$fieldName field mandatory"
                        ];
                    }
                }

                // Check if all fields in the request json exist in the database than save the data to the database otherwise return an error
                if (!empty($defferWithoutMandatoryRequestFields)) {
                    foreach ($defferWithoutMandatoryRequestFields as $fieldName) {
                        $errors[] = [
                            "field_name" => $fieldName,
                            'error' => "Field $fieldName does not exist in the database"
                        ];
                    }
                }

                if($templateDetails) {
                    foreach ($templateDetails as $detail) {
                        $fieldName = $detail->field_name;
                        $dataType = DataType::find($detail->data_type_id);
                        $expectedDataType = $dataType->data_type_value;
                        if (isset($request->payload[$fieldName])) {
                            $requestValue = $request->payload[$fieldName];
                            $requestDataType = gettype($requestValue);
                            if ($expectedDataType !== $requestDataType) {
                                $errors[] = [
                                    "field_name" => $fieldName,
                                    'error' => "Data type mismatch for $fieldName. Database: $expectedDataType, Requested: $requestDataType"
                                ];
                            }
                        }
                    }
                }

                if($templateDetails) {
                    foreach ($templateDetails as $detail) {
                        $fieldName = $detail->field_name;
                        $validation = $detail->validation_id;
                        $requestValue = $request->payload[$fieldName];
                        $existValidation = Validation::find($validation);
                        return $existValidation;
                        if ($requestValue !== null) {
                            if ($validation == 1) {
                                if (!preg_match('/^[a-zA-Z_]{2,}$/', $requestValue)) {
                                    $errors[] = [
                                        "field_name" => $fieldName,
                                        'error' => "Validation failed for $fieldName: String type validation"
                                    ];
                                }
                            } elseif ($validation == 2) { 
                                if (!preg_match('/^[a-zA-Z_]{2,}[0-9]{1,}$/', $requestValue)) {
                                    $errors[] = [
                                        "field_name" => $fieldName,
                                        'error' => "Validation failed for $fieldName: Alpha numeric validation"
                                    ];
                                }
                            } elseif ($validation == 3) { 
                                if (!filter_var($requestValue, FILTER_VALIDATE_EMAIL, FILTER_SANITIZE_EMAIL)) {
                                    $errors[] = [
                                        "field_name" => $fieldName,
                                        'error' => "Validation failed for $fieldName: Email validation"
                                    ];
                                }
                            } elseif ($validation == 4) { 
                               
                            } elseif ($validation == 5) {
                                // exists:template_names,id
                                $errors[] = [
                                    "field_name" => $fieldName,
                                    'error' => "Validation failed for $fieldName"
                                ];
                            } else {}
                        }
                    }
                }

                // if(!empty($errors)) {
                //     return response()->json([
                //         'status' => false,
                //         'errors' => $errors
                //     ]);
                // }

                // $templatePayloadData = new TemplatePayloadData();
                // $templatePayloadData->template_name_id = $request->template_id;
                // $templatePayloadData->data = $request->payload;
                // return $templatePayloadData;
                // $templatePayloadData->save();
            } else {

            }
    }


    // public function templatePayloadDetails(Request $request) {
    //     $templateDetails = TemplateFields::where('template_name_id', $request->template_id)->get();

    //     $errors = [];
    //     $fieldFromDatabase = $templateDetails->pluck('field_name')->toArray();

    //     // 4. Validate required fields and data types:
    //     foreach ($templateDetails as $details) {
    //         $fieldName = $details->field_name;

    //         if (!array_key_exists($fieldName, $request->all())) {
    //             $errors[] = [
    //                 "field_name" => $fieldName,
    //                 'error' => "Field $fieldName is missing in the request data",
    //             ];
    //             continue; // Skip further validation for missing fields
    //         }

    //         $requestDataValue = $request->get($fieldName);
    //         $expectedDataType = $details->data_type_id; 
    //         $dataTypeFromDatabase = gettype($requestDataValue); 
    //         return $dataTypeFromDatabase;
    //         if ($expectedDataType && $this->dataTypesDiffer($expectedDataType, $dataTypeFromDatabase)) {
    //             $errors[] = [
    //                 "field_name" => $fieldName,
    //                 'error' => "Field $fieldName has an incorrect data type. Expected: " . DataType::find($expectedDataType)->data_type_value . ", Received: " . $dataTypeFromDatabase,
    //             ];
    //         }
    //     }

    //     if (count($errors) > 0) {
    //         return response()->json([
    //             'errors' => $errors
    //         ], 422);
    //     }
    // }

    // private function dataTypesDiffer($expectedType, $actualType) {
    //     $expectedType = strtolower($expectedType); // Ensure case-insensitivity
    //     $actualType = strtolower($actualType);
    //     if (in_array($actualType, ['string', 'integer', 'double', 'boolean', 'float'])) {
    //         return $expectedType !== $actualType;
    //     }
    //     return true;
    // }
    

    private function validateDiffer() {

    }


}
