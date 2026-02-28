<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OperationReportController extends Controller
{
    public function index(Request $request)
    {
//        $report = Operation::where('user_id', auth()->user()->id)
//            ->whereYear('created_at', ($request->year) ?? date('Y'))
//                           ->with(['type','category'])
//            ->groupBy('type_id', 'category_id')
//            ->get();
        $userId = auth()->user()->id;
        $year = 2026;
        $result = DB::select("
    WITH monthly AS (
        SELECT
            o.type_id,
            t.name AS type_name,
            o.category_id,
            c.name AS category_name,
            EXTRACT(MONTH FROM o.created_at)::int AS month,
            SUM(o.amount) AS month_total
        FROM operations o
        JOIN types t ON t.id = o.type_id
        JOIN categories c ON c.id = o.category_id
        WHERE o.user_id = :user_id
          AND EXTRACT(YEAR FROM o.created_at) = :year
        GROUP BY o.type_id, t.name, o.category_id, c.name, month
    ),
    categories AS (
        SELECT
            type_id,
            type_name,
            category_id,
            category_name,
            jsonb_object_agg(month, month_total) AS months
        FROM monthly
        GROUP BY type_id, type_name, category_id, category_name
    )
    SELECT
        type_id,
        type_name,
        jsonb_object_agg(
            category_id,
            jsonb_build_object(
                'name', category_name,
                'months', months
            )
        ) AS categories
    FROM categories
    GROUP BY type_id, type_name
    ORDER BY type_id
", [
            'user_id' => $userId,
            'year' => $year,
        ]);
dump($result);
        return $result;
    }
}
