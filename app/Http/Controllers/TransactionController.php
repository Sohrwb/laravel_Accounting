<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class TransactionController extends Controller
{
    //-----------------------------------------[  تبدیل اعداد فارسی به انگلیسی  ]-----------------------------------------------

    private function convertFaNumToEn($string)
    {
        $faNums = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $enNums = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        return str_replace($faNums, $enNums, $string);
    }

    //------------------/ ADMIN /-----------------------[  ایجاد تراکنش جدید  ]-----------------------------------------------

    public function create()
    {
        $users = User::all();
        return view('transactions.create', compact('users'));
    }

    //-------------------/ ADMIN /----------------------[  ذخیره تراکنش  ]-----------------------------------------------

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric',
            'type' => 'required|in:investment,loan_payment',
            'date' => 'required|date'
        ]);

        Transaction::create($data);

        return redirect()->route('transactions.index');
    }

    //------------------/ ADMIN /--------------[  نمایش فرم تراکنشات  ]-----------------------------------------------

    public function index(Request $request)
    {
        $query = Transaction::query()->with('user');

        $userName = trim($request->input('user_name', ''));
        if ($userName !== '') {
            $query->whereHas('user', function ($q) use ($userName) {
                $q->where('name', 'like', "%{$userName}%");
            });
        }

        if ($request->filled('filter_type')) {
            $query->where('type', $request->input('filter_type'));
        }

        $yearInput = $request->input('year');
        $monthInput = $request->input('month');

        $year = $yearInput ? (int)$this->convertFaNumToEn($yearInput) : null;
        $month = $monthInput ? (int)$this->convertFaNumToEn($monthInput) : null;

        try {
            if ($year && $month) {
                $startDate = Jalalian::fromFormat('Y-m-d', "{$year}-{$month}-01")->toCarbon()->startOfDay();
                $endDate = (clone $startDate)->endOfMonth()->endOfDay();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            } elseif ($year) {
                $startDate = Jalalian::fromFormat('Y-m-d', "{$year}-01-01")->toCarbon()->startOfDay();
                $endDate = (clone $startDate)->endOfYear()->endOfDay();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            } elseif ($month) {
                $currentYear = Jalalian::now()->getYear();
                $startDate = Jalalian::fromFormat('Y-m-d', "{$currentYear}-{$month}-01")->toCarbon()->startOfDay();
                $endDate = (clone $startDate)->endOfMonth()->endOfDay();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        } catch (\Exception $e) {

        }

        switch ($request->input('sort')) {
            case 'date_asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'amount_desc':
                $query->orderBy('amount', 'desc');
                break;
            case 'amount_asc':
                $query->orderBy('amount', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $transactions = $query->paginate(15)->appends($request->all());

        return view('transactions.index', compact('transactions'));
    }

    //-----------------------------------------[  نمایش تراکنشات کاربر  ]-----------------------------------------------

    public function show(Request $request, User $user)
    {

        $query = Transaction::query();
        $query->where('user_id', $user->id);

        if ($filter = $request->input('filter_type')) {
            $query->where('type', $filter);
        }

        switch ($request->input('sort')) {
            case 'date_asc':
                $query->orderBy('date', 'asc');
                break;
            case 'date_desc':
                $query->orderBy('date', 'desc');
                break;
            case 'amount_desc':
                $query->orderBy('amount', 'desc');
                break;
            case 'amount_asc':
                $query->orderBy('amount', 'asc');
                break;
            default:
                $query->orderBy('date', 'desc');
        }
        $transactions = $query->get();

        return view('transactions.show', compact('transactions'));
    }
}
