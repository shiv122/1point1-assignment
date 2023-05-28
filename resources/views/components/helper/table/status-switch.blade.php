@props([
    'id' => null,
    'status' => null,
    'text' => null,
    'changeFunction' => 'changeStatus',
])


<label class="switch switch-outline-success">
    <input type="checkbox" class="switch-input" id="lw-status-switch-{{ $id }}"
        wire:change="{{ $changeFunction }}('{{ $id }}',$event.target.checked)"
        @if ($status) checked @endif>
    <span class="switch-toggle-slider">
        <span class="switch-on">
            <i class="ti ti-check"></i>
        </span>
        <span class="switch-off">
            <i class="ti ti-x"></i>
        </span>
    </span>
    @if ($text)
        <span class="switch-label">{{ $text }}</span>
    @endif
</label>
