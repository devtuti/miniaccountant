<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddExpensesRequest;
use App\Http\Requests\UpdatedExtensesRequest;
use App\Models\Expenses;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    public function index(){
        $expenses = Expenses::with('parent')->where('user_id', auth()->user()->id)->get();
        return view('web.expenses.index', compact('expenses'));
    }

    public function data(){
        $search = request('search');
        $expenses = Expenses::with('childs')
                            ->where('user_id', auth()->user()->id);

        if (!empty($search)) {       
            $expenses = $expenses->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });         
        }

        return response()->json([
            'data' => $expenses,
            'req' => request()->all(),
            'table' => view('web.expenses.data', ['expenses'=>$expenses->get()])->render()
        ]);
    }

    public function add(AddExpensesRequest $request){
        //dd($request->all()); die;
        $data = [
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'user_id' => auth()->user()->id,
            'created_at' => now()
        ];
        $res = Expenses::create($data);
       
        return response()->json([
            'message' => $res ? 'Expenses inserted' : 'Error',
            'data' => (bool)$res
        ]);
    }

    public function show($id){
        $res = Expenses::find($id);
        $expenses = Expenses::with('parent')->where('user_id', auth()->user()->id)->get();
        return response()->json([
            'edit' => $res,
            'data' => view('web.expenses.edit', compact('expenses'))->render()
        ]);
    }

    public function update(UpdatedExtensesRequest $request){
        $res = Expenses::where('id',$request->id)->update($request->all());
        //dd($request->all());
        return response()->json([
            'message' => $res ? 'Expenses update' : 'Error',
            'data' => (bool)$res
        ]);
    }

    public function all_delete(){
        
        $ids = request('tIds');
        foreach($ids as $tid){
            $all = Expenses::where('id', $tid)->delete();
        }
        
        return response()->json([
            'message'=>'Expenses deleted'
        ]);
    }

    public function delete(){
        $expense = Expenses::where('id', request('id'))->first();
        if($expense->childs()->count() == 0){
            $expense->childs()->delete();
            $expense->delete();
        }
        return response()->json([
            'message'=>'Expense deleted'
        ]);
    }
}
