<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionCreateRequest;
use App\Models\Category;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::with('category')
                            ->whereThisMonth()
                            ->orderBy('id', 'DESC')
                            ->get();

        return inertia('Transaction/Index', compact('transactions'));
    }

    public function filter(Request $request)
    {
        $request->validate([
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date'
        ]);

        $starts_at = $request->starts_at ? $request->starts_at : verta()->startMonth()->formatGregorian('Y-n-j H:i:s');
        $ends_at = $request->ends_at ? $request->ends_at : Carbon::now();

        $transactions = Transaction::with('category')->whereDate('created_at', '>=', $starts_at)
                    ->whereDate('created_at', '<=', $ends_at)
                    ->orderBy('id', 'DESC')
                    ->get();

        return response()->json($transactions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::get();

        return inertia('Transaction/Create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionCreateRequest $request)
    {
        Transaction::create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
