<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expense;
use App\User;
use Aws\S3\S3Client;
use Illuminate\Support\Facades\Storage;
use DB;
use Validator;

class ExpenseController extends Controller
{
    public function index()
    {
        $users=User::where('status',1)->get();
        $expenses = Expense::join('users', 'users.id', '=', 'expense.user_id')->get();
        foreach($expenses as &$item) {
            if(!empty($item->file))
            $item->file = Storage::disk('s3')->temporaryUrl($item->file, now()->addMinutes(30));
        }
        return view('expenses.index', compact('expenses','users'));
    }

    public function create()
    {
        return view('expenses.create');
    }

    public function store(Request $request)
    {
        $roleData = [
            'user' => 'required|integer',
            'expense_date' => 'required|date',
            'expense_title' => 'required|string|max:255',
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'paid_to' => 'required|string|max:255',
            'reference' => 'required|string|max:255',
            'file' => 'nullable|file|max:10240', // Maximum file size 10MB, adjust as needed
        ];

        $validator = Validator::make($request->all(), $roleData);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $expense = new Expense();
        $expense->user_id = $request->user;
        $expense->expense_date = $request->expense_date;
        $expense->expense_title = $request->expense_title;
        $expense->description = $request->description;
        $expense->amount = $request->amount;
        $expense->paid_to = $request->paid_to;
        $expense->reference = $request->reference;

        if ($request->hasFile('file')) {
            // Store the file in the storage and set the file path in the expense
            $file = $request->file('file');
            $path = $file->store('expenses', 's3'); // Adjust 'expenses' as needed
            $expense->file = $path;
        }

        $expense->save();

        return redirect()->route('expenses.index')->with('success', 'Expense added successfully.');
    }
}
