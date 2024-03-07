<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = auth()->user()->transactions;
        return response()->json($transactions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $data = $request->validate([
                'title' => 'required|string|min:3',
                'description' => 'nullable|string|max:255',
                'type' => 'required|string|in:gasto,ingreso',
                'amount' => 'required|numeric',
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid data'], 400);
        }

        try {
            $transaction = Transaction::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'type' => $data['type'],
                'amount' => $data['amount'],
                'user_id' => auth()->id(),
            ]);
            return response()->json($transaction, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not create transaction'], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaction = Transaction::findOrFail($id);
        return response()->json($transaction, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $data = $request->validate([
                'title' => 'required|string|min:3',
                'description' => 'nullable|string|max:255',
                'type' => 'required|string|in:gasto,ingreso',
                'amount' => 'required|numeric',
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid data'], 400);
        }

        try {
            $transaction->update([
                'title' => $data['title'],
                'description' => $data['description'],
                'type' => $data['type'],
                'amount' => $data['amount'],
            ]);
            return response()->json($transaction, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not update transaction'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $transaction->delete();
            return response()->json(['message' => 'Transaction deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not delete transaction'], 400);
        }
    }
}
