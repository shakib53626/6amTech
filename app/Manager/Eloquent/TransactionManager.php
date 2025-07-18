<?php

namespace App\Manager\Eloquent;

use App\Models\Product;
use App\Models\Transaction;
use App\Manager\TransactionManagerInterface;
use DB;

class TransactionManager implements TransactionManagerInterface
{
    public function index($request)
    {
        $paginateSize = $request->input('paginate_size') ?? 50;

        $query = Transaction::with('product');

        if ($request->filled('search')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->input('search') . '%');
            });
        }

        $transactions = $query->orderBy('transaction_date', 'desc')->paginate($paginateSize);

        return [
            'transactions' => $transactions,
            'products'     => Product::all(),
        ];
    }

    public function store($request)
    {
        $transaction = new Transaction();

        $transaction->product_id       = $request->product_id;
        $transaction->type             = $request->type;
        $transaction->quantity         = $request->quantity;
        $transaction->description      = $request->description ?? null;
        $transaction->transaction_date = $request->transaction_date ?? now();

        $transaction->save();

        // Update Product Stock
        $product = Product::findOrFail($request->product_id);

        if ($transaction->type === 'In') {
            $product->stock += $transaction->quantity;
        } elseif ($transaction->type === 'Out') {
            $product->stock -= $transaction->quantity;

            if ($product->stock < 0) {
                $product->stock = 0;
            }
        }

        $product->save();


        return $transaction;
    }

    public function update($id, $request)
    {
        return DB::transaction(function () use ($id, $request) {
            $transaction = Transaction::findOrFail($id);
            $product     = Product::findOrFail($transaction->product_id);

            if ($transaction->type === 'In') {
                $product->stock -= $transaction->quantity;
            } elseif ($transaction->type === 'Out') {
                $product->stock += $transaction->quantity;
            }

            $product->save();

            $transaction->product_id       = $request->product_id;
            $transaction->type             = $request->type;
            $transaction->quantity         = $request->quantity;
            $transaction->description      = $request->description ?? $transaction->description;
            $transaction->transaction_date = $request->transaction_date ?? $transaction->transaction_date;
            $transaction->save();

            $newProduct = Product::findOrFail($request->product_id);

            if ($transaction->type === 'In') {
                $newProduct->stock += $transaction->quantity;
            } elseif ($transaction->type === 'Out') {
                if ($newProduct->stock < $transaction->quantity) {
                    throw new \Exception('Not enough stock available.');
                }
                $newProduct->stock -= $transaction->quantity;
            }

            $newProduct->save();

            return $transaction;
        });
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $product     = Product::findOrFail($transaction->product_id);

        if ($transaction->type === 'In') {
            $product->stock -= $transaction->quantity;
        } elseif ($transaction->type === 'Out') {
            $product->stock += $transaction->quantity;
        }

        $product->save();

        $transaction->delete();

        return $transaction;
    }
}
