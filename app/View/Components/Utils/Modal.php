<?php

namespace App\View\Components\Utils;

use Illuminate\View\Component;

class Modal extends Component
{
  /**
   * Create a new component instance.
   *
   * @return void
   */
  public $id;
  public $footer;
  public $title;
  public $class;
  public $parentClass;

  public function __construct(
    $id,
    $footer = false,
    $title = '',
    $class = 'modal-dialog-centered modal-lg',
    $parentClass = 'fade text-start',
  ) {
    $this->id = $id;
    $this->footer = $footer;
    $this->title = $title;
    $this->class = $class;
    $this->parentClass = $parentClass;
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render()
  {
    return view('components.utils.modal');
  }
}
