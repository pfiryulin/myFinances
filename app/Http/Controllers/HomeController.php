<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Operation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index() : array
    {
        //todo разделить по типам операций расход, доход, депозит

        $operations = Operation::query()
                               ->select([
                                   'category_id',
                                   'type_id',
                                   DB::raw("to_char(created_at, 'YYYY-MM') as month"),
                                   DB::raw('SUM(amount) as total'),
                               ])
                               ->groupBy('type_id','category_id', 'month')

            ->with(['category', 'type'])
                               ->where('user_id', auth()->id())


                               ->get();

        $months = $operations->pluck('month')->unique();

        $table = $operations->groupBy('category_id')->map(function ($items) use ($months) {
            $row = [];

            foreach ($months as $month) {
                $row[$month] = $items
                    ->firstWhere('month', $month)
                    ->total ?? 0;
            }

            return [
                'category' => $items->first()->category->name,
                'amounts' => $row,
            ];
        });
        return ['operations' => $operations, 'months' => $months, 'table' => $table];
    }

    protected function separeteForTyprs()
    {
        dd(123);
    }
}
