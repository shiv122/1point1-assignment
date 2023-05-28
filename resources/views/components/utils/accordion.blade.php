<div class="accordion {{ $class }}" id="{{ $id }}">
    @foreach ($items as $item)
        <div class="card accordion-item">
            <h2 class="accordion-header" id="acc-{{ $item }}">
                <button class="accordion-button @if ($open !== $item) collapsed @endif" type="button"
                    data-bs-toggle="collapse" data-bs-target="#acrd-{{ $item }}"
                    aria-expanded="{{ $open === $item ? 'true' : 'false' }}" aria-controls="acrd-{{ $item }}">
                    {{ ucfirst(str_replace(['_', '-'], ' ', $item)) }}
                </button>
            </h2>
            <div id="acrd-{{ $item }}"
                class="accordion-collapse collapse @if ($open === $item) show @endif"
                aria-labelledby="acc-{{ $item }}" data-bs-parent="#{{ $id }}">
                <div class="accordion-body">
                    {{ $$item ?? 'No content for ' . ucfirst(str_replace(['_', '-'], ' ', $item)) }}
                </div>
            </div>
        </div>
    @endforeach
</div>

\
