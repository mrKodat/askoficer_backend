@extends('layouts.app', ['activePage' => 'push-notifications', 'titlePage' => __('push-notifications')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="/push-notifications-info-save" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Push Notifications Settings') }}</h4>  
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

                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Firebase FCM Key') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('fcm_key') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('fcm_key') ? ' is-invalid' : '' }}" name="fcm_key" id="input-fcm_key" type="text" placeholder="{{ __('Firebase FCM Key') }}" required="true" aria-required="true" value="{{ $setting->fcm_key }}" />
                                        @if ($errors->has('fcm_key'))
                                        <span id="title-error" class="error text-danger" for="input-fcm_key">{{ $errors->first('fcm_key') }}</span>
                                        @endif
                                    </div>
                                    <h7>This key is taken from Firebase and it is used to send notifications to user devices</h7>

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