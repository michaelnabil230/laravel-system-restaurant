<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\{
    Category,
    Driver,
    Order,
    Product,
    User,
};
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GlobalSearchController extends Controller
{
    private $models = [
        User::class => 'users',
        Category::class => 'users',
        Driver::class => 'drivers',
        Order::class => 'orders',
        Product::class => 'products',
    ];

    public function __invoke(Request $request)
    {
        $search = $request->input('search');

        abort_if($search === null || ! isset($search['term']), 400);

        $term = $search['term'];
        $searchableData = [];
        foreach ($this->models as $model => $translation) {
            $query = $model::query();
            $fields = $model::$searchable;

            foreach ($fields as $field) {
                $query->orWhere($field, 'LIKE', '%' . $term . '%');
            }

            $results = $query
                ->take(10)
                ->get();

            foreach ($results as $result) {
                $parsedData = $result->only($fields);
                $parsedData['model'] = trans($translation);
                $parsedData['fields'] = $fields;
                $formattedFields = [];
                foreach ($fields as $field) {
                    $formattedFields[$field] = Str::title(str_replace('_', ' ', $field));
                }
                $parsedData['fields_formated'] = $formattedFields;


                $nameModelPlural = Str::plural(Str::snake(Str::replaceFirst('App\Models\\', '', $model), '-'));

                $parsedData['url'] = route('dashboard.' . $nameModelPlural . '.edit', $result->id);

                $searchableData[] = $parsedData;
            }
        }

        return response()->json(['results' => $searchableData]);
    }
}
