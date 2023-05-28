@extends('layouts/layoutMaster')

@section('title', 'Email - Apps')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/katex.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-email.css') }}" />
@endsection



@section('content')
    <div class="app-email card">
        <div class="row g-0">
            <!-- Email Sidebar -->
            <div class="col app-email-sidebar border-end flex-grow-0" id="app-email-sidebar">
                <div class="btn-compost-wrapper d-grid">
                    <button class="btn btn-primary btn-compose" data-bs-toggle="modal" data-bs-target="#emailComposeSidebar"
                        id="emailComposeSidebarLabel">Compose</button>
                </div>
                <!-- Email Filters -->
                <div class="email-filters py-2">
                    <!-- Email Filters: Folder -->
                    <ul class="email-filter-folders list-unstyled mb-4">
                        <li class="active d-flex justify-content-between" data-target="inbox">
                            <a href="javascript:void(0);" class="d-flex flex-wrap align-items-center">
                                <i class="ti ti-mail"></i>
                                <span class="align-middle ms-2">Inbox</span>
                            </a>
                        </li>
                        {{-- <li class="d-flex" data-target="sent">
                            <a href="javascript:void(0);" class="d-flex flex-wrap align-items-center">
                                <i class="ti ti-send ti-xs"></i>
                                <span class="align-middle ms-2">Sent</span>
                            </a>
                        </li> --}}

                    </ul>

                </div>
            </div>
            <!--/ Email Sidebar -->

            <!-- Emails List -->
            <div class="col app-emails-list">
                <div class="shadow-none border-0">
                    <div class="emails-list-header p-3 py-lg-3 py-2">
                        <!-- Email List: Search -->
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center w-100">
                                <i class="ti ti-menu-2 ti-sm cursor-pointer d-block d-lg-none me-3" data-bs-toggle="sidebar"
                                    data-target="#app-email-sidebar" data-overlay></i>
                                <div class="mb-0 mb-lg-2 w-100">
                                    <div class="input-group input-group-merge shadow-none">
                                        <span class="input-group-text border-0 ps-0" id="email-search">
                                            <i class="ti ti-search"></i>
                                        </span>
                                        <input type="text" class="form-control email-search-input border-0"
                                            placeholder="Search mail" aria-label="Search mail"
                                            aria-describedby="email-search">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <hr class="mx-n3 emails-list-header-hr">
                        <!-- Email List: Actions -->
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="form-check mb-0 me-2">
                                    <input class="form-check-input" type="checkbox" id="email-select-all">
                                    <label class="form-check-label" for="email-select-all"></label>
                                </div>
                                <i class="ti ti-trash email-list-delete cursor-pointer me-2"></i>
                                <i class="ti ti-mail-opened email-list-read cursor-pointer me-2"></i>
                                <div class="dropdown me-2">
                                    <button class="btn p-0" type="button" id="dropdownMenuFolderOne"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ti ti-folder"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuFolderOne">
                                        <a class="dropdown-item" href="javascript:void(0)">
                                            <i class="ti ti-info-circle ti-xs me-1"></i>
                                            <span class="align-middle">Spam</span>
                                        </a>
                                        <a class="dropdown-item" href="javascript:void(0)">
                                            <i class="ti ti-file ti-xs me-1"></i>
                                            <span class="align-middle">Draft</span>
                                        </a>
                                        <a class="dropdown-item" href="javascript:void(0)">
                                            <i class="ti ti-trash ti-xs me-1"></i>
                                            <span class="align-middle">Trash</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="dropdownLabelOne" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="ti ti-tag"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownLabelOne">
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
                                        <a class="dropdown-item" href="javascript:void(0)">
                                            <i class="badge badge-dot bg-danger me-1"></i>
                                            <span class="align-middle">Private</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="container-m-nx m-0">
                    <!-- Email List: Items -->
                    <div class="email-list pt-0">
                        <ul class="list-unstyled m-0">
                            @forelse($inboxMessage as $key => $mail)
                                <li class="email-list-item" data-starred="true"
                                    data-mail-route="{{ route('employee.mails.details', $mail['mail_id']) }}">
                                    <div hidden class="d-none" data-body-details>
                                        {!! $mail['body'] !!}
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="form-check mb-0">
                                            <input class="email-list-item-input form-check-input" type="checkbox"
                                                id="email-1">
                                            <label class="form-check-label" for="email-1"></label>
                                        </div>
                                        <i
                                            class="email-list-item-bookmark ti ti-star ti-xs d-sm-inline-block d-none cursor-pointer ms-2 me-3"></i>
                                        {{-- <img src="{{ asset('assets/img/avatars/1.png') }}" alt="user-avatar"
                                            class="d-block flex-shrink-0 rounded-circle me-sm-3 me-2" height="32"
                                            width="32" /> --}}
                                        <div class="email-list-item-content ms-2 ms-sm-0 me-2">
                                            <span
                                                class="h6 email-list-item-username me-2">{{ $mail['mail_sender'] }}</span>
                                            <span class="email-list-item-subject d-xl-inline-block d-block">

                                                {{ $mail['mail_subject'] }}
                                            </span>
                                        </div>
                                        <div class="email-list-item-meta ms-auto d-flex align-items-center">
                                            <span
                                                class="email-list-item-label badge badge-dot bg-danger d-none d-md-inline-block me-2"
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
                    </div>
                </div>
                <div class="app-overlay"></div>
            </div>
            <!-- /Emails List -->

            <!-- Email View -->
            <div class="col app-email-view flex-grow-0 bg-body" id="app-email-view">

            </div>
            <!-- Email View -->
        </div>

        <!-- Compose Email -->
        <div class="app-email-compose modal" id="emailComposeSidebar" tabindex="-1"
            aria-labelledby="emailComposeSidebarLabel" aria-hidden="true">
            <div class="modal-dialog m-0 me-md-4 mb-4 modal-lg">
                <div class="modal-content p-0">
                    <div class="modal-header py-3 bg-body">
                        <h5 class="modal-title fs-5">Compose Mail</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 p-4 py-2">
                        <form id="send-mail-form" class="email-compose-form">
                            <div class="email-compose-to d-flex justify-content-between align-items-center">
                                <label class="form-label mb-0" for="send_to">To:</label>
                                <div class="select2-primary border-0 shadow-none flex-grow-1 mx-2">
                                    <input style="border:none;box-shadow:none !important" type="email"
                                        class="form-control" name="send_to" id="send_to">
                                </div>
                            </div>

                            <div class="email-compose-cc d-none">
                                <hr class="container-m-nx my-2">
                                <div class="d-flex align-items-center">
                                    <label for="email-cc" class="form-label mb-0">Cc: </label>
                                    <input type="text" class="form-control border-0 shadow-none flex-grow-1 mx-2"
                                        id="email-cc" placeholder="someone@email.com">
                                </div>
                            </div>
                            <div class="email-compose-bcc d-none">
                                <hr class="container-m-nx my-2">
                                <div class="d-flex align-items-center">
                                    <label for="email-bcc" class="form-label mb-0">Bcc: </label>
                                    <input type="text" class="form-control border-0 shadow-none flex-grow-1 mx-2"
                                        id="email-bcc" placeholder="someone@email.com">
                                </div>
                            </div>
                            <hr class="container-m-nx my-2">
                            <div class="email-compose-subject d-flex align-items-center mb-2">
                                <label for="email-subject" class="form-label mb-0">Subject:</label>
                                <input type="text" name="subject"
                                    class="form-control border-0 shadow-none flex-grow-1 mx-2" id="email-subject"
                                    placeholder="Project Details">
                            </div>
                            <div class="email-compose-message container-m-nx">
                                <div class="d-flex justify-content-end">
                                    <div class="email-editor-toolbar border-bottom-0 w-100">
                                        {{-- <span class="ql-formats me-0">
                                            <button class="ql-bold"></button>
                                            <button class="ql-italic"></button>
                                            <button class="ql-underline"></button>
                                            <button class="ql-list" value="ordered"></button>
                                            <button class="ql-list" value="bullet"></button>
                                            <button class="ql-link"></button>
                                            <button class="ql-image"></button>
                                        </span> --}}
                                    </div>
                                </div>
                                <div class="email-editor"></div>
                            </div>
                            <hr class="container-m-nx mt-0 mb-2">
                            <div class="email-compose-actions d-flex justify-content-between align-items-center mt-3 mb-3">
                                <div class="d-flex align-items-center">

                                    <button type="submit" class="btn btn-primary"><i
                                            class="ti ti-send ti-xs me-1"></i>Send</button>

                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Compose Email -->
    </div>
@endsection


@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/quill/katex.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/block-ui/block-ui.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/app-email.js') }}"></script>

    <script>
        let mail_body = new Quill('.email-editor', {
            modules: {
                toolbar: '.email-editor-toolbar'
            },
            placeholder: 'Write your message... ',
            theme: 'snow'
        });


        $(document).on('click', '[data-mail-route]', async function(e) {
            e.preventDefault();
            const route = $(this).data('mail-route')
            const res = await rebound({
                data: '',
                method: 'get',
                route: route,
                notification: false,
            }).catch(error => {
                console.log(error);
            });

            // console.log(res);
            if (res) {
                console.log(res.html);

                $('#app-email-view').html(res.html);
                const container = document.querySelector('.app-email-view-content');
                const ps = new PerfectScrollbar(container);
                $('#app-email-view').addClass('show');
            }

        });


        $(document).on('submit', '#reply-to-mail', async function(e) {
            e.preventDefault();
            const res = await rebound({
                form: $(this),
                route: "{{ route('employee.mails.reply') }}",
                reset: false,
            }).catch(error => {
                console.log(error);
            });

        });

        $('#send-mail-form').submit(async function(e) {
            e.preventDefault();
            const appendData = {
                body: $('.ql-editor').text()
            };
            const res = await rebound({
                form: $(this),
                route: "{{ route('employee.mails.send-mail') }}",
                appendData: appendData,
            }).catch(error => {
                console.log(error);
            });

            if (res) {
                $('.ql-editor').text('');
                $('.app-email-compose').modal('hide')
            }
        });

        $(document).ready(function() {
            setTimeout(() => {
                $("#emailContacts").select2({
                    tags: true
                });
            }, 1000);
        });
    </script>
@endsection
