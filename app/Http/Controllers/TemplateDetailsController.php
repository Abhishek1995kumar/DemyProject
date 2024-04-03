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


    public function getTemplatePayloadDetails(Request $request) {
        try {
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

            if($request->has('payload')) {
                $errors= [];
                foreach($templateDetails as $payload) {
                    $dataType = DataType::find($payload->data_type_id);
                    $validation = Validation::find($payload->validation_id);
                    $actualType = gettype($request->payload[$payload->field_name]);
                    $requestValue = $request->payload[$payload->field_name];
                    $actualType = gettype($requestValue);

                    if (!in_array($payload->field_name, array_keys($request->payload))) {
                        $errors[] = [
                            "field_name" => $payload->field_name,
                            'error' => "Field is mandatory but missing in $payload->field_name"
                        ];
                    }

                    if ($dataType->data_type_value !== $actualType) {
                        $errors[] = [
                            'field_name' => $payload->field_name,
                            'error' => "Data type is not matching. Database : $dataType->data_type_value, Request payload : $actualType"
                            
                        ];
                        
                    }

                    if ($validation && !empty($validation->validation_value)) {
                        if (!Validator::make([$payload->field_name => $request->payload[$payload->field_name]], [$payload->field_name => $validation->validation_value])->passes()) {
                            $errors[] = [
                                "field_name" => $payload->field_name,
                                "error" => "Validation failed for $payload->field_name"
                            ];
                        }
                    }

                    if($payload->is_mandatory == 1 && empty($request->payload[$payload->field_name])) {
                        $errors[] = [
                            "field_name" => $payload->field_name,
                            "error" => "$payload->field_name field is mandatory but missing in $payload->field_name"
                        ]; 
                    } 
                }

                if(!empty($errors)) {
                    return response()->json([
                        'status' => false,
                        'errors' => $errors
                    ]);  
                }

            } else {

                $errors= [];
                $fieldFromDatabase = $templateDetails->pluck('field_name')->toArray();
                $requestField = array_keys($request->all());
                $requestValue = array_values($request->all());
                $requestField = array_diff(array_keys($request->except('template_id')), ['template_id']);
                
                foreach($requestField as $field) {
                    if(!in_array($field, $fieldFromDatabase)) {
                        $errors[] = [
                            "field_name" =>  $field,
                            'error' => "Field $field is missing in the request data"
                        ];
                    }
                }

                
                foreach($templateDetails as $details) {
                    $validation = Validation::find($details->validation_id);
                    $dataType = DataType::find($details->data_type_id);
                    $expectedDataType = $dataType->data_type_value;
                    $fieldName = $details->field_name;
                    
                    if(array_key_exists($fieldName, $request->all()) && $expectedDataType !== gettype($request->$fieldName)) {
                        $errors[] = [
                            "field_name" =>  $fieldName,
                            'error' => "Invalid data type for field $fieldName. Expected {$expectedDataType}."
                        ];
                    }
                }
            }

            if(!empty($errors)) {
                return response()->json($errors);
            }

            $templatePayloadData = new TemplatePayloadData();
            $templatePayloadData->template_name_id = $request->template_id;
            $templatePayloadData->data = $request->payload;
            // $templatePayloadData->save();

            return response()->json([
               'status' => true,
               'message' => 'Template payload is saved successfully',
            ]);

        } catch(Exception $e) { 
            return response()->json([
                'status' => false,
                'errors' => $e->getMessage(),
                Log::info($e->getMessage(), [$e->getTraceAsString()])
            ]);
        }
    }

}
