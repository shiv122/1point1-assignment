<div class="offcanvas {{ $class }} offcanvas-{{ $position }}" tabindex="-1" id="{{ $id }}"
  aria-labelledby="{{ $id }}Label">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="{{ $id }}Label">{{ $title }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body px-3 py-0 ">
    {{ $slot }}
  </div>
</div>
