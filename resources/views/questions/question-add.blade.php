@extends('layouts.app', ['activePage' => 'questions', 'titlePage' => __('questions')])

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="/question-add" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Add Question') }}</h4>
                            <p class="card-category">{{ __('Question information') }}</p>
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
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('author_id') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('author_id') ? ' is-invalid' : '' }}" name="author_id" id="input-author_id" type="text" placeholder="{{ __('author_id') }}" value="{{ $user = auth()->user()->id }}" hidden />
                                        @if ($errors->has('author_id'))
                                        <span id="author_id-error" class="error text-danger" for="input-author_id">{{ $errors->first('author_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Featured Image') }}</label>
                                <div class="col-sm-7">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new img-thumbnail" style="width: 200px; height: 125px;">
                                            <img src="/default/upload_image.png" alt="...">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists img-thumbnail" style="max-width: 200px; max-height: 125px;"></div>
                                        <div>
                                            <span class="btn btn-outline-secondary btn-file"><span class="fileinput-new">Select Image</span><span class="fileinput-exists">Change</span><input id="featuredImage" type="file" name="featuredImage"></span>
                                            <a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">Remove</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Title') }} *</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" id="input-title" type="text" placeholder="{{ __('Title') }}" required="true" aria-required="true" />
                                        @if ($errors->has('title'))
                                        <span id="title-error" class="error text-danger" for="input-title">{{ $errors->first('title') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Category') }} *</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('category_id') ? ' has-danger' : '' }}">
                                        <select class="form-control" data-style="btn btn-link" id="input-category_id" name="category_id">
                                            @foreach($categories as $category )
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('category_id'))
                                        <span id="category_id-error" class="error text-danger" for="input-category_id">{{ $errors->first('category_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Tags') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('tag') ? ' has-danger' : '' }}">
                                        <input data-role="tagsinput" type="text" name="tags">
                                        @if ($errors->has('tags'))
                                        <span class="text-danger">{{ $errors->first('tags') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Details') }} *</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('content') ? ' has-danger' : '' }}">
                                        <textarea class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" name="content" id="input-content" type="text" placeholder="{{ __('Details') }}" rows="5"></textarea>
                                        @if ($errors->has('content'))
                                        <span id="content-error" class="error text-danger" for="input-content">{{ $errors->first('content') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div><br>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Is this question a poll?') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input poll" type="checkbox" name="polled" id="polled">
                                            <span class="form-check-sign">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="ispoll">
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Image poll?') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input imagepoll" type="checkbox" name="imagePolled" id="imagePolled">
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="isnormalpoll">
                                    <br>
                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">{{ __('Options') }}</label>
                                        <div class="col-sm-7">
                                            <div class="form-group">
                                                <div class="field_wrapper">
                                                    <div style="display: flex;">
                                                        <input type="text" name="option[0][value]" id="option" placeholder="Option" class="form-control" style="margin-right: 10px;" />
                                                        <a href="javascript:void(0);" class="add_button" title="Add Field"><i class="material-icons" style="color: black;width: 20px; height:20px">add</i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="isimagepoll">
                                    <br>
                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">{{ __('Options') }}</label>
                                        <div class="col-sm-7">
                                            <div class="form-group">
                                                <div class="field_image_wrapper">
                                                    <div style="display: flex;">
                                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                            <div class="fileinput-new thumbnail img-circle img-no-padding" style="width: 60px;height: 60px;object-fit: fill;">
                                                                <img width="60" height="60" src="/default/upload_image.png" style="max-height: 60px;width: 60px;height: 60px;object-fit: fill;" alt="...">
                                                            </div>
                                                            <div class="fileinput-preview fileinput-exists thumbnail img-circle img-no-padding" style="max-height: 60px;width: 60px;height: 60px;object-fit: fill;"></div>
                                                            <div>
                                                                <span class="btn btn-outline-default btn-file btn-round"><span class="fileinput-new">Add Photo</span><span class="fileinput-exists">Change</span>
                                                                    <input type="file" name="imageoption[0][optionimage]" id="optionimage">
                                                                </span>
                                                                <br>
                                                                <a href="javascript:;" class="btn btn-link btn-danger fileinput-exists btn-round" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                            </div>
                                                        </div>
                                                        <input type="text" name="imageoption[0][value]" id="imageoption" placeholder="Option" class="form-control" style="margin-right: 10px;" />
                                                        <a href="javascript:void(0);" class="add_image_button" title="Add Field"><i class="material-icons" style="color: black;width: 20px; height:20px">add</i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Video URL') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('videoURL') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('videoURL') ? ' is-invalid' : '' }}" name="videoURL" id="input-videoURL" type="text" placeholder="{{ __('Video URL') }}" />
                                        @if ($errors->has('videoURL'))
                                        <span id="videoURL-error" class="error text-danger" for="input-videoURL">{{ $errors->first('videoURL') }}</span>
                                        @endif
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
                            <a href="/questions" class="btn btn-danger">Cancel</a>
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
    $(".poll").change(function() {
        if ($(this).is(":checked")) {
            $(".ispoll").show();
            $(".isnormalpoll").show();
        } else {
            $(".ispoll").hide();
            $(".isnormalpoll").hide();
        }
    }).change();
</script>

<script>
    $(".imagepoll").change(function() {
        if ($(this).is(":checked")) {
            $(".isnormalpoll").hide();
            $(".isimagepoll").show();
        } else {
            $(".isnormalpoll").show();
            $(".isimagepoll").hide();
        }
    }).change();
</script>
@endpush