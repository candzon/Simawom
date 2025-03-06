<?php

namespace App\Http\Controllers;

use App\Models\Workorder;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {

        // Dashboard by role operator accounts
        if (auth()->user()->role == 'operator') {
            $countWorkOrdersByPending = Workorder::countWorkOrderByStatusAssigned('pending', auth()->id());
            $countWorkOrdersByProgress = Workorder::countWorkOrderByStatusAssigned('in_progress', auth()->id());
            $countWorkOrdersByCompleted = Workorder::countWorkOrderByStatusAssigned('completed', auth()->id());
            $countWorkOrdersByCanceled = Workorder::countWorkOrderByStatusAssigned('canceled', auth()->id());

            return view('dashboard', compact(
                'countWorkOrdersByPending',
                'countWorkOrdersByProgress',
                'countWorkOrdersByCompleted',
                'countWorkOrdersByCanceled'
            ));
        }

        $countWorkOrdersByPending = Workorder::countWorkOrderByStatus('pending');
        $countWorkOrdersByProgress = Workorder::countWorkOrderByStatus('in_progress');
        $countWorkOrdersByCompleted = Workorder::countWorkOrderByStatus('completed');
        $countWorkOrdersByCanceled = Workorder::countWorkOrderByStatus('canceled');

        return view('dashboard', compact(
            'countWorkOrdersByPending',
            'countWorkOrdersByProgress',
            'countWorkOrdersByCompleted',
            'countWorkOrdersByCanceled'
        ));
    }
}