<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flight;
use Illuminate\Support\Facades\Validator;

class TiketAdminController extends Controller
{
    public function index() {
        return view('admin.tiketadmin');
    }

    public function list() {
        try {
            $flights = Flight::orderBy('date', 'desc')->orderBy('departure_time', 'asc')->get();
            return response()->json($flights);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal mengambil data flight'], 500);
        }
    }

    public function store(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'airline_name' => 'required|string|max:150',
                'departure_city' => 'required|string|max:200',
                'departure_code' => 'required|string|max:20',
                'arrival_city' => 'required|string|max:200',
                'arrival_code' => 'required|string|max:20',
                'departure_time' => 'required|date_format:H:i',
                'arrival_time' => 'required|date_format:H:i',
                'duration' => 'required|string|max:50',
                'transit_info' => 'nullable|string|max:100',
                'price_display' => 'required|string|max:50',
                'price_int' => 'required|integer|min:0',
                'flight_class' => 'required|string|max:100',
                'date' => 'required|date'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $flight = Flight::create($request->all());

            return response()->json([
                'message' => 'Flight berhasil ditambahkan',
                'data' => $flight
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menambahkan flight: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id) {
        try {
            $flight = Flight::find($id);
            if (!$flight) {
                return response()->json(['message' => 'Flight tidak ditemukan'], 404);
            }

            $validator = Validator::make($request->all(), [
                'airline_name' => 'required|string|max:150',
                'departure_city' => 'required|string|max:200',
                'departure_code' => 'required|string|max:20',
                'arrival_city' => 'required|string|max:200',
                'arrival_code' => 'required|string|max:20',
                'departure_time' => 'required|date_format:H:i',
                'arrival_time' => 'required|date_format:H:i',
                'duration' => 'required|string|max:50',
                'transit_info' => 'nullable|string|max:100',
                'price_display' => 'required|string|max:50',
                'price_int' => 'required|integer|min:0',
                'flight_class' => 'required|string|max:100',
                'date' => 'required|date'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $flight->update($request->all());

            return response()->json([
                'message' => 'Flight berhasil diperbarui',
                'data' => $flight
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal memperbarui flight: ' . $e->getMessage()
            ], 500);
        }
    }

    public function delete($id) {
        try {
            $flight = Flight::find($id);
            if (!$flight) {
                return response()->json(['message' => 'Flight tidak ditemukan'], 404);
            }

            $flight->delete();
            return response()->json(['message' => 'Flight berhasil dihapus']);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menghapus flight: ' . $e->getMessage()
            ], 500);
        }
    }
}
