<?php

namespace App\Http\Controllers;

use App\Models\Family;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:families',
        ]);

        Family::create([
            'name' => $validated['name'],
        ]);

        return redirect()->back()->with('success', 'با موفقیت خانواده جدید ایجاد شد');
    }
}
