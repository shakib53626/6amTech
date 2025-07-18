<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TransactionRequest;
use App\Manager\TransactionManagerInterface;

class TransactionController extends Controller
{
    protected $manager;

    public function __construct(TransactionManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function index(Request $request)
    {
        try {
            $data = $this->manager->index($request);

            return inertia("Adminend/Transactions", [
                "transactions" => $data['transactions'],
                "products"     => $data['products'],
                'filters'      => $request->only(['search', 'paginate_size', 'page' => request('page')]),
            ]);
        } catch (\Exception $exception) {
            return handleException('Transaction fetch failed', $exception);
        }
    }

    public function store(TransactionRequest $request)
    {
        try {
            $transaction = $this->manager->store($request);

            return redirect()->back()->with('success', 'Transaction created successfully');
        } catch (\Exception $exception) {
            return handleException('Transaction creation failed', $exception);
        }
    }

    public function update(TransactionRequest $request, $id)
    {
        try {
            $transaction = $this->manager->update($id, $request);

            return redirect()->back()->with('success', 'Transaction updated successfully');
        } catch (\Exception $exception) {
            return handleException('Transaction update failed', $exception);
        }
    }

    public function destroy($id)
    {
        try {
            $transaction = $this->manager->destroy($id);

            return redirect()->back()->with('success', 'Transaction deleted successfully');
        } catch (\Exception $exception) {
            return handleException('Transaction deletion failed', $exception);
        }
    }
}
