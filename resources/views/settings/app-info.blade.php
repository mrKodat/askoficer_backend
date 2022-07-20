@extends('layouts.app', ['activePage' => 'app-info', 'titlePage' => __('app-info')])

@section('content')

<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="/app-info-save" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('App Information') }}</h4>
                        </div>

                        @foreach($settings as $setting)

                        <div class="card-body ">
                            @if (session('status'))
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="alert alert-success">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <i class="material-icons">close</i>
                                        </button>
                                        <span>{{ session('status') }}</span>
                                    </div>
                                </div>
                            </div>
                            @endif



                            <!-- <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('App Name') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('appName') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('appName') ? ' is-invalid' : '' }}" name="appName" id="input-appName" type="text" placeholder="{{ __('Site Name') }}" required="true" aria-required="true" />
                                        @if ($errors->has('appName'))
                                        <span id="title-error" class="error text-danger" for="input-appName">{{ $errors->first('appName') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('App Description') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('appDescription') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('appDescription') ? ' is-invalid' : '' }}" name="appDescription" id="input-appDescription" type="text" placeholder="{{ __('App Description') }}" required="true" aria-required="true" />
                                        @if ($errors->has('appDescription'))
                                        <span id="appDescription-error" class="error text-danger" for="input-appDescription">{{ $errors->first('appDescription') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div> -->

                            <br><br>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Privacy Policy') }}</label>
                                <div class="col-sm-8">
                                    <textarea name="privacy_policy" id="privacy_policy">{{ $setting->privacy_policy }}</textarea>
                                    <script>
                                        CKEDITOR.replace('privacy_policy');
                                    </script>
                                </div>
                            </div><br>


                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Terms & Conditions') }}</label>
                                <div class="col-sm-8">
                                    <textarea name="terms_and_conditions" id="terms_and_conditions">{{ $setting->terms_and_conditions }}</textarea>
                                    <script>
                                        CKEDITOR.replace('terms_and_conditions');
                                    </script>
                                </div>
                            </div><br>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('About Us') }}</label>
                                <div class="col-sm-8">
                                    <textarea name="about_us" id="about_us">{{ $setting->about_us }}</textarea>
                                    <script>
                                        CKEDITOR.replace('about_us');
                                    </script>
                                </div>
                            </div><br>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('FAQ') }}</label>
                                <div class="col-sm-8">
                                    <textarea name="faq" id="faq">{{ $setting->faq }}</textarea>
                                    <script>
                                        CKEDITOR.replace('faq');
                                    </script>
                                </div>
                            </div><br>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Contact Us') }}</label>
                                <div class="col-sm-8">
                                    <textarea name="contact_us" id="contact_us">{{ $setting->contact_us }}</textarea>
                                    <script>
                                        CKEDITOR.replace('contact_us');
                                    </script>
                                </div>
                            </div>
                            @endforeach

                        </div>
                        <div class="card-footer ml-auto mr-auto">
                            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection