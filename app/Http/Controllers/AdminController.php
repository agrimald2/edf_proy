<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\BlackList;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
                    'reason' => $row[1],
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
                'customers' => 'required|file',
            ]);

            $file = $request->file('customers');
            $path = $file->store('customers');

            // Load the Excel file and assume the data is in the first sheet
            $rows = Excel::toArray([], $file)[0];
            // Skip the first row (header)
            array_shift($rows);

            // Empty the Customer table using raw SQL
            DB::statement('TRUNCATE TABLE customers');

            // Prepare the data for bulk insertion using raw SQL
            $insertData = [];
            foreach ($rows as $row) {
                $insertData[] = [
                    $row[0],  // code
                    $row[1],  // volumen_cu
                ];
            }

            // Use transaction to handle large batch insert
            DB::beginTransaction();

            $insertQuery = 'INSERT INTO customers (code, volumen_cu) VALUES (?, ?)';
            foreach ($insertData as $data) {
                DB::insert($insertQuery, $data);
            }

            DB::commit();

            return response()->json(['message' => 'Customers uploaded successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to upload customers: ' . $e->getMessage());
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
