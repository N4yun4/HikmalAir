<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index() {
        return view('admin.index');
    }

    // API list admin
    public function list() {
        try {
            $admins = Admin::all();
            return response()->json($admins);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal mengambil data admin'], 500);
        }
    }

    // API tambnah admin
    public function store(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'usr_admin' => 'required|string|unique:admins,usr_admin|max:255',
                'pass_admin' => 'required|string|min:6',
                'notlp_admin' => 'nullable|string|max:20',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $admin = new Admin();
            $admin->usr_admin = $request->usr_admin;
            $admin->pass_admin = bcrypt($request->pass_admin);
            $admin->notlp_admin = $request->notlp_admin;
            $admin->save();

            return response()->json([
                'message' => 'Admin berhasil ditambahkan',
                'data' => $admin
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menambahkan admin: ' . $e->getMessage()
            ], 500);
        }
    }

    // API admin update
    public function update(Request $request, $id) {
        try {
            $admin = Admin::find($id);
            if (!$admin) {
                return response()->json(['message' => 'Admin tidak ditemukan'], 404);
            }

            $validator = Validator::make($request->all(), [
                'usr_admin' => 'required|string|unique:admins,usr_admin,' . $id . '|max:255',
                'pass_admin' => 'nullable|string|min:6',
                'notlp_admin' => 'nullable|string|max:20',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $admin->usr_admin = $request->usr_admin;
            if ($request->pass_admin) {
                $admin->pass_admin = bcrypt($request->pass_admin);
            }
            $admin->notlp_admin = $request->notlp_admin;
            $admin->save();

            return response()->json([
                'message' => 'Admin berhasil diperbarui',
                'data' => $admin
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal memperbarui admin: ' . $e->getMessage()
            ], 500);
        }
    }

    // API hapus admin
    public function delete($id) {
        try {
            $admin = Admin::find($id);
            if (!$admin) {
                return response()->json(['message' => 'Admin tidak ditemukan'], 404);
            }

            $admin->delete();
            return response()->json(['message' => 'Admin berhasil dihapus']);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menghapus admin: ' . $e->getMessage()
            ], 500);
        }
    }
}
