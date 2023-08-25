<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
  public function index()
  {
    $total_users = User::isUser()->count();
    return view('content.pages.admin.index', compact('total_users'));
  }
}
