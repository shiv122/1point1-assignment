<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
  public function index()
  {
    $total_employees = User::isEmployee()->count();
    $total_admins = User::isAdmin()->count();
    return view('content.pages.admin.index', compact('total_employees', 'total_admins'));
  }
}
