<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workorder extends Model
{
    //
    protected $fillable = [
        'wo_number',
        'product_name',
        'quantity',
        'status',
        'deadline',
        'assigned',
        'description',
        'progress_at',
        'completed_at',
        'canceled_at',
        'created_at'
    ];

    protected $dates = [
        'deadline',
        'progress_at',
        'completed_at',
        'canceled_at',
        'created_at'
    ];

    public static function lastWorkOrder()
    {
        return static::whereDate('created_at', today())->latest()->first();
    }

    public static function getWorkOrders()
    {
        return static::join('users', 'workorders.assigned', '=', 'users.id')
            ->select('workorders.*', 'users.name as assigned_name')
            ->orderBy('workorders.created_at', 'desc')
            ->get();
    }

    public static function getWorkOrderByOperator($assigned)
    {
        return static::join('users', 'workorders.assigned', '=', 'users.id')
            ->select('workorders.*', 'users.name as assigned_name')
            ->where('assigned', $assigned)
            ->orderBy('workorders.created_at', 'desc')
            ->get();
    }

    public static function getWorkOrderByStatus($status, $assigned)
    {
        return static::join('users', 'workorders.assigned', '=', 'users.id')
            ->select('workorders.*', 'users.name as assigned_name')
            ->where('status', $status)
            ->where('assigned', $assigned)
            ->orderBy('workorders.created_at', 'desc')
            ->get();
    }

    public static function countWorkOrderByStatus($status)
    {
        return static::where('status', $status)->count();
    }

    public static function countWorkOrderByStatusAssigned($status, $assigned)
    {
        return static::where('status', $status)
            ->where('assigned', $assigned)
            ->count();
    }

}
