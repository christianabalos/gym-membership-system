<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class MemberImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'import_file' => 'required|file|mimes:csv,txt'
        ]);

        $file = $request->file('import_file');
        $path = $file->getRealPath();
        
        // Basahin ang CSV
        $handle = fopen($path, 'r');
        $header = fgetcsv($handle);
        
        if (!$header) {
            return back()->with('error', 'Invalid CSV file.');
        }

        while (($row = fgetcsv($handle)) !== false) {
            if (count($header) !== count($row)) continue;
            
            $data = array_combine($header, $row);

            Member::create([
                'full_name' => $data['full_name'] ?? 'N/A',
                'email'     => $data['email'] ?? null,
                'phone'     => $data['phone'] ?? null,
                'gender'    => $data['gender'] ?? 'Not specified',
                'password'  => bcrypt('default_password123'),
            ]);
        }
        
        fclose($handle);
        return back()->with('success', 'Import success!');
    }
}