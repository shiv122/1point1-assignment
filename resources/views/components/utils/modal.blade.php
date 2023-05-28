<div class="modal {{ $parentClass }}" id="{{ $id }}" tabindex="-1" aria-labelledby="m-label-{{ $id }}"
    aria-hidden="true">
    <div class="modal-dialog {{ $class }}">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="m-label-{{ $id }}">
                    {{ $title }}
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
            @if ($footer)
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Accept</button>
                </div>
            @endif
        </div>
    </div>
</div>
