@extends('layouts.app', ['activePage' => 'points', 'titlePage' => __('points')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="/point-update/{{ $point->id }}" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Edit Point') }}</h4>
                            <p class="card-category">{{ __('Point information') }}</p>
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
                                <label class="col-sm-2 col-form-label">{{ __('Action') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" id="input-description" type="text" placeholder="{{ __('Description') }}" value="{{ $point->description }}" hidden />
                                        <input class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="desc" id="input-desc" type="text" placeholder="{{ __('Description') }}" value="{{ $point->description }}" disabled />
                                        @if ($errors->has('description'))
                                        <span id="description-error" class="error text-danger" for="input-description">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Points') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('points') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('points') ? ' is-invalid' : '' }}" name="points" id="input-points" type="text" placeholder="{{ __('Points') }}" value="{{ $point->points }}" />
                                        @if ($errors->has('points'))
                                        <span id="points-error" class="error text-danger" for="input-points">{{ $errors->first('points') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer ml-auto mr-auto">
                            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                            <a href="/points" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(".colorpicker").spectrum({
        allowEmpty: true,
        move: function(color) {
            $('.color_value').val(color.toHexString());
        }
    });
</script>
@endpush