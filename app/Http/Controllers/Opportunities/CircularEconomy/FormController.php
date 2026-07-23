<?php

namespace App\Http\Controllers\Opportunities\CircularEconomy;

use App\Models\Opportunities\CircularEconomy\FormBuilder;
use App\Models\Opportunities\CircularEconomy\FormSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class FormController extends Controller
{
    /**
     * Process a form submission
     */
    public function submit(Request $request, $id)
    {
        $form = FormBuilder::findOrFail($id);
        
        if (!$form->is_active) {
            return redirect()->back()->with('error', __('This form is no longer active.'));
        }
        
        // Validate the form based on its fields
        $rules = [];
        $messages = [];
        $fileFields = [];
        
        $fields = $form->fields;
        if (is_string($fields)) {
            $fields = json_decode($fields, true);
        }
        
        foreach ($fields as $field) {
            if (!isset($field['name'])) {
                // Generate a default name using the field ID or index
                $fieldId = $field['id'] ?? uniqid('field_');
                $field['name'] = 'field_' . $fieldId;
            }
            
            if ($field['type'] === 'file') {
                $fileFields[] = $field['name'];
                $rules[$field['name']] = 'nullable';
                if ($field['required']) {
                    $rules[$field['name']] .= '|required';
                }
                if (isset($field['accept'])) {
                    $mimes = str_replace('.', '', $field['accept']);
                    $mimes = str_replace(',', '|', $mimes);
                    $rules[$field['name']] .= '|mimes:' . $mimes;
                }
                $rules[$field['name']] .= '|max:5120'; // 5MB max
            } else {
                $rules[$field['name']] = 'nullable';
                if ($field['required']) {
                    $rules[$field['name']] .= '|required';
                }
                
                if ($field['type'] === 'email') {
                    $rules[$field['name']] .= '|email';
                } elseif ($field['type'] === 'number') {
                    $rules[$field['name']] .= '|numeric';
                    if (isset($field['min'])) {
                        $rules[$field['name']] .= '|min:' . $field['min'];
                    }
                    if (isset($field['max'])) {
                        $rules[$field['name']] .= '|max:' . $field['max'];
                    }
                } elseif ($field['type'] === 'url') {
                    $rules[$field['name']] .= '|url';
                } elseif ($field['type'] === 'tel') {
                    $rules[$field['name']] .= '|regex:/^[0-9\+\-\(\)\s]*$/';
                }
            }
            
            if ($field['required']) {
                $messages[$field['name'] . '.required'] = __('The :attribute field is required.', ['attribute' => $field['label']]);
            }
        }
        
        $validated = $request->validate($rules, $messages);
        
        // Process file uploads
        $data = [];
        foreach ($validated as $key => $value) {
            if (in_array($key, $fileFields) && $request->hasFile($key) && $request->file($key)->isValid()) {
                $path = $request->file($key)->store('form-uploads/' . $form->id, 'public');
                $data[$key] = $path;
            } else {
                $data[$key] = $value;
            }
        }
        
        // Create form submission
        $submission = new FormSubmission();
        $submission->form_builder_id = $form->id;
        $submission->data = json_encode($data);
        $submission->ip_address = $request->ip();
        $submission->user_agent = $request->userAgent();
        $submission->save();
        
        // Send notifications if configured
        if ($form->notifications_enabled && !empty($form->notification_email)) {
            // TODO: Implement email notifications
        }
        
        if ($form->success_message) {
            $message = $form->success_message;
        } else {
            $message = __('Thank you! Your form has been submitted successfully.');
        }
        
        if ($form->redirect_url) {
            return redirect($form->redirect_url)->with('success', $message);
        }
        
        return redirect()->back()->with('success', $message);
    }
} 