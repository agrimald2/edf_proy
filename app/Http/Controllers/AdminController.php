<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\BlackList;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Log;
Use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Permuta;

class AdminController extends Controller
{
    public function notificacionsIndex()
    {
        return Inertia::render('Admin/Notifications/Index');
    }

    public function blackListIndex()
    {
        return Inertia::render('Admin/BlackList/Index');
    }


    public function uploadBlackList(Request $request)
    {
        try {
            $request->validate([
                'blacklist' => 'required|file|mimes:xlsx,xls',
            ]);

            // Empty the BlackList table
            BlackList::truncate();

            $file = $request->file('blacklist');
            $path = $file->store('blacklist');

            // Load the Excel file
            $rows = Excel::toArray([], $file)[0]; // Assuming the data is in the first sheet

            // Parse the data and insert into the BlackList model
            foreach ($rows as $row) {
                BlackList::create([
                    'client_code' => $row[0],
                ]);
            }

            return response()->json(['message' => 'Blacklist uploaded successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to upload blacklist: ' . $e->getMessage()], 500);
        }
    }
    public function customersIndex()
    {
        return Inertia::render('Admin/Customers/Index');
    }

    public function uploadCustomers(Request $request)
    {
        try {
            // Validate the uploaded file
            $request->validate([
                'customers' => 'required',
            ]);

            // Retrieve the uploaded file
            $file = $request->file('customers');

            // Check for upload errors
            if ($file->getError() != UPLOAD_ERR_OK) {
                throw new \Exception('Error uploading file: ' . $file->getErrorMessage());
            }

            // Store the file
            $path = $file->store('customers');

            // Load the Excel file
            $rows = Excel::toArray([], $file)[0]; // Assuming the data is in the first sheet

            // Empty the Customer table
            Customer::truncate();

            // Parse the data and insert into the Customer model
            foreach ($rows as $row) {
                Customer::create([
                    'code' => $row[0],
                    'volumen_cu' => $row[1],
                ]);
            }

            return response()->json(['message' => 'Customers uploaded successfully']);
        } catch (\Exception $e) {
            Log::error('Failed to upload customers: ' . $e->getMessage());
            Log::error($e);
            return response()->json(['message' => 'Failed to upload customers: ' . $e->getMessage()], 500);
        }
    }

    public function getPermutas(Request $request)
    {
        $permutas = Permuta::all();
        return response()->json(['permutas' => $permutas]);
    }

    public function deletePermuta($id)
    {
        $permuta = Permuta::find($id);
        $permuta->delete();
        return response()->json(['message' => 'Permuta deleted successfully']);
    }
}
