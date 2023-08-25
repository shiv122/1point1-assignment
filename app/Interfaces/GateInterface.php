<?php

namespace App\Interfaces;

interface GateInterface
{
  /**
   * Get the list of allowed routes.
   *
   * @return array
   */
  public function allowed(): array;

  /**
   * Get the list of denied routes.
   *
   * @return array
   */
  public function denied(): array;
}
