<?php

namespace App\Http\Middleware\Custom;

use Closure;
use App\Gate\CustomGate;
use Illuminate\Http\Request;
use App\Interfaces\GateInterface;
use Symfony\Component\HttpFoundation\Response;

class GateMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    $gate = new CustomGate($request->user()->role_route);
    if (!$this->shouldPass($request, $gate)) {
      abort(403);
    }

    return $next($request);
  }



  private function shouldPass(Request $request, CustomGate $gate): bool
  {
    if (!$gate instanceof GateInterface) {
      throw new \InvalidArgumentException('CustomGate must implement GateInterface.');
    }
    $route = $request->route()->getName();

    if (in_array($route, $gate->denied())) {
      return false;
    }

    $allowedRoutes = $gate->allowed();

    foreach ($allowedRoutes as $allowedRoute) {
      if (str_ends_with($allowedRoute, '.*')) {
        $routePrefix = rtrim($allowedRoute, '.*');
        if (str_starts_with($route, $routePrefix)) {
          return true;
        }
      } else {
        if ($route === $allowedRoute) {
          return true;
        }
      }
    }

    return false;
  }
}
