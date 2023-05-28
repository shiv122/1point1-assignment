<div class="form-group mb-2  has-feedback {{ $class }}">
    <label class="{{ $labelClass }}">{{ $label ?? ucwords(str_replace('_', ' ', $name)) }}</label>
    <div class="  @if ($icon) ls-inputicon-box @endif ">
        <select class=" w-100 selectpicker" data-style="btn-default" @if ($multiple) multiple @endif
            data-live-search="{{ $search }}" title=""
            @if ($multiple) name="{{ $name }}[]" @else name="{{ $name }}" @endif
            id="{{ $id ?? $name }}" @if ($required) required @endif
            @if ($disabled) disabled @endif
            @if ($showTill) data-selected-text-format="count > {{ $showTill }}" @endif
            @if ($maxSelect) data-max-options="{{ $maxSelect }}" @endif
            @if (!empty($attrs)) @forelse ($attrs as $atr) {{ $atr[0] }}="{{ $atr[1] }}" @empty @endforelse @endif
            data-bv-field="size">

            @if (!$multiple)
                <option disabled selected>Select {{ ucwords(str_replace('_', ' ', $name)) }}</option>
            @endif

            @forelse ($options as $option)
                <option value="{{ $option[$valueName] ?? $option }}"
                    @if ($subtext) data-subtext="{{ $option[$subtext] ?? $subtext }}" @endif>
                    @if ($optionPrepend)
                        {!! $option[$optionPrepend] ?? $optionPrepend !!}
                    @endif
                    {{ $option[$optionName] ?? ucwords($option) }}
                </option>
            @empty
                <option disabled selected value="">No options available</option>
            @endforelse


        </select>
        @if ($icon)
            {!! $icon !!}
        @endif
    </div>
    @if ($maxSelect)
        <small class="text-muted">*You can select maximum {{ $maxSelect }} options</small>
    @endif

</div>


@once
    @push('component-script')
        <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    @endpush

    @push('component-style')
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    @endpush
@endonce


@push('component-scripts')
    @if ($selected)
        <script>
            $(document).ready(function() {
                $('#{{ $id ?? $name }}').selectpicker('val', @json($selected));
            });
        </script>
    @endif
@endpush
