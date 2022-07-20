@extends('layouts.app', ['activePage' => 'questions', 'titlePage' => __('questions')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="/question-update/{{ $question->id }}" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Edit Question') }}</h4>
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
                                <label class="col-sm-2 col-form-label">{{ __('Featured Image') }}</label>
                                <div class="col-sm-7">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new img-thumbnail" style="width: 200px; height: 125px;">
                                            @if ($question->featuredImage != null)
                                            <img src="{{ URL::to('/') }}/uploads/featuredImages/{{ $question->featuredImage }}" alt="...">
                                            @else
                                            <img src="/default/upload_image.png" alt="...">
                                            @endif
                                        </div>
                                        <div class="fileinput-preview fileinput-exists img-thumbnail" style="max-width: 200px; max-height: 125px;"></div>
                                        <div>
                                            <span class="btn btn-outline-secondary btn-file"><span class="fileinput-new">Select Image</span><span class="fileinput-exists">Change</span><input id="featuredImage" type="file" name="featuredImage" value="{{ $question->featuredImage }}"></span>
                                            <a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">Remove</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Title') }} *</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" id="input-title" type="text" placeholder="{{ __('Title') }}" required="true" aria-required="true" value="{{ $question->title }}" />
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
                                            <option value="{{ $category->id }}" {{ ( $category->id  == $question->category_id) ? 'selected' : '' }}>{{ $category->name }}</option>
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
                                        <input data-role="tagsinput" type="text" name="tags" value="{{ $tags }}">
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
                                        <textarea class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" name="content" id="input-content" type="text" placeholder="{{ __('Details') }}" rows="5">{{ $question->content }}</textarea>
                                        @if ($errors->has('content'))
                                        <span id="content-error" class="error text-danger" for="input-content">{{ $errors->first('content') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Is this question a poll?') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input poll" type="checkbox" name="polled" id="polled" {{ $question->polled != 0 ? 'checked' : '' }}>
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
                                                <input class="form-check-input imagepoll" type="checkbox" name="imagePolled" id="imagePolled" {{ $question->imagePolled != 0 ? 'checked' : '' }}>
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
                                                <!-- <div class="field_wrapper"> -->
                                                @if(count($options) > 0)
                                                @for($i = 0; $i < count($options); $i++) <div class="{{ $i == count($options) -1 ? 'field_wrapper' : 'field_wrapper_del' }}">
                                                    <div style="display: flex;">
                                                        <input type="text" name="option[{{ $i }}][id]" id="id" placeholder="id" class="form-control" style="margin-right: 10px;" value="{{ $options[$i]->id }}" hidden />
                                                        <input type="text" name="option[{{ $i }}][value]" id="option" placeholder="Option" class="form-control" style="margin-right: 10px;" value="{{ $options[$i]->option }}" />
                                                        @if($i < 1) <a href="javascript:void(0);" class="add_button" title="Add Field"><i class="material-icons" style="color: black;width: 20px; height:20px">add</i></a>
                                                            @else
                                                            <a href="javascript:void(0);" class="remove_button"><i class="material-icons" style="color: black;width: 20px; height:20px">close</i></a>
                                                            @endif
                                                    </div>
                                            </div>

                                            @endfor
                                            @else
                                            <div class="field_wrapper">
                                                <div style="display: flex;">
                                                    <input type="text" name="option[0][value]" id="option" placeholder="Option" class="form-control" style="margin-right: 10px;" />
                                                    <a href="javascript:void(0);" class="add_button" title="Add Field"><i class="material-icons" style="color: black;width: 20px; height:20px">add</i></a>
                                                </div>
                                            </div>
                                            @endif
                                            <!-- </div> -->
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
                                            <!-- <div class="field_wrapper"> -->
                                            @if(count($options) > 0)
                                            @for($i = 0; $i < count($options); $i++) <div class="{{ $i == count($options) -1 ? 'field_image_wrapper' : 'field_image_wrapper_del' }}">
                                                <script>
                                                    x = $i
                                                </script>
                                                <div style="display: flex;">
                                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail img-circle img-no-padding" style="width: 60px; height: 60px;object-fit: cover;">
                                                            @if ($options[$i]->image != null)
                                                            <img src="{{ URL::to('/') }}/uploads/optionimages/{{ $options[$i]->image }}" style="width: 60px; height: 60px;object-fit: cover;" alt="...">
                                                            @else
                                                            <img style="width: 60px; height: 60px;object-fit: fill;" src="/default/upload_image.png" style="max-height: 60px;width: 60px;object-fit: cover;" alt="...">
                                                            @endif
                                                        </div>
                                                        <div width="60" height="60" class="fileinput-preview fileinput-exists thumbnail img-circle img-no-padding" style="height: 60px;width: 60px;object-fit: fill;"></div>
                                                        <div>
                                                            <span class="btn btn-outline-default btn-file btn-round"><span class="fileinput-new">Add Photo</span><span class="fileinput-exists">Change</span>
                                                                <input type="file" name="imageoption[{{ $i }}][image]" id="optionimage" value="{{ $options[$i]->image != null ? $options[$i]->image : null }}">
                                                            </span>
                                                            <br>
                                                            <a href="javascript:;" class="btn btn-link btn-danger fileinput-exists btn-round" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                        </div>
                                                    </div>
                                                    <input type="text" name="imageoption[{{ $i }}][id]" id="id" placeholder="id" class="form-control" style="margin-right: 10px;" value="{{ $options[$i]->id }}" hidden />
                                                    <input type="text" name="imageoption[{{ $i }}][value]" id="option" placeholder="Option" class="form-control" style="margin-left: 10px;margin-right: 10px;" value="{{ $options[$i]->option }}" />
                                                    @if($i < 1) <a href="javascript:void(0);" class="add_image_button" title="Add Field"><i class="material-icons" style="color: black;width: 20px; height:20px">add</i></a>
                                                        @else
                                                        <a href="javascript:void(0);" class="remove_button"><i class="material-icons" style="color: black;width: 20px; height:20px">close</i></a>
                                                        @endif
                                                </div>
                                        </div>
                                        @endfor
                                        @else
                                        <div class="field_image_wrapper">
                                            <div style="display: flex;">
                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail img-circle img-no-padding" style="width: 60px; height: 60px;object-fit: fill;height: 60px;">
                                                        <img width="60" height="60" src="/default/upload_image.png" style="max-height: 60px;width: 60px;object-fit: fill;" alt="...">
                                                    </div>
                                                    <div width="60" height="60" class="fileinput-preview fileinput-exists thumbnail img-circle img-no-padding" style="height: 60px;width: 60px;object-fit: fill;"></div>
                                                    <div>
                                                        <span class="btn btn-outline-default btn-file btn-round"><span class="fileinput-new">Add Photo</span><span class="fileinput-exists">Change</span>
                                                            <input type="file" name="imageoption[0][image]" id="image">
                                                        </span>
                                                        <br>
                                                        <a href="javascript:;" class="btn btn-link btn-danger fileinput-exists btn-round" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                    </div>
                                                </div>
                                                <input type="text" name="imageoption[0][value]" id="option" placeholder="Option" class="form-control" style="margin-right: 10px;" />
                                                <a href="javascript:void(0);" class="add_image_button" title="Add Field"><i class="material-icons" style="color: black;width: 20px; height:20px">add</i></a>
                                            </div>
                                        </div>
                                        @endif
                                        <!-- </div> -->
                                    </div>
                                    <!-- <div class="form-group">
                                        <div class="field_image_wrapper">
                                            <div style="display: flex;">
                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail img-circle img-no-padding" style="width: 60px; height: 60px;object-fit: fill;height: 60px;">
                                                        <img width="60" height="60" src="/default/upload_image.png" style="max-height: 60px;width: 60px;object-fit: fill;" alt="...">
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail img-circle img-no-padding" style="max-height: 60px;width: 60px;object-fit: fill;"></div>
                                                    <div>
                                                        <span class="btn btn-outline-default btn-file btn-round" style="padding: 0px 4px;"><span class="fileinput-new" style="font-size: 8px;">Add Photo</span><span class="fileinput-exists" style="padding: 0px 4px;">Change</span>
                                                            <input type="file" name="optionimage[]" id="optionimage">
                                                        </span>
                                                        <br>
                                                        <a href="javascript:;" class="btn btn-link btn-danger fileinput-exists btn-round" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                                    </div>
                                                </div>
                                                <input type="text" name="option[]" id="option" placeholder="Option" class="form-control" style="margin-right: 10px;" />
                                                <a href="javascript:void(0);" class="add_image_button" title="Add Field"><i class="material-icons" style="color: black;width: 20px; height:20px">add</i></a>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-sm-2 col-form-label">{{ __('Video URL') }}</label>
                        <div class="col-sm-7">
                            <div class="form-group{{ $errors->has('videoURL') ? ' has-danger' : '' }}">
                                <input class="form-control{{ $errors->has('videoURL') ? ' is-invalid' : '' }}" name="videoURL" id="input-videoURL" type="text" placeholder="{{ __('Video URL') }}" value="{{ $question->videoURL }}" />
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
                                    <option value="1" {{ ( $question->status  == 1) ? 'selected' : '' }}>Enabled</option>
                                    <option value="0" {{ ( $question->status  == 0) ? 'selected' : '' }}>Disabled</option>
                                </select>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                <a href="/questions" class="btn btn-danger">Cancel</a>
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
        $(".isnormalpoll").hide();
        $(".isimagepoll").hide();
        if ($(this).is(":checked")) {
            $(".isimagepoll").show();
        } else {
            $(".isnormalpoll").show();
        }
    }).change();
</script>

<script>
    $("#btnfile").click(function() {
        $("#optionimage").click();
    });
</script>

@endpush