<ul class="list-unstyled m-0">
    @forelse($inboxMessage as $key => $mail)
        <li class="email-list-item" data-starred="true"
            data-mail-route="{{ route('admin.mails.details', $mail['mail_id']) }}">

            <div class="d-flex align-items-center">
                <div class="form-check mb-0">
                    <input class="email-list-item-input form-check-input" type="checkbox" id="email-1">
                    <label class="form-check-label" for="email-1"></label>
                </div>
                <i
                    class="email-list-item-bookmark ti ti-star ti-xs d-sm-inline-block d-none cursor-pointer ms-2 me-3"></i>
                {{-- <img src="{{ asset('assets/img/avatars/1.png') }}" alt="user-avatar"
                  class="d-block flex-shrink-0 rounded-circle me-sm-3 me-2" height="32"
                  width="32" /> --}}
                <div class="email-list-item-content ms-2 ms-sm-0 me-2">
                    <span class="h6 email-list-item-username me-2">{{ $mail['mail_sender'] }}</span>
                    <span class="email-list-item-subject d-xl-inline-block d-block">

                        {{ $mail['mail_subject'] }}
                    </span>
                </div>
                <div class="email-list-item-meta ms-auto d-flex align-items-center">
                    <span class="email-list-item-label badge badge-dot bg-danger d-none d-md-inline-block me-2"
                        data-label="private"></span>
                    <small
                        class="email-list-item-time text-muted">{{ \Carbon\Carbon::parse($mail['mail_date'])->format('H:i A') }}</small>
                    <ul class="list-inline email-list-item-actions text-nowrap">
                        <li class="list-inline-item email-read"> <i class='ti ti-mail-opened'></i>
                        </li>
                        <li class="list-inline-item email-delete"> <i class='ti ti-trash'></i>
                        </li>
                        <li class="list-inline-item"> <i class="ti ti-archive"></i> </li>
                    </ul>
                </div>
            </div>
        </li>

    @empty
    @endforelse
</ul>
