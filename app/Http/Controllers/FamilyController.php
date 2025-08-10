<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\User;
use Illuminate\Http\Request;

class FamilyController extends Controller
{

    //----------------/ ADMIN /-------------------------[  ذخیره خانواده جدید  ]-----------------------------------------------

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

    //-----------------------------------------[  نمایش فرم خانواده من  ]-----------------------------------------------

    public function show(User $user)
    {
        $users = User::where('family_id', $user->family_id)->get();

        return view('family.show', compact('users'));
    }
}
