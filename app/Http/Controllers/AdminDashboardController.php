<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(){
        $customerCount = User::count();
        $revenue = Transaction::sum('total_price');
        $transaction = Transaction::count();
        return view('pages.admin.dashboard', compact('customerCount', 'revenue', 'transaction'));
    }
}
