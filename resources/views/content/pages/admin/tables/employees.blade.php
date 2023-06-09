@extends('layouts/layoutMaster')

@section('title', 'Home')

@section('content')
    <x-utils.card>
        <div class="row mb-4">
            <div class="col-md-12 text-end">
                <button type="button" class="btn btn-label-info waves-effect" data-bs-toggle="offcanvas"
                    data-bs-target="#add-employee-bulk-modal">Bulk Add</button>
                <button type="button" class="btn btn-label-success waves-effect" data-bs-toggle="offcanvas"
                    data-bs-target="#add-employee-modal">Add</button>
            </div>
        </div>
        <livewire:tables.employee-table />
    </x-utils.card>


    <x-utils.offcanvas id="add-employee-modal" title="Add employee">
        <form id="add-employee-form">
            <div class="mb-3">
                <x-utils.form.input name="username" />
            </div>
            <div class="mb-3">
                <x-utils.form.input name="email" type="email" />
            </div>
            <div class="mb-3">
                <x-utils.form.input name="dob" label="Date of birth" />
            </div>
            <div class="mb-3">
                <x-utils.form.input name="image" type="file" />
            </div>
            <div class="mb-3">
                <x-utils.form.select name="gender" :options="['male', 'female', 'other']" />
            </div>
            <div class="mb-3">
                <x-utils.form.select name="is_manager" :options="['yes', 'no']" />
            </div>
            <div class="mb-3 form-password-toggle">
                <x-utils.form.input name="password" type="password" />
            </div>
            <div class="mt-4  text-center">
                <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </div>
        </form>
    </x-utils.offcanvas>

    <x-utils.offcanvas id="add-employee-bulk-modal" title="Add employee">
        <form id="add-employee-bulk-form">
            <div class="mb-3">
                <x-utils.form.input name="file" label="Add csv or excel" type="file" />
            </div>
            <div class="mt-4  text-center">
                <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </div>
        </form>
    </x-utils.offcanvas>

    <x-utils.offcanvas id="edit-employee-modal" title="edit employee">
        <form id="edit-employee-form">
            <div class="mb-3">
                <x-utils.form.input name="username" />
                <input type="hidden" name="id" id="id">
            </div>
            <div class="mb-3">
                <x-utils.form.input name="email" type="email" />
            </div>
            <div class="mb-3">
                <x-utils.form.input name="dob" id="edit_dob" label="Date of birth" />
            </div>
            <div class="mb-3">
                <div class="col-2 mt-3">
                    <div class="avatar avatar-lg">
                        <img data-view-image src="" alt="avatar">
                    </div>
                </div>
                <x-utils.form.input name="image" type="file" :required="false" />
            </div>
            <div class="mb-3">
                <x-utils.form.select name="gender" id="edit_gender" :options="['male', 'female', 'other']" />
            </div>
            <div class="mb-3">
                <x-utils.form.select name="is_manager" id="edit_is_manager" :options="['yes', 'no']" />
            </div>
            <div class="mb-3 form-password-toggle">
                <x-utils.form.input name="password" type="password" label="Password (leave empty if dont want to change)"
                    :required="false" />
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
        $('#add-employee-form').submit(async function(e) {
            e.preventDefault();
            const response = await rebound({
                    form: $(this),
                    route: "{{ route('admin.employees.store') }}",
                    returnData: true
                })
                .catch(error => {
                    console.log(error);
                });
            console.log(response);
        });
        $('#edit-employee-form').submit(async function(e) {
            e.preventDefault();
            const response = await rebound({
                    form: $(this),
                    route: "{{ route('admin.employees.update') }}",
                    returnData: true
                })
                .catch(error => {
                    console.log(error);
                });
            console.log(response);
        });
        $('#add-employee-bulk-form').submit(async function(e) {
            e.preventDefault();
            const response = await rebound({
                    form: $(this),
                    route: "{{ route('admin.employees.bulk-store') }}",
                    returnData: true
                })
                .catch(error => {
                    console.log(error);
                });
            console.log(response);
        });

        const assets = "{{ asset('') }}";

        function setVal(data, modal) {
            $(modal + ' #id').val(data.id);
            $(modal + ' #username').val(data.name);
            $(modal + ' #email').val(data.email);
            $('#edit_dob').flatpickr({
                defaultDate: data.dob,
                maxDate: new Date().fp_incr(-18 * 365),
            })
            $('#edit_gender').selectpicker('val', data.gender)
            $('#edit_is_manager').selectpicker('val', (data.is_manager) ? 'yes' : 'no')
            $(modal + ' [data-view-image]').attr('src', assets + '' + data.image);
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
                            text: 'Employee has been deleted.',
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
