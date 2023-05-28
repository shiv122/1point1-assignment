<?php

namespace App\View\Components\Utils;

use Illuminate\View\Component;

class Offcanvas extends Component
{
  /**
   * Create a new component instance.
   *
   * @return void
   */
  public $id;
  public $title;
  public $class;
  public $position;
  public function __construct(
    $id,
    $class = '',
    $title = 'Offcanvas',
    $position = 'end'
  ) {
    $this->id = $id;
    $this->title = $title;
    if (!in_array($position, ['start', 'end', 'top', 'bottom'])) {
      throw new \Exception('Position must be : start, end, top, bottom');
    }
    $this->class = $class;
    $this->position = $position;
  }


  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render()
  {
    return view('components.utils.offcanvas');
  }
}
