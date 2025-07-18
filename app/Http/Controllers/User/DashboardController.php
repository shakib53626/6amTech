<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Task;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index (){
        try {
            $userId = Auth::id();

            $recentTask = Task::with('user')->where('user_id', $userId)->paginate(10);

            $monthlyCompletedTasks = DB::table('tasks')
                ->select(
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('COUNT(*) as total')
                )
                ->where('user_id', $userId)
                ->where('completed', 'Complete')
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('total', 'month');

            $monthlyData = [];
            for ($i = 1; $i <= 12; $i++) {
                $monthlyData[] = $monthlyCompletedTasks->get($i, 0);
            }


            $totalTasks = DB::table('tasks')
                ->where('user_id', $userId)
                ->count();

            $completedTasks = DB::table('tasks')
                ->where('user_id', $userId)
                ->where('completed', 'Complete')
                ->count();

            $incompleteTasks = DB::table('tasks')
                ->where('user_id', $userId)
                ->where('completed', 'Incomplete')
                ->count();

            return inertia('Frontend/Dashboard', [
                'reports' => [
                    'total'      => $totalTasks,
                    'completed'  => $completedTasks,
                    'incomplete' => $incompleteTasks,
                    'monthlyData'=> $monthlyData,
                    'recentTask' => $recentTask,
                ],
            ]);
        } catch (\Exception $exception) {
            return handleException('Dashboard data fetch failed', $exception);
        }
    }
}
