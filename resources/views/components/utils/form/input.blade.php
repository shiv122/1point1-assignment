<div class="form-group {{ $class }} mb-2">
    @if ($type !== 'hidden')
        <label class="{{ $labelClass }}">{{ $label ?? ucwords(str_replace('_', ' ', $name)) }}</label>
    @endif
    <div class=" @if ($icon) ls-inputicon-box @endif ">

        @if ($type !== 'textarea')
            <input class="form-control @error('title') is-invalid @enderror "
                @if ($multiple) name="{{ $name }}[]"@else name="{{ $name }}" @endif
                type="{{ $type }}" @if ($value) value="{{ $value }}" @endif
                @if ($required) required @endif id="{{ $id ?? $name }}"
                @if ($disabled) disabled @endif
                @if (!empty($attrs)) @forelse ($attrs as $key=> $atr) {{ $key }}="{{ $atr }}" @empty @endforelse @endif
                placeholder="{{ $placeholder ?? ($label ?? ucwords(str_replace('_', ' ', $name))) }}" />
            @if ($icon)
                {!! $icon !!}
            @endif
        @else
            <textarea class="form-control @error('title') is-invalid @enderror h-auto"
                @if (!empty($attrs)) @forelse ($attrs as $atr) {{ $atr[0] }}="{{ $atr[1] }}" @empty @endforelse @endif
                @if ($required) required @endif
                @if ($multiple) name="{{ $name }}[]"@else name="{{ $name }}" @endif
                id="{{ $id ?? $name }}" placeholder="{{ $placeholder ?? ($label ?? ucwords(str_replace('_', ' ', $name))) }}"
                rows="3">{{ $value }}</textarea>

        @endif
        @error($name)
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>


@if ($type === 'date')
    @pushonce('component-scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
    @endpushonce

    @if ($type == 'date')
        @push('component-scripts')
            <script>
                $(function() {
                    flatpickr('#{{ $id ?? $name }}', {
                        dateFormat: 'Y-m-d',
                    });
                });
            </script>
        @endpush
    @endif
@endif

@if ($type === 'date')
    @pushonce('component-styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css">
        <style>

        </style>
    @endpushonce
@endif
