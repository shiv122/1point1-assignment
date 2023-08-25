@extends('layouts/layoutMaster')

@section('title', 'Home')

@section('content')
    <x-utils.card>
        <div class="row mb-4">
            <div class="col-md-12 text-end">
                <button type="button" class="btn btn-label-success waves-effect" data-bs-toggle="offcanvas"
                    data-bs-target="#add-user-modal">Add</button>
            </div>
        </div>
        <livewire:tables.user-table />
    </x-utils.card>


    <x-utils.offcanvas id="add-user-modal" title="Add user">
        <form id="add-user-form">
            <div class="mb-3">
                <x-utils.form.input name="first_name" />
            </div>
            <div class="mb-3">
                <x-utils.form.input name="last_name" />
            </div>
            <div class="mb-3">
                <x-utils.form.input name="email" type="email" />
            </div>

            <div class="mb-3 form-password-toggle">
                <x-utils.form.input name="password" type="password" />
            </div>
            <div class="mb-3 form-password-toggle">
                <x-utils.form.input label="Confirm Password" placeholder="Re-enter password" name="password_confirmation"
                    type="password" />
            </div>

            <div class="mb-3">
                <x-utils.form.select name="role" :options="['user', 'admin', 'sales']" selected="user" />
            </div>
            <div class="mt-4  text-center">
                <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </div>
        </form>
    </x-utils.offcanvas>


    <x-utils.offcanvas id="edit-user-modal" title="Edit user">
        <form id="edit-user-form">
            <div class="mb-3">
                <x-utils.form.input name="first_name" />
                <input type="hidden" name="id" id="id">
            </div>
            <div class="mb-3">
                <x-utils.form.input name="last_name" />
            </div>
            <div class="mb-3">
                <x-utils.form.input name="email" type="email" />
            </div>


            <div class="mb-3 form-password-toggle">
                <x-utils.form.input name="password" type="password" label="Password (leave empty if dont want to change)"
                    :required="false" />
            </div>

            <div class="mb-3">
                <x-utils.form.select name="role" id="edit_role" :options="['user', 'admin', 'sales']" />
            </div>
            <div class="mt-4  text-center">
                <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </div>
        </form>
    </x-utils.offcanvas>



@endsection
@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('page-script')


    <script>
        $('#dob').flatpickr({
            maxDate: new Date().fp_incr(-18 * 365),
        });
        $('#add-user-form').submit(async function(e) {
            e.preventDefault();
            const response = await rebound({
                    form: $(this),
                    route: "{{ route('admin.users.store') }}",
                    returnData: true
                })
                .catch(error => {
                    console.log(error);
                });

            if (response) {
                $('#add-user-modal').offcanvas('hide');
            }
        });

        $('#edit-user-form').submit(async function(e) {
            e.preventDefault();
            const response = await rebound({
                    form: $(this),
                    route: "{{ route('admin.users.update') }}",
                    returnData: true
                })
                .catch(error => {
                    console.log(error);
                });
            if (response) {
                $('#edit-user-modal').offcanvas('hide');
            }
        });


        const assets = "{{ asset('') }}";

        function setVal(data, modal) {
            $(modal + ' #id').val(data.id);
            $(modal + ' #first_name').val(data.first_name);
            $(modal + ' #last_name').val(data.last_name);
            $(modal + ' #email').val(data.email);
            $('#edit_role').selectpicker('val', data.role)

            $(modal).offcanvas('show');
        }


        $(document).on('click', '[data-delete]', async function(e) {
            e.preventDefault();

            const route = $(this).data('delete');


            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                customClass: {
                    confirmButton: 'btn btn-danger me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            }).then(async function(result) {
                if (result.value) {
                    const res = await rebound({
                        data: '',
                        method: 'delete',
                        route: route,
                        notification: false,
                    }).catch(error => {
                        console.log(error);
                    });

                    if (res.statusCode === 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'user has been deleted.',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    }

                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire({
                        title: 'Cancelled',
                        text: 'Deletion Cancelled',
                        icon: 'error',
                        customClass: {
                            confirmButton: 'btn btn-success'
                        }
                    });
                }
            });


        });
    </script>
@endsection
