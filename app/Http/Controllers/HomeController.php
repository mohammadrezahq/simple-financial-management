<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $timestamp = verta()->startMonth()->timestamp;

        $transactions = Transaction::with('category:id,name')
                            ->where('created_at', '>=', $timestamp)
                            ->get();

        return inertia('Home', ['transactions' => $transactions]);
    }
}
