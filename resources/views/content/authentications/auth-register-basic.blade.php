@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Register Basic - Pages')

@section('vendor-style')
    <!-- Vendor -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />
@endsection

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />

@endsection



@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">

                <!-- Register Card -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-4 mt-2">
                            <a href="{{ url('/') }}" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">@include('_partials.macros', ['height' => 20, 'withbg' => 'fill: #fff;'])</span>
                                <span
                                    class="app-brand-text demo text-body fw-bold ms-1">{{ config('variables.templateName') }}</span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-1 pt-2">Adventure starts here 🚀</h4>
                        <p class="mb-4">Make your app management easy and fun!</p>

                        <form id="register-form" class="mb-3">
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
                            <div class="mb-3 form-password-toggle">
                                <x-utils.form.input name="password" type="password" />
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms">
                                    <label class="form-check-label" for="terms-conditions">
                                        I agree to
                                        <a href="javascript:void(0);">privacy policy & terms</a>
                                    </label>
                                </div>
                            </div>
                            <button class="btn btn-primary d-grid w-100">
                                Sign up
                            </button>
                        </form>

                        <p class="text-center">
                            <span>Already have an account?</span>
                            <a href="{{ route('auth.login.index') }}">
                                <span>Sign in instead</span>
                            </a>
                        </p>


                    </div>
                </div>
                <!-- Register Card -->
            </div>
        </div>
    </div>
@endsection




@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>

    <script>
        $('#dob').flatpickr({
            maxDate: new Date().fp_incr(-18 * 365),
        });
        $('#register-form').submit(async function(e) {
            e.preventDefault();
            const response = await rebound({
                    form: $(this),
                    route: "{{ route('auth.register.store') }}",
                    returnData: true
                })
                .catch(error => {
                    console.log(error);
                });
            console.log(response);
        });
    </script>
@endsection
