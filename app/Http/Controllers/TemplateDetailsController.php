<?php

namespace App\Http\Controllers;

use App\Models\TemplateFields;
use Exception;
use App\Models\TemplateName;
use App\Models\Validation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class TemplateDetailsController extends Controller {
    public function saveTemplateNameFields(Request $request) {
        try {
            $rules = [
                'template_name' => 'required',
                'data.*.validation_id' =>'required|exists:validations,id', // when i want to send multiple data in databse and that time we need to check validation than use this method
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

    public function getTemplatePayloadDetails(Request $request) {
        try{
            $rules = [
                'template_id' => 'required|exists:template_names,id',
                'data' => 'required|array',
            ];

            $message = [
                'template_id' => 'The : Templates field is required, please select a template id',
            ];

            $validator = Validator::make($request->all(), $rules, $message);

            if($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ]);
            } else {
                $templateNameRecord = TemplateName::when($request->has('id'), function($query) use ($request) {
                    $query->whereHas('templateField', function($q) use ($request) {
                        $q->where('template_name_id', $request->id);
                    });
                })->with('templateField')->get();

                if(!empty($templateNameRecord)) {
                    try{
                        foreach($templateNameRecord as $key => &$template) {
                            foreach($template->templateField as $field) {
                                $templateField = [
                                    'template_name_id' => $field->template_name_id,
                                ];
                            }
                        }

                        foreach($templateNameRecord as $key => &$templateId) {
                            
                        }   

                    } catch (Exception $e) { 
                        return response()->json([
                        'status' => false,
                            'errors' => $e->getMessage()
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

        }
    }
}
