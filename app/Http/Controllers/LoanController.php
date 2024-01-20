<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Loan;
use Inertia\Inertia;
use App\Models\LoanBill;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loans  = Loan::with('user')->where('user_id', auth()->user()->id)->get();
        // $auth   = auth()->user();
        // dd($auth);

        return Inertia::render('Loan/Index', [
            'loans' => $loans
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Loan/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|max:255',
            'loan_term' => 'required'
        ]);
        $store_loan = Loan::create([
            'user_id'       => auth()->user()->id,
            'amount' => $request->amount,
            'loan_term' => $request->loan_term
        ]);
        
        if($store_loan){
            $total_amount = (int)$request->amount / (int)$store_loan->loan_term;
            // dd();
            $currentDate = Carbon::parse($store_loan->created_at);
            $numberOfFridays = $store_loan->loan_term;
            $fridays = [];

            for ($i = 1; $i < $numberOfFridays; $i++) {
                $currentDate = $currentDate->addDays(7);
                $currentDate->toDateString();
                $fridays[] = LoanBill::create([
                    'loan_id'   =>$store_loan->id,
                    'due_at'    => $currentDate->toDateString(),
                    'amount'    => $total_amount
                ]);
            }
        
        }
        sleep(1);

        return redirect()->route('loan.index')->with('message', 'Loans Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $loan = Loan::with('user')->find($id);
        $bills = LoanBill::where('loan_id', $id)->get();
        // dd($bills);
        return Inertia::render(
            'Loan/Read',
            [
                'loan' => $loan,
                'bills' => $bills
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
    
    public function approval(Request $request, string $id)
    {
        $loan = Loan::find($id);
        if($loan){
            $loan->status = 'APPROVED';
            $loan->save();
        }
        
        return redirect()->route('loan.index')->with('message', 'Loans Approved Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
