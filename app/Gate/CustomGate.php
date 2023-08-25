<?php

namespace App\Gate;

use App\Interfaces\GateInterface;


class CustomGate implements GateInterface
{
  function __construct(public string $role, public array $list = [])
  {
    $this->list = require_once(base_path('app/Gate/allowedList.php'));
  }

  public function allowed(): array
  {
    return $this->list[$this->role]['allow'];
  }

  public function denied(): array
  {
    return $this->list[$this->role]['deny'];
  }
}
