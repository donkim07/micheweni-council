<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Opportunities\CircularEconomy\FormBuilder;
use App\Models\Opportunities\CircularEconomy\FormSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FormSubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = FormSubmission::with(['form', 'user']);
        
        // Filter by form if provided
        if ($request->has('form_id') && !empty($request->form_id)) {
            $query->where('form_builder_id', $request->form_id);
        }
        
        // Filter by status if provided
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        $submissions = $query->orderBy('created_at', 'desc')->paginate(15);
        $forms = FormBuilder::pluck('title', 'id')->toArray();
        $statuses = $this->getStatusOptions();
        
        return view('admin.form-submissions.index', compact('submissions', 'forms', 'statuses'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $submission = FormSubmission::with(['form', 'user'])->findOrFail($id);
        $statuses = $this->getStatusOptions();
        
        // Ensure data is in array format
        if (is_string($submission->data)) {
            $submission->data = json_decode($submission->data, true) ?? [];
        }
        
        return view('admin.form-submissions.show', compact('submission', 'statuses'));
    }

    /**
     * Update the status of the specified resource.
     */
    public function updateStatus(Request $request, string $id)
    {
        $submission = FormSubmission::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|string|in:pending,approved,rejected,archived',
        ]);
        
        $submission->update(['status' => $validated['status']]);
        
        return redirect()->route('admin.form-submissions.show', $submission)
            ->with('success', __('Submission status updated successfully.'));
    }

    /**
     * Export submissions to CSV.
     */
    public function export(Request $request)
    {
        $formId = $request->input('form_id');
        
        if (!$formId) {
            return back()->with('error', __('Please select a form to export.'));
        }
        
        $form = FormBuilder::findOrFail($formId);
        $submissions = FormSubmission::where('form_builder_id', $formId)->get();
        
        if ($submissions->isEmpty()) {
            return back()->with('error', __('No submissions found for this form.'));
        }
        
        // Create CSV content
        $headers = ['ID', 'Date', 'Status'];
        
        // Add field headers from the form structure
        foreach ($form->fields as $field) {
            if (in_array($field['type'], ['heading', 'divider', 'html'])) {
                continue; // Skip non-input fields
            }
            $headers[] = $field['label'];
        }
        
        $headers[] = 'Location';
        $headers[] = 'Address';
        $headers[] = 'User';
        
        $csvContent = implode(',', $headers) . "\n";
        
        foreach ($submissions as $submission) {
            $row = [
                $submission->id,
                $submission->created_at->format('Y-m-d H:i'),
                $submission->status,
            ];
            
            // Add field values
            foreach ($form->fields as $field) {
                if (in_array($field['type'], ['heading', 'divider', 'html'])) {
                    continue; // Skip non-input fields
                }
                
                $fieldName = $field['name'];
                $value = isset($submission->data[$fieldName]) ? $submission->data[$fieldName] : '';
                
                // Format array values
                if (is_array($value)) {
                    $value = implode('; ', $value);
                }
                
                // Escape CSV special characters
                $value = str_replace('"', '""', $value);
                if (strpos($value, ',') !== false || strpos($value, '"') !== false || strpos($value, "\n") !== false) {
                    $value = '"' . $value . '"';
                }
                
                $row[] = $value;
            }
            
            // Add location data
            $location = '';
            if ($submission->latitude && $submission->longitude) {
                $location = $submission->latitude . ', ' . $submission->longitude;
            }
            $row[] = $location;
            $row[] = $submission->address ?? '';
            $row[] = $submission->user ? $submission->user->name : 'Guest';
            
            $csvContent .= implode(',', $row) . "\n";
        }
        
        // Generate filename
        $filename = Str::slug($form->title) . '-submissions-' . date('Y-m-d') . '.csv';
        
        // Create response
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        return response($csvContent, 200, $headers);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $submission = FormSubmission::findOrFail($id);
        
        // Delete any uploaded files if necessary
        // This would require additional logic to track and manage file uploads
        
        $submission->delete();
        
        return redirect()->route('admin.form-submissions.index')
            ->with('success', __('Submission deleted successfully.'));
    }
    
    /**
     * Get status options for submissions.
     */
    private function getStatusOptions()
    {
        return [
            'pending' => __('Pending'),
            'approved' => __('Approved'),
            'rejected' => __('Rejected'),
            'archived' => __('Archived'),
        ];
    }
} 