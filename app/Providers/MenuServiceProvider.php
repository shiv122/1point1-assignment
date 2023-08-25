<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap services.
   */
  public function boot(): void
  {
    $adminMenuJson = file_get_contents(base_path('resources/menu/admin-menu.json'));
    $adminMenuData = json_decode($adminMenuJson);

    $salesMenuJson = file_get_contents(base_path('resources/menu/sales-menu.json'));
    $salesMenuData = json_decode($salesMenuJson);


    // Share all menuData to all the views
    \View::share('menuData', [
      'admin' => $adminMenuData,
      'sales' => $salesMenuData,
    ]);
  }
}
