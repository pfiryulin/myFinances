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
        $operations = Operation::query()
                               ->select([
                                   'category_id',
                                   DB::raw("to_char(created_at, 'YYYY-MM') as month"),
                                   DB::raw('SUM(amount) as total'),
                               ])
                               ->where('user_id', auth()->id())
                               ->groupBy('category_id', 'month')
                               ->with('category')
                               ->get();

        $mounth = $operations->pluck('month')->unique();
        return ['operations' => $operations, 'mounth' => $mounth];
    }
}
