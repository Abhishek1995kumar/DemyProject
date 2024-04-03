<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Payload;
use App\Models\TemplateName;
use Illuminate\Http\Request;
use App\Models\TemplateField;
use App\Models\TemplateFields;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TemplateNameController extends Controller
{
    // CREATE API CODE
    public function create(Request $request)
    {
        try {
            $rules = [
                'template_name' => 'required',
                'fields.*.validation_id' => 'required',
                'fields.*.datatype_id' => 'required',
                'fields.*.field_name' => 'required'
            ];

            $messages = [
                'template_name.required' => 'Template name is required',
                'validation_id.required' => 'Validation_id is required',
                'datatype_id.required' => 'Datatype_id is required',
                'field_name.required' => 'Field name is required'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ]);
            } else {
                $template_obj = new TemplateName();
                $template_obj->template_name = $request->template_name;
                $template_obj->save();

                $templateFieldArray = $request->fields;

                foreach ($templateFieldArray as $data) {
                    $template_field_obj = new TemplateFields();
                    $template_field_obj->template_id = $template_obj->id;
                    $template_field_obj->validation_id = $data['validation_id'];
                    $template_field_obj->datatype_id = $data['datatype_id'];
                    $template_field_obj->field_name = $data['field_name'];
                    $template_field_obj->save();
                }
                return response()->json(['message' => 'Created Successfully']);
            }
        } catch (Exception $e) {
            Log::info($e->getMessage(), [$e->getTraceAsString()]);
            return response()->json($e->getMessage());
        }
    }


    // UPDATE & DELETE API CODE
    public function update(Request $request)
    {
        try {
            $rules = [
                'id' => 'required',
                'fields.*.validation_id' => 'required|exists:',
                'fields.*.datatype_id' => 'required|exists:',
                'fields.*.field_name' => 'required'
            ];

            $messages = [
                'Id.required' => 'Id is required',
                'validation_id.required' => 'Validation_id is required',
                'datatype_id.required' => 'Datatype_id is required',
                'field_name.required' => 'Field name is required'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ]);
            } else {
                $template = TemplateName::find($request->id);
                $template->template_name = $request->template_name;
                $template->save();

                $templateUpdateArray = $request->fields;
                $templateFieldData = TemplateFields::all();

                foreach ($templateUpdateArray as $data1) {
                    foreach ($templateFieldData as $data2) {
                        if ($data1['field_id'] != $data2['id']) {
                            $data2->delete();
                        }
                    }
                }

                foreach ($templateUpdateArray as $data) {
                    $update_obj = TemplateFields::find($data["field_id"]);

                    if (!$update_obj) {
                        $update_obj = new TemplateFields();
                        $update_obj->template_id = $template->id;
                        $update_obj->id = $data["field_id"];
                    }
                    $update_obj->validation_id = $data['validation_id'];
                    $update_obj->datatype_id = $data['datatype_id'];
                    $update_obj->field_name = $data['field_name'];
                    $update_obj->save();
                }

                return response()->json(['message' => 'Updated Successfully']);
            }
        } catch (Exception $e) {
            Log::info($e->getMessage(), [$e->getTraceAsString()]);
            return response()->json($e->getMessage());
        }
    }



    // PAYLOAD API CODE
    public function payload(Request $request)
    {
        try {
            $rules = [
                'template_id' => 'integer|exists:templates,id',
                'payload' => 'array'
            ];

            $message = [
                'template_id' => 'Template id is not found',
                'payload' => 'Payload is required',
                'payload.array' => 'Payload must be array type but given is not a array type',
            ];

            $validator = Validator::make($request->all(), $rules, $message);

            if ($validator->fails()) {
                return response()->json([
                    'Errors' => $validator->errors()
                ]);
            } else {
                $payload = new Payload();
                $payload->template_id = $request->template_id;
                
                $payload->save();
            }
        } catch (Exception $e) {
            Log::info($e->getMessage(), [$e->getTraceAsString()]);
            return response()->json($e->getMessage());
        }
    }
}
