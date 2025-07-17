<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Manager\CategoryManagerInterface;

class CategoryController extends Controller
{
    protected $manager;

    public function __construct(CategoryManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function index(Request $request)
    {
        try {
            $data = $this->manager->index($request);

            return inertia("Adminend/Categories", [
                "categories" => $data['categories'],
                'filters'    => $request->only(['search', 'paginate_size', 'page' => request('page')]),
            ]);
        } catch (\Exception $exception) {
            return handleException('Category fetch failed', $exception);
        }
    }

    public function store(CategoryRequest $request)
    {
        try {
            $category = $this->manager->store($request);

            return redirect()->back()->with('success', 'Category created successfully');
        } catch (\Exception $exception) {
            return handleException('Category creation failed', $exception);
        }
    }

    public function update(CategoryRequest $request, $id)
    {
        try {
            $category = $this->manager->update($id, $request);

            return redirect()->back()->with('success', 'Category updated successfully');
        } catch (\Exception $exception) {
            return handleException('Category update failed', $exception);
        }
    }

    public function destroy($id)
    {
        try {
            $category = $this->manager->destroy($id);

            return redirect()->back()->with('success', 'Category deleted successfully');
        } catch (\Exception $exception) {
            return handleException('Category deletion failed', $exception);
        }
    }
}
