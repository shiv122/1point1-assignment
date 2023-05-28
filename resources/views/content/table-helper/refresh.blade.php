<button wire:click="refresh()" type="button" id="table-refresh"
    class="btn rounded-pill btn-icon btn-label-success waves-effect me-2">
    <svg aria-hidden="true" focusable="false" data-prefix="fa-light" data-icon="arrow-rotate-right" height="20px"
        class="svg-inline--fa fa-arrow-rotate-right fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 512 512">
        <path
            d="M255.9 32.11c79.47 0 151.8 41.76 192.1 109.4V48C448 39.16 455.2 32 464 32S480 39.16 480 48v128C480 184.8 472.8 192 464 192h-128C327.2 192 320 184.8 320 176S327.2 160 336 160h85.85C387.5 100.7 324.9 64 256 64C150.1 64 64 150.1 64 256s86.13 192 192 192c59.48 0 114.7-26.91 151.3-73.84c5.438-7 15.48-8.281 22.47-2.75c6.953 5.438 8.187 15.5 2.75 22.44c-42.8 54.75-107.3 86.05-176.7 86.05C132.4 479.9 32 379.5 32 256S132.4 32.11 255.9 32.11z"
            fill="currentColor" />
    </svg>
</button>

@include('content.table-helper.export')
