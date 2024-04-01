<?php

namespace App\Traits;


use App\Models\TemplateFields;
use Exception;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\TemplateName;
use Illuminate\Support\Facades\Validator;

trait TemplateTrait {
    public function index() {
        return "hello world";
    }


    public function storeTemplateNameAndField(Request $request) {
        try{
            $rules = [
                'template_name' => 'required',
                'data.*.validation_id' =>'required|exists:validations,id', // when i want to send multiple data in databse on that time we need to check validation, this reason we use this method
                'data.*.data_type_id'  =>'required|exists:data_types,id', // we getting data from postman 
                'data.*.field_name'    =>'required',   // * -- mean indexing, Indexing the records in the data where I am setting
                'data.*.is_mandatory'  =>'required',
            ];

            $message = [
                'templete_name.numeric' => 'Template name is mandatory, please provide a template name',
                'templete_name.string' => 'Template name must be string or character type, please check template name is manually',
                'validation_id.requierd' => 'Validation id field is mandatory, please provide a validation id',
                'validation_id.exists' => 'Validation id field does not exist in database, please check validation id is manually',
                'validation_id.numeric' => 'Validation id field must be numeric type, please check validation id is manually',
                'data_type_id.requierd' => 'Data type id field is mandatory, please provide a data type id',
                'data_type_id.exists' => 'Data type id field does not exist in database, please check data type id is manually',
                'data_type_id.numeric' => 'Data type id field must be numeric type, please check Data type id is manually',
                'is_mandatory.requierd' => 'Is mandatory field is mandatory, please provide a is mandatory',
                'is_mandatory.numeric' => 'Is mandatory field must be a numeric type,please check is mandatory is manually',
                'field_name.requierd' => 'Template field name is mandatory, please provide a field name',
                'field_name.string' => 'Template field name must be string or character type, please check field name is manually'
            ];

            $validator = Validator::make($request->all(), $rules, $message);

            if($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ]);
            } else {
                $templateDetails  = new TemplateName();
                $templateDetails->template_name = $request->template_name;
                $templateDetails->status = $request->status ?? 1;
                $templateDetails->created_at = now() ?? NULL;
                $templateDetails->updated_at = now() ?? NULL;
                // $templateDetails->save();

                $templateLastId = $templateDetails->id;

                // if($templateLastId) {
                    if($request->has('payload')) {
                        foreach($request->payload as $key => $value) {
                            $templateFieldsData = [
                                'template_name_id' => $templateDetails->id,
                                'validation_id' => $value['validation_id'],
                                'data_type_id' => $value['data_type_id'],   
                                'is_mandatory' => $value['is_mandatory'],   
                                'field_name' => $value['field_name'],   
                                'status' => $value['status'] ?? 1,   
                                'created_at' => now(),   
                                'updated_at' => now(),   
                            ];
                            // TemplateFields::insert($$templateFieldsData);
                        }
                        return $templateFieldsData;
                        return response()->json([
                            'status' => true,
                            'message' => 'Template and template fields payload is saved successfully',
                        ]);

                    } else {
                        $templateFields = new TemplateFields();
                        $templateFields->template_name_id = $templateDetails->id;
                        $templateFields->validation_id = $request->validation_id;
                        $templateFields->data_type_id = $request->data_type_id;   
                        $templateFields->is_mandatory = $request->is_mandatory;   
                        $templateFields->field_name = $request->field_name;
                        // $templateFields->save();

                        return response()->json([
                            'status' => true,
                            'message' => 'Template and template fields is saved successfully',
                        ]);
                    }

                // } else {
                //     return response()->json([
                //        'status' => false,
                //        'message' => 'Template id is not found, please check your template configuration settings',
                //     ]);
                // }

            }

        } catch(Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ]);
        }
    }   


    public function update(Request $request, Admin $admin) {

    }

}
