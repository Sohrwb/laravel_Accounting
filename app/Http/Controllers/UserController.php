<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\Investment;
use App\Models\Point;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{

    public function profile()
    {
        $user = Auth::user();

        $userId = $user->id;
        $familyId = $user->family_id;

        /** @var \App\Models\User $user */
        $user->load([
            'investments',
            'point',
            'loans.loanPayments',
        ]);

        $loan = null;
        $payments = null;

        if ($user->loans->first()) {
            $loan = $user->loans->first();

            $payments = $loan->loanPayments()
                ->whereMonth('due_date', Carbon::now()->month)
                ->whereYear('due_date', Carbon::now()->year)
                ->get();
        }


        $familyMembers = User::where('family_id', $familyId)
            ->with('point')
            ->get();

        $point = Point::where('user_id', $userId)->first();
      
        return view('users.profile', compact('loan', 'user', 'familyMembers', 'payments', 'point'));
    }

    public function index()
    {
        $users = User::with('family')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $families = Family::all();
        return view('users.create', compact('families'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'family_id' => 'required|exists:families,id',
            'amount' => 'required|numeric|min:10000',
            'point' => 'required|numeric|min:1000',
        ]);

        // ساخت کاربر
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'family_id' => $validated['family_id'],
            'total_investment' => $validated['amount'],
        ]);

        // ایجاد امتیاز برای کاربر
        $user->point()->create([
            'points' => $validated['point'],
        ]);

        return redirect()->route('admin.users.index')->with('success', 'کاربر با موفقیت ایجاد شد.');
    }




    public function edit(User $user)
    {
        $families = Family::all();
        return view('users.edit', compact('user', 'families'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'family_id' => 'required|exists:families,id',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? Hash::make($validated['password']) : $user->password,
            'family_id' => $validated['family_id'],
        ]);

        return redirect()->route('admin.users.index')->with('success', 'اطلاعات کاربر ویرایش شد');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'کاربر حذف شد');
    }


    public function show(User $user)
    {
        $user->load(['investments', 'loans', 'transactions', 'point']);
        return view('users.show', compact('user'));
    }
}
