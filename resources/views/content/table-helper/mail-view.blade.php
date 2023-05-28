<div class="card shadow-none border-0 rounded-0 app-email-view-header p-3 py-md-3 py-2">
    <!-- Email View : Title  bar-->
    <div class="d-flex justify-content-between align-items-center py-2">
        <div class="d-flex align-items-center overflow-hidden">
            <i onclick="$('#app-email-view').removeClass('show')" class="ti ti-chevron-left ti-sm cursor-pointer me-2"
                data-bs-toggle="sidebar" data-target="#app-email-view"></i>
            <h6 class="text-truncate mb-0 me-2">{{ $mail['mail_subject'] }}</h6>

        </div>
        <!-- Email View : Action  bar-->
        <div class="d-flex align-items-center">
            <i class='ti ti-printer mt-1 cursor-pointer d-sm-block d-none'></i>
            <div class="dropdown ms-3">
                <button class="btn p-0" type="button" id="dropdownMoreOptions" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="ti ti-dots-vertical"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMoreOptions">
                    <a class="dropdown-item" href="javascript:void(0)">
                        <i class="ti ti-mail ti-xs me-1"></i>
                        <span class="align-middle">Mark as unread</span>
                    </a>
                    <a class="dropdown-item" href="javascript:void(0)">
                        <i class="ti ti-mail-opened ti-xs me-1"></i>
                        <span class="align-middle">Mark as unread</span>
                    </a>
                    <a class="dropdown-item" href="javascript:void(0)">
                        <i class="ti ti-star ti-xs me-1"></i>
                        <span class="align-middle">Add star</span>
                    </a>
                    <a class="dropdown-item" href="javascript:void(0)">
                        <i class="ti ti-calendar ti-xs me-1"></i>
                        <span class="align-middle">Create Event</span>
                    </a>
                    <a class="dropdown-item" href="javascript:void(0)">
                        <i class="ti ti-volume-off ti-xs me-1"></i>
                        <span class="align-middle">Mute</span>
                    </a>
                    <a class="dropdown-item d-sm-none d-block" href="javascript:void(0)">
                        <i class="ti ti-printer ti-xs me-1"></i>
                        <span class="align-middle">Print</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <hr class="app-email-view-hr mx-n3 mb-2">
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <i class='ti ti-trash cursor-pointer me-3' data-bs-toggle="sidebar" data-target="#app-email-view"></i>
            <i class='ti ti-mail-opened cursor-pointer me-3'></i>
            <div class="dropdown me-3">
                <button class="btn p-0" type="button" id="dropdownMenuFolderTwo" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="ti ti-folder"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuFolderTwo">
                    <a class="dropdown-item" href="javascript:void(0)">
                        <i class="ti ti-info-circle ti-xs me-1"></i>
                        <span class="align-middle">Spam</span>
                    </a>
                    <a class="dropdown-item" href="javascript:void(0)">
                        <i class="ti ti-pencil ti-xs me-1"></i>
                        <span class="align-middle">Draft</span>
                    </a>
                    <a class="dropdown-item" href="javascript:void(0)">
                        <i class="ti ti-trash ti-xs me-1"></i>
                        <span class="align-middle">Trash</span>
                    </a>
                </div>
            </div>
            <div class="dropdown me-3">
                <button class="btn p-0" type="button" id="dropdownLabelTwo" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="ti ti-tag"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownLabelTwo">
                    <a class="dropdown-item" href="javascript:void(0)">
                        <i class="badge badge-dot bg-success me-1"></i>
                        <span class="align-middle">Workshop</span>
                    </a>
                    <a class="dropdown-item" href="javascript:void(0)">
                        <i class="badge badge-dot bg-primary me-1"></i>
                        <span class="align-middle">Company</span>
                    </a>
                    <a class="dropdown-item" href="javascript:void(0)">
                        <i class="badge badge-dot bg-info me-1"></i>
                        <span class="align-middle">Important</span>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
<hr class="m-0">
<!-- Email View : Content-->
<div class="app-email-view-content py-4">

    <!-- Email View : Last mail-->
    <div class="card email-card-last mx-sm-4 mx-3 mt-4">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
            <div class="d-flex align-items-center mb-sm-0 mb-3">
                <img src="{{ asset('assets/img/avatars/1.png') }}" alt="user-avatar"
                    class="flex-shrink-0 rounded-circle me-3" height="40" width="40" />
                <div class="flex-grow-1 ms-1">
                    <small class="text-muted">{{ $mail['mail_sender'] }}</small>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <p class="mb-0 me-3 text-muted">{{ $mail['mail_date'] }}</p>
                <button style="all:unset;border:none;cursor:pointer" data-mail-reply="{{ $mail['mail_id'] }}"> <i
                        class="ti ti-corner-up-left me-1"></i></button>

            </div>
        </div>
        <div class="card-body">
            {!! $mail['body'] !!}
        </div>
    </div>
    <div class="email-reply card mt-4 mx-sm-4 mx-3">
        <h6 class="card-header border-0">Reply to {{ $mail['mail_sender'] }}</h6>
        <div class="card-body pt-0 px-3">

            <form id="reply-to-mail">
                <div class="email-reply-editor">
                    <input type="hidden" name="mail_id" value="{{ $mail['mail_id'] }}">
                    <x-utils.form.input name="message" type="textarea" labelClass="d-none" />
                </div>
                <div class="d-flex justify-content-end align-items-center">
                    <button class="btn btn-primary">
                        <i class="ti ti-send ti-xs me-1"></i>
                        <span class="align-middle">Send</span>
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>
</div>
<!-- Email View -->
