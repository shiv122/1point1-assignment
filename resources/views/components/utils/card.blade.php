<div id="{{ $id }}" class="card mb-4 {{ $class }}">
    <div class="card-body {{ $bodyClass }}">

        @if (isset($cardTitle))
            <h5 class="card-title">
                {{ $cardTitle }}
            </h5>
        @endif

        {{ $slot }}

    </div>
</div>
