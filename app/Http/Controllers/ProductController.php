<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Manager\ProductManagerInterface;

class ProductController extends Controller
{
    protected $manager;

    public function __construct(ProductManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function index(Request $request)
    {
        try {
            $data = $this->manager->index($request);

            return inertia('Adminend/Products', [
                'products'   => $data['products'],
                'categories' => $data['categories'],
                'filters'    => $request->only(['search', 'paginate_size', 'page' => request('page')]),
            ]);
        } catch (\Exception $exception) {
            return handleException('Product fetch failed', $exception);
        }
    }

    public function store(ProductRequest $request)
    {
        try {
            $product = $this->manager->store($request);

            return redirect()->back()->with('success', 'Product created successfully');
        } catch (\Exception $exception) {
            return handleException('Product creation failed', $exception);
        }
    }

    public function update(ProductRequest $request, $id)
    {
        try {
            $product = $this->manager->update($id, $request);

            return redirect()->back()->with('success', 'Product updated successfully');
        } catch (\Exception $exception) {
            return handleException('Product update failed', $exception);
        }
    }

    public function destroy($id)
    {
        try {
            $product = $this->manager->destroy($id);

            return redirect()->back()->with('success', 'Product deleted successfully');
        } catch (\Exception $exception) {
            return handleException('Product deletion failed', $exception);
        }
    }
}
