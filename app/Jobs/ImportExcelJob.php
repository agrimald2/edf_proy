<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImportExcelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;

    /**
     * Create a new job instance.
     *
     * @param string $filePath
     * @return void
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Log::info('Replacing data from Excel in background job');

        // Use the stored file path to read the Excel file into an array
        $data = Excel::toArray([], storage_path('app/' . $this->filePath))[0];
        $data = array_slice($data, 1); // Skip header row

        // Truncate the mains table
        DB::table('mains')->truncate();

        // Disable Laravel's query log for this transaction
        DB::connection()->disableQueryLog();

        // Use a database transaction to wrap the insert operations
        DB::beginTransaction();
        try {
            // Prepare the data for insertion
            $insertData = collect($data)->map(function ($row) {
                return [
                    'COD_CLIENTE' => $row[0],
                    'RUTA' => $row[1],
                    'FREC_VISITA' => $row[2],
                    'CLIENTE' => $row[3],
                    'DIRECCION' => $row[4],
                    'SV' => $row[5],
                    'GV' => $row[6],
                    'NOMBRE_SV' => $row[7],
                    'TAMANO' => $row[8],
                    'PROMEDIO_CU_3M' => $row[9],
                    'N_EDF' => $row[10],
                    'N_PUERTAS' => $row[11],
                    'CONDICION' => $row[12],
                    'PUERTAS_A_NEGOCIAR' => $row[13],
                    'CONDICION_2' => $row[14],
                    'PUERTAS_A_NEGOCIAR_2' => $row[15],
                    'NEGOCIADO' => $row[16],
                    'STATUS' => $row[17],
                    'CUOTA' => $row[18],
                    'SV_LIMIT' => $row[19],
                    'LOCACION' => $row[20],
                    'TALLER' => $row[21],
                    'FECHA_NEGOCIADO' => $row[22],
                    'PROMEDIO_MES' => $row[23],
                    'EDF_NEGOCIADOS' => $row[24],
                ];
            })->toArray();

            // Insert the data in chunks to avoid memory issues
            $batchSize = 10000; // Adjust batch size for better performance
            $chunks = array_chunk($insertData, $batchSize);
            foreach ($chunks as $chunk) {
                DB::table('mains')->insertOrIgnore($chunk);
            }

            DB::commit(); // Commit the transaction
            \Log::info('Data has been replaced successfully in background job');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on error
            \Log::error('Error in background job: ' . $e->getMessage());
        }

        // After processing, you may want to delete the temporary file
        Storage::delete($this->filePath);
    }
}