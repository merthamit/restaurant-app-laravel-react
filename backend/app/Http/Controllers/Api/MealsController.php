<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MealStoreRequest;
use App\Http\Resources\MealResource;
use App\Models\Meal;

class MealsController extends Controller
{
    public function fetchMeals()
    {
        $meals = Meal::all();
        return MealResource::collection($meals);
    }

    public function store(MealStoreRequest $request)
    {
        $file = $request->file('file');
        $file_name = $this->saveImage($file);
        Meal::create([
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'file_path' => 'storage/user/images/' . $file_name,
        ]);

        return response()->json([
            'message' => 'Başarıyla yemek oluşturuldu.',
        ]);
    }
    public function delete($mealId)
    {
        $meal = Meal::where('id', $mealId)->first();

        if (!$meal) {
            return response()->json([
                'error' => 'Meal not found.',
            ], 404);
        }

        $meal->delete();

        return response()->json([
            'message' => 'The meal has been deleted.',
        ]);
    }

    public function update(MealStoreRequest $request, $mealId)
    {
        $meal = Meal::find($mealId);
        if (!$meal) {
            return response()->json([
                'error' => 'Yemek bulunamadı.',
            ], 404);
        }

        $file = $request->file('file');
        $meal->update([
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category_id,
        ]);

        if ($file) {
            $file_name = $this->saveImage($file);
            $meal->update([
                'file_path' => 'storage/user/images/' . $file_name,
            ]);
        }

        return response()->json([
            'message' => 'Başarıyla yemek güncellendi.',
        ]);
    }

    public function saveImage($file)
    {
        $file_name = time() . '_' . 'picture' . '_' . $file->getClientOriginalName();
        $file->storeAs('meal/images', $file_name, 'public');
        return $file_name;
    }
}
