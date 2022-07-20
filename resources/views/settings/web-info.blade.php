@extends('layouts.app', ['activePage' => 'web-info', 'titlePage' => __('app-info')])

@section('content')

<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="/web-info-save" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Website Information') }}</h4>
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

                                <br>
                               <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Website Name') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('web_name') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('web_name') ? ' is-invalid' : '' }}" name="web_name" id="input-web_name" type="text" placeholder="{{ __('Website Name') }}" required="true" aria-required="true" value="{{ $setting->web_name }}" />
                                        @if ($errors->has('web_name'))
                                        <span id="title-error" class="error text-danger" for="input-web_name">{{ $errors->first('web_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <br>
                              <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Favicon') }}</label>
                                <div class="col-sm-7">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new img-thumbnail" style="width: 200px; height: 125px;">
                                            @if ($setting->favicon != null)
                                            <img src="/uploads/settings/{{ $setting->favicon }}" alt="...">
                                            @else
                                            <img src="/default/upload_image.png" alt="...">
                                            @endif
                                        </div>
                                        <div class="fileinput-preview fileinput-exists img-thumbnail" style="max-width: 200px; max-height: 125px;"></div>
                                        <div>
                                            <span class="btn btn-outline-secondary btn-file"><span class="fileinput-new">Select favicon</span><span class="fileinput-exists">Change</span><input id="favicon" type="file" name="favicon" value="{{ $setting->favicon }}"></span>
                                            <a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">Remove</a>
                                        </div>
                                    </div>
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