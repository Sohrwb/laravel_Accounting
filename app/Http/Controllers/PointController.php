<?php

namespace App\Http\Controllers;

use App\Models\Point;
use Illuminate\Http\Request;

class PointController extends Controller
{
    public function index()
    {
        $points = Point::with('user')->get();
        return view('points.index', compact('points'));
    }

    public function edit($id)
    {
        $point = Point::findOrFail($id);
        return view('points.edit', compact('point'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'amount' => 'required|numeric',
        ]);

        $point = Point::findOrFail($id);
        $point->update($data);

        return redirect()->route('points.index');
    }
}
