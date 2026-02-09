<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource with filters.
     */
    public function index(Request $request)
    {
        $query = Absensi::with('user');

        // Filter by user_id
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('start_date')) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        }

        if ($request->has('end_date')) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }

        // Filter by specific date
        if ($request->has('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // Filter by month and year
        if ($request->has('month') && $request->has('year')) {
            $query->whereMonth('tanggal', $request->month)
                  ->whereYear('tanggal', $request->year);
        }

        // Search by user name or npk
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('npk', 'like', "%{$search}%");
            });
        }

        // Order by
        $orderBy = $request->get('order_by', 'tanggal');
        $orderDir = $request->get('order_dir', 'desc');
        $query->orderBy($orderBy, $orderDir);

        $absensi = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $absensi
        ]);
    }

    /**
     * Clock in.
     */
    public function clockIn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'clock_in_image' => 'required|image|max:2048',
            'clock_in_lat' => 'required|string',
            'clock_in_long' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if already clocked in today
        $existingAbsensi = Absensi::where('user_id', $request->user_id)
            ->whereDate('tanggal', $request->tanggal)
            ->first();

        if ($existingAbsensi) {
            return response()->json([
                'success' => false,
                'message' => 'Already clocked in today'
            ], 400);
        }

        $data = [
            'user_id' => $request->user_id,
            'tanggal' => $request->tanggal,
            'clock_in' => now()->format('H:i:s'),
            'clock_in_lat' => $request->clock_in_lat,
            'clock_in_long' => $request->clock_in_long,
        ];

        // Handle image upload
        if ($request->hasFile('clock_in_image')) {
            $image = $request->file('clock_in_image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('absensi/clock_in');

            // Create directory if not exists
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $image->move($destinationPath, $filename);
            $data['clock_in_image'] = 'absensi/clock_in/' . $filename;
        }

        // Calculate if late (assuming work starts at 08:00)
        $clockInTime = Carbon::parse($data['clock_in']);
        $workStartTime = Carbon::parse('08:00:00');

        if ($clockInTime->gt($workStartTime)) {
            $data['late_duration'] = $clockInTime->diffInMinutes($workStartTime);
            $data['status'] = 'terlambat';
        } else {
            $data['late_duration'] = 0;
            $data['status'] = 'hadir';
        }

        $absensi = Absensi::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Clock in successful',
            'data' => $absensi->load('user')
        ], 201);
    }

    /**
     * Clock out.
     */
    public function clockOut(Request $request, string $id)
    {
        $absensi = Absensi::find($id);

        if (!$absensi) {
            return response()->json([
                'success' => false,
                'message' => 'Absensi not found'
            ], 404);
        }

        if ($absensi->clock_out) {
            return response()->json([
                'success' => false,
                'message' => 'Already clocked out'
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'clock_out_image' => 'required|image|max:2048',
            'clock_out_lat' => 'required|string',
            'clock_out_long' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = [
            'clock_out' => now()->format('H:i:s'),
            'clock_out_lat' => $request->clock_out_lat,
            'clock_out_long' => $request->clock_out_long,
        ];

        // Handle image upload
        if ($request->hasFile('clock_out_image')) {
            $image = $request->file('clock_out_image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('absensi/clock_out');

            // Create directory if not exists
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $image->move($destinationPath, $filename);
            $data['clock_out_image'] = 'absensi/clock_out/' . $filename;
        }

        $absensi->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Clock out successful',
            'data' => $absensi->load('user')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $absensi = Absensi::with('user')->find($id);

        if (!$absensi) {
            return response()->json([
                'success' => false,
                'message' => 'Absensi not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $absensi
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $absensi = Absensi::find($id);

        if (!$absensi) {
            return response()->json([
                'success' => false,
                'message' => 'Absensi not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'sometimes|in:hadir,izin,sakit,terlambat',
            'late_duration' => 'sometimes|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $absensi->update($request->only(['status', 'late_duration']));

        return response()->json([
            'success' => true,
            'message' => 'Absensi updated successfully',
            'data' => $absensi->load('user')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $absensi = Absensi::find($id);

        if (!$absensi) {
            return response()->json([
                'success' => false,
                'message' => 'Absensi not found'
            ], 404);
        }

        // Delete images if exist
        if ($absensi->clock_in_image) {
            $imagePath = public_path($absensi->clock_in_image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        if ($absensi->clock_out_image) {
            $imagePath = public_path($absensi->clock_out_image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $absensi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Absensi deleted successfully'
        ]);
    }

    /**
     * Export to Excel.
     */
    public function exportExcel(Request $request)
    {
        $query = Absensi::with('user');

        // Apply same filters as index
        $this->applyFilters($query, $request);

        $absensi = $query->get();

        $filename = 'absensi_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($absensi) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, [
                'ID',
                'NPK',
                'Nama',
                'Tanggal',
                'Clock In',
                'Clock Out',
                'Keterlambatan (menit)',
                'Status',
                'Lokasi Clock In',
                'Lokasi Clock Out'
            ]);

            // Add data
            foreach ($absensi as $item) {
                fputcsv($file, [
                    $item->id,
                    $item->user->npk,
                    $item->user->nama,
                    $item->tanggal->format('Y-m-d'),
                    $item->clock_in,
                    $item->clock_out ?? '-',
                    $item->late_duration,
                    $item->status ?? '-',
                    $item->clock_in_lat && $item->clock_in_long
                        ? $item->clock_in_lat . ', ' . $item->clock_in_long
                        : '-',
                    $item->clock_out_lat && $item->clock_out_long
                        ? $item->clock_out_lat . ', ' . $item->clock_out_long
                        : '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export to PDF.
     */
    public function exportPdf(Request $request)
    {
        $query = Absensi::with('user');

        // Apply same filters as index
        $this->applyFilters($query, $request);

        $absensi = $query->get();

        $pdf = Pdf::loadView('pdf.absensi', [
            'absensi' => $absensi,
            'title' => 'Laporan Absensi',
            'generated_at' => now()->format('d/m/Y H:i:s')
        ]);

        return $pdf->download('absensi_' . now()->format('Y-m-d_His') . '.pdf');
    }

    /**
     * Get user statistics.
     */
    public function userStats(Request $request, string $userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        $query = Absensi::where('user_id', $userId);

        // Filter by month and year
        if ($request->has('month') && $request->has('year')) {
            $query->whereMonth('tanggal', $request->month)
                  ->whereYear('tanggal', $request->year);
        }

        $stats = [
            'total_hadir' => (clone $query)->where('status', 'hadir')->count(),
            'total_terlambat' => (clone $query)->where('status', 'terlambat')->count(),
            'total_izin' => (clone $query)->where('status', 'izin')->count(),
            'total_sakit' => (clone $query)->where('status', 'sakit')->count(),
            'total_late_minutes' => (clone $query)->sum('late_duration'),
            'average_late_minutes' => (clone $query)->where('late_duration', '>', 0)->avg('late_duration'),
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user,
                'stats' => $stats
            ]
        ]);
    }

    /**
     * Apply filters to query.
     */
    private function applyFilters($query, $request)
    {
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('start_date')) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        }

        if ($request->has('end_date')) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }

        if ($request->has('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->has('month') && $request->has('year')) {
            $query->whereMonth('tanggal', $request->month)
                  ->whereYear('tanggal', $request->year);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('npk', 'like', "%{$search}%");
            });
        }

        return $query;
    }
}
