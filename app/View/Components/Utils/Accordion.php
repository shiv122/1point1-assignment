<?php

namespace App\View\Components\Utils;

use Illuminate\View\Component;

class Accordion extends Component
{
  /**
   * Create a new component instance.
   *
   * @return void
   */

  public $class;
  public $id;
  public $items;
  public $open;


  public function __construct(
    array $items,
    string $class = ' mt-3',
    string $open = null,
    string $id = null,
  ) {

    if ($open && !in_array($open, $items)) {
      throw new \Exception('The open item must be in the items array');
    }
    foreach ($items as $item) {
      if (!is_string($item)) {
        throw new \Exception('The items must be strings in the items array');
      }
    }

    if ($id && !preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $id)) {
      throw new \Exception('The id must be in snake or kebab case');
    }


    $this->class = $class;
    $this->items = $items;
    $this->open = $open;
    $this->id = $id ?? 'accordion-' . uniqid();
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render()
  {
    return view('components.utils.accordion');
  }
}
