<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Validation;
use Illuminate\Http\Request;
use App\Models\TemplateName;
use App\Models\TemplateFields;
use App\Models\TemplatePayloadData;
use Illuminate\Support\Facades\Validator;

class TemplateDetailsController extends Controller {
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
                    if($request->has('data')) {
                        foreach($request->data as $key => $value) {
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
                        return response()->json([
                            'status' => true,
                            'data' => "template field created or updated successfully",
                        ]);

                    } else {
                        return response()->json([
                           'status' => false,
                           'message' => 'Template id is not found, please you can check template id is manually.',
                        ]);
                    }
                }

                return response()->json([
                   'status' => true,
                   'message' => 'Template Name and Template Field is saved successfully',
                ]);
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

                // $templateDetails = TemplateName::when($request->has('template_id'), function($query) use ($request) {
                //     $query->whereHas('templateField', function($q) use ($request) {
                //         $q->where('template_name_id', $request->template_id);
                //     });
                // })->with('templateField')->first();

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
                                        ->whereIn('field_name', $deffierenceFieldDatabase)->get(); // whereIn -- jab data as a array/collection me ho tab ham whereIn ka use karte hai
                            $del->delete();

                        }

                        // $deleteTemplateFields = TemplateFields::where('template_name_id', $request->id)->select('validation_id','data_type_id', 'is_mandatory', 'field_name')->get();

                        // $deletedValue = [];
                        // foreach ($deleteTemplateFields as $deleteField) {
                        //     $deletedValue[] = $deleteField->field_name;
                        // }

                        // $payloadFieldCollection = [];
                        // foreach($payloadFields as $pay) {
                        //     $payloadFieldCollection[] = $pay['field_name'];
                        // }

                        // if($deletedValue != $payloadFields) {
                        //     $defferenceField = array_diff($payloadFieldCollection, $deletedValue);
                        //     $del = TemplateFields::where('field_name', $defferenceField);
                        //     return $del;
                        // }

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
                    } else {

                        // return response()->json([
                        //    'status' => false,
                        //    'message' => 'Payload field is required',
                        // ]);
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
        try{
            $rules = [
                'data' => 'array',
                'template_id' => 'required|exists:template_names,id',
            ];

            $message = [
                'data.array' => 'Data field is like array, please use the valid data type',
                'template_id' => 'Template id field is required, please select a template id'
            ];

            $validator = Validator::make($request->all(), $rules, $message);

            if($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ]);

            } else {
                $templateNameRecord = TemplateName::when($request->has('template_id'), function($query) use ($request) {
                    $query->whereHas('templateField', function($q) use ($request) {
                        $q->where('template_name_id', $request->template_id);
                    });
                })->with('templateField')->get();

                if($templateNameRecord) {
                    if($request->has('payload')) {
                        $templatePayloadFieldData = [];
                        foreach($request->payload as $key => $value) {
                            $templatePayloadFieldData[$key] = $value;
                            
                        }
                        $errorFields = [];
                        foreach($templateNameRecord as $key => $value) {
                            $fieldKeys = array_keys($request->payload);
                            $fieldName = $value->templateField->pluck('field_name')->toArray();
                            $templatePayloadFieldDataId = $value->id;

                            $errorFields = array_diff($fieldKeys, $fieldName);

                        }
                        if(empty($errorFields)) {
                            $payloadDetails = new TemplatePayloadData();
                            $payloadDetails->template_name_id = $templatePayloadFieldDataId;
                            $payloadDetails->data = $templatePayloadFieldData;
                            $payloadDetails->save();
                            return response()->json([
                               'status' => true,
                               'message' => 'Template payload is saved successfully',
                            ]);

                        } else {
                            return response()->json([
                                'status' => false,
                                'message' => 'template field is not matching into database',
                                'errors' => $errorFields
                            ]);
                        }

                    } else {
                        foreach ($templateNameRecord as $template) {
                            $errorFields = [];
                            $templateFieldData = [];
                            $fieldName = $template->templateField->pluck('field_name')->toArray();

                            foreach ($template->templateField as $key => $field) {
                                $templateFieldData[$field->field_name] = $request->input($field->field_name);                              
                            }
                            
                            $errorFields = array_diff($fieldName, array_keys($templateFieldData));

                            if(empty($errorFields)) {
                                $payloadDetails = new TemplatePayloadData();
                                $payloadDetails->template_name_id = $template->id;
                                $payloadDetails->data = $templateFieldData;
                                $payloadDetails->save();
                                return response()->json([
                                   'status' => true,
                                   'message' => 'Template data is saved successfully',
                                ]);
                            } else {
                                return response()->json([
                                    'status' => false,
                                    'message' => 'Please fill all the required fields',
                                    'errors' => $errorFields
                                ]);
                            }
                        }
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



}
