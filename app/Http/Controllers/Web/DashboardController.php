<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AmountSpent;
use App\Models\CardTransfers;
use App\Models\Income;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        /*$income = Income::totalmonth()->get();
        $payment = AmountSpent::totalmonth()->get();
        $totalmonth = $income - $payment;*/
        /*$income = Income::where('user_id',auth()->user()->id)->first();
        $payment = AmountSpent::where('user_id',auth()->user()->id)->first();
        $totalmonth = $income - $payment;*/
        $income = Income::where('user_id', auth()->user()->id)
                                ->where('created_at', 'datetime:m')
                                ->where('exchange',1)
                                ->sum('amount');
        $payment= AmountSpent::where('user_id', auth()->user()->id)
                                ->where('created_at', 'datetime:m')
                                ->where('exchange',1)
                                ->sum('amount');
        $cardtransfer= CardTransfers::where('user_id', auth()->user()->id)
                                ->where('created_at', 'datetime:m')
                                ->where('exchange',1)
                                ->sum('amount');                        
        $totalmonth = $income - $payment - $cardtransfer;


        $income_usd = Income::where('user_id', auth()->user()->id)
                                ->where('created_at', 'datetime:m')
                                ->where('exchange',2)
                                ->sum('amount');
        $payment_usd= AmountSpent::where('user_id', auth()->user()->id)
                                ->where('created_at', 'datetime:m')
                                ->where('exchange',2)
                                ->sum('amount');
        $cardtransfer_usd= CardTransfers::where('user_id', auth()->user()->id)
                                ->where('created_at', 'datetime:m')
                                ->where('exchange',2)
                                ->sum('amount');                        
        $totalmonth_usd = $income_usd - $payment_usd - $cardtransfer_usd;


        $income_eur = Income::where('user_id', auth()->user()->id)
                                ->where('created_at', 'datetime:m')
                                ->where('exchange',3)
                                ->sum('amount');
        $payment_eur= AmountSpent::where('user_id', auth()->user()->id)
                                ->where('created_at', 'datetime:m')
                                ->where('exchange',3)
                                ->sum('amount');
        $cardtransfer_eur= CardTransfers::where('user_id', auth()->user()->id)
                                ->where('created_at', 'datetime:m')
                                ->where('exchange',3)
                                ->sum('amount');                        
        $totalmonth_eur = $income_eur - $payment_eur - $cardtransfer_eur;

        $income_azn = Income::where('user_id', auth()->user()->id)
                                ->where('created_at', 'datetime:m')
                                ->where('exchange',4)
                                ->sum('amount');
        $payment_azn= AmountSpent::where('user_id', auth()->user()->id)
                                ->where('created_at', 'datetime:m')
                                ->where('exchange',4)
                                ->sum('amount');
        $cardtransfer_azn= CardTransfers::where('user_id', auth()->user()->id)
                                ->where('created_at', 'datetime:m')
                                ->where('exchange',4)
                                ->sum('amount');                        
        $totalmonth_azn = $income_azn - $payment_azn - $cardtransfer_azn;
    
        $date = date('F', strtotime(now())). ' - '.now()->format('Y');
        
        return view('web.dashboard.index', compact('totalmonth', 'totalmonth_usd', 'totalmonth_eur', 'totalmonth_azn', 'date'));
    }

    public function data(){
        $first_date = request('first_search');
        $last_date = request('last_search');
         //return request('first_search')." ".request('last_search');
         $expenses = AmountSpent::with('expenses')->where('user_id', auth()->user()->id);
         $transitions = Income::with('transition')->where('user_id', auth()->user()->id);

         if (!empty($first_date) and !empty($last_date)) {
            $expenses = $expenses->where(function ($q) use ($first_date, $last_date) {
                $q->whereBetween('created_at', [$first_date, $last_date]);
            });

            $transitions = $transitions->where(function ($q) use ($first_date, $last_date) {
                $q->whereBetween('created_at', [$first_date, $last_date]);
            });
        }else{
            //echo 'no result';
        }

        return response()->json([
            'data' => [$expenses, $transitions],
            'table' => view('web.dashboard.table_expenses', ['expenses' => $expenses->get()])->render(),
            'table_t' => view('web.dashboard.table_transitions', ['transitions' => $transitions->get()])->render(),
            'req' => request()->all()
        ]);
    }
}
