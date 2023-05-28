@props([
    'services' => [],
])

<div class="table-responsive">
    <table class="table table-borderless border-top ">
        <thead class="border-bottom">
            <tr>
                <th>Service</th>
                <th>Price</th>
                <th>Duration</th>
                <th>Type</th>
                <th>Images</th>

            </tr>
        </thead>
        <tbody>
            @forelse ($services as $service)
                <tr>
                    <td>{{ $service->name }}</td>
                    <td>{{ $service->price }}</td>
                    <td>{{ $service->hours . ' Hours ' . $service->minutes . ' Minutes' }}</td>
                    <td>{{ $service->type }}</td>
                    <td>
                        <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                            @forelse ($service->images as $img)
                                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                    class="avatar avatar-xs pull-up" aria-label="{{ $service->name }}"
                                    data-bs-original-title="{{ $service->name }}">
                                    <img data-action-preview src="{{ asset($img->image) }}" alt="Avatar"
                                        class="rounded-circle">
                                </li>
                            @empty
                            @endforelse
                        </ul>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No Services</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
