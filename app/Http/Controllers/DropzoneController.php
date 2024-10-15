<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DropzoneController extends Controller
{
    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:2048',
        ]);

        $type = $request->header('type');
        $file = $request->file('file');

        if ($file->extension() == 'jpeg' || $file->extension() == 'jpg' || $file->extension() == 'png') {
            $request->validate([
                'file' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $path = 'images';
        } else {
            $request->validate([
                'file' => 'required|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,rar|max:2048',
            ]);
            $path = 'files';
        }

        $fileName = $type . '_' . $path . '_' . time() . '.' . $file->extension();
        $file->move(public_path($path . '/' . $type), $fileName);

        return response()->json(['success' => $fileName]);
    }

    public function deleteUploadedFile(Request $request)
    {
        $fileName = $request->input('filename');
        $path = $request->input('path');
        $filePath = public_path($path . '/' . $fileName);

        if (File::exists($filePath)) {
            File::delete($filePath);
            return response()->json(['success' => 'File removed successfully.']);
        }

        return response()->json(['error' => 'File not found.'], 404);
    }
}
