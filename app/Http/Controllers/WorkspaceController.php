<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WorkspaceController extends Controller
{
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            Workspace::create([
                'name' => $request->name,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Workspace created successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
}
