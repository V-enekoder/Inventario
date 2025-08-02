<?php

namespace App\Http\Controllers;

use App\Contracts\CategoryRepositoryInterface;
use App\Http\Requests\CategoryFormRequest;
use App\Http\Resources\CategoryResource;
use Exception;
use Illuminate\Http\{JsonResponse, Response};
use Illuminate\Support\Facades\{DB};

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index(): JsonResponse
    {

        try {
            $categories = $this->categoryRepository->getCategories();

            if ($categories->isEmpty()) {
                return response()->json([
                    'Error' => 'No categories found',
                ], response::HTTP_NOT_FOUND);
            };

            return response()->json([
                'categories' => CategoryResource::collection($categories),
            ], response::HTTP_OK);
        } catch (Exception $exception) {
            return response()->json(['Message' => 'An unexpect error ocurred ' . $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $category = $this->categoryRepository->getCategoryById($id);

            if (!$category) {
                return response()->json(Response::HTTP_NOT_FOUND);
            };

            return response()->json([
                'Category' => new CategoryResource($category),
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response()->json(['Message' => 'An unexpect error ocurred ' . $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(CategoryFormRequest $request): JsonResponse
    {

        DB::beginTransaction();

        try {

            $validated = $request->validated();

            $category = $this->categoryRepository->createCategory($validated);

            DB::commit();

            return response()->json([
                'Category' => new CategoryResource($category),
            ], Response::HTTP_CREATED);
        } catch (Exception $exception) {

            DB::rollBack();

            return response()->json(['Message' => 'An unexpect error ocurred ' . $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(CategoryFormRequest $request, $id): JsonResponse
    {

        DB::beginTransaction();

        try {
            $validated = $request->validated();

            $category = $this->categoryRepository->getCategoryById($id);

            if (!$category) {
                return response()->json([
                    'Error' => 'Category not found',
                ], Response::HTTP_NOT_FOUND);
            }

            $this->categoryRepository->updateCategory($category, $validated);

            DB::commit();

            return response()->json([
                'Category' => new CategoryResource($category),
            ], Response::HTTP_OK);
        } catch (Exception $exception) {

            DB::rollBack();

            return response()->json(['Message' => 'An unexpect error ocurred ' . $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $category = $this->categoryRepository->getCategoryById($id);

            if (!$category) {
                return response()->json([
                    'Error' => 'Category not found',
                ], Response::HTTP_NOT_FOUND);
            }

            $this->categoryRepository->deleteCategory($category);

            return response()->json([
                'Message' => 'Category deleted successfully.',
            ], Response::HTTP_OK);
        } catch (Exception $exception) {
            return response()->json(['Message' => 'An unexpect error ocurred ' . $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
