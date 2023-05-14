<?php

namespace App\Http\Controllers;

use App\Models\NotifikasiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotifikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $notifikasi = $user ? $user->allNotifications : null;
        $totalnotifikasi = $user ? $user->unreadNotifications->count() : 0;

        return response()->json([
            'notifikasi' => $notifikasi,
            'totalnotifikasi' => $totalnotifikasi,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $notification = NotifikasiModel::find($id);
        if ($notification) {
            $notification->delete();
        }
        $notifications = NotifikasiModel::orderBy('created_at', 'desc')->whereNull('read_at')->get();
        return response()->json(['notifikasi' => $notifications]);
    }

    public function tandai_telah_dibaca(string $id)
    {
        $notifikasi = NotifikasiModel::find($id);
        if ($notifikasi) {
            $notifikasi->update([
                'read_at' => now(),
                'updated_at' => now()
            ]);
        }
        // $notifications = NotifikasiModel::orderBy('created_at', 'desc')->whereNull('read_at')->get();
        // return response()->json(['notifikasi' => $notifications]);
        $user = Auth::user();
        $notifikasi = $user ? $user->allNotifications : null;
        $totalnotifikasi = $user ? $user->unreadNotifications->count() : 0;

        return response()->json([
            'notifikasi' => $notifikasi,
            'totalnotifikasi' => $totalnotifikasi,
        ]);
    }

    public function tandai_semua_telah_dibaca()
    {
        $user_id = Auth::user()->id;
        DB::table('notifikasi')
            ->where('user_id', '=', $user_id)
            ->where('read_at', '=', null)
            ->update([
                'read_at' => now(),
                'updated_at' => now()
            ]);

        // $notifications = NotifikasiModel::orderBy('created_at', 'desc')->whereNull('read_at')->get();
        // return response()->json(['notifikasi' => $notifications]);
        $user = Auth::user();
        $notifikasi = $user ? $user->allNotifications : null;
        $totalnotifikasi = $user ? $user->unreadNotifications->count() : 0;

        return response()->json([
            'notifikasi' => $notifikasi,
            'totalnotifikasi' => $totalnotifikasi,
        ]);
    }
}
