@props([
    'schedules' => [],
])

<div class="table-responsive">
    <table class="table table-borderless border-top ">
        <thead class="border-bottom">
            <tr>
                <th>Day</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Status</th>


            </tr>
        </thead>
        <tbody>
            @forelse ($schedules as $schedule)
                <tr>
                    <td>{{ ucfirst($schedule->day) }}</td>
                    <td>{{ $schedule->start_time }}</td>
                    <td>{{ $schedule->end_time }}</td>
                    <td>
                        @if ($schedule->is_active == 1)
                            <span class="badge bg-label-success">Active</span>
                        @else
                            <span class="badge bg-label-danger">Inactive</span>
                        @endif
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No schedules</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
