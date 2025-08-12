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
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            Workspace::create([
                'name' => $request->name,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Workspace created successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to create workspace.');
        }
    }

    public function delete(Request $request, Workspace $workspace)
    {
        try {
            DB::beginTransaction();

            $workspace->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Workspace deleted successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to delete workspace.');
        }
    }
}
