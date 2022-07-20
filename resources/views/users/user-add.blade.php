@extends('layouts.app', ['activePage' => 'users', 'titlePage' => __('Users')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="/user-add" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Add User') }}</h4>
                            <p class="card-category">{{ __('User information') }}</p>
                        </div>
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
                                <label class="col-sm-2 col-form-label">{{ __('Image') }}</label>
                                <div class="col-sm-7">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new img-thumbnail" style="width: 200px; height: 125px;">
                                            <img src="/default/upload_image.png" alt="...">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists img-thumbnail" style="max-width: 200px; max-height: 125px;"></div>
                                        <div>
                                            <span class="btn btn-outline-secondary btn-file"><span class="fileinput-new">Select avatar</span><span class="fileinput-exists">Change</span><input id="avatar" type="file" name="avatar"></span>
                                            <a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">Remove</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Username') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('username') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" id="input-username" type="text" placeholder="{{ __('Username') }}" required="true" aria-required="true" />
                                        @if ($errors->has('username'))
                                        <span id="username-error" class="error text-danger" for="input-username">{{ $errors->first('username') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Display Name') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('displayname') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('displayname') ? ' is-invalid' : '' }}" name="displayname" id="input-displayname" type="text" placeholder="{{ __('Display Name') }}" required="true" aria-required="true" />
                                        @if ($errors->has('displayname'))
                                        <span id="displayname-error" class="error text-danger" for="input-displayname">{{ $errors->first('displayname') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Email') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="input-email" type="email" placeholder="{{ __('Email') }}" required />
                                        @if ($errors->has('email'))
                                        <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Bio') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                        <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" id="input-description" type="text" placeholder="{{ __('Bio') }}"></textarea>
                                        @if ($errors->has('description'))
                                        <span id="description-error" class="error text-danger" for="input-description">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Password') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="input-password" type="password" placeholder="{{ __('Password') }}" required />
                                        @if ($errors->has('password'))
                                        <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Admin') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('admin') ? ' has-danger' : '' }}">
                                        <select name="admin" id="admin" class="form-control">
                                            <option value="0">False</option>
                                            <option value="1">True</option>

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Status') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }}">
                                        <select name="status" id="status" class="form-control">
                                            <option value="1">Enabled</option>
                                            <option value="0">Disabled</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer ml-auto mr-auto">
                            <button type="submit" class="btn btn-primary">{{ __('Add') }}</button>
                            <a href="/users" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
