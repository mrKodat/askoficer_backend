<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<?php

use App\Models\Setting;

$settings = Setting::find(1);
$webName = $settings->web_name;
$favicon = $settings->favicon;

?>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $webName ?? 'AnswerMe' }} - Admin Panel</title>
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('material') }}/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/uploads/settings/{{ $favicon }}">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="{{ asset('material') }}/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{ asset('material') }}/demo/demo.css" rel="stylesheet" />

    <link href="{{ asset('material') }}/css/spectrum.css" rel="stylesheet" />

    {{-- <link rel="stylesheet" href="{{ asset('assets/css/dataTables.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('material') }}/css/paper-kit.min.css" rel="stylesheet" />

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">  -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/4.0.0/css/jasny-bootstrap.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/4.0.0/js/jasny-bootstrap.min.js"></script>

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous"> -->

</head>

<body class="{{ $class ?? '' }}">
    @auth()
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    @include('layouts.page_templates.auth')
    @endauth
    @guest()
    @include('layouts.page_templates.guest')
    @endguest

    <script src="https://cdn.ckeditor.com/ckeditor5/25.0.0/classic/ckeditor.js"></script>

    <!--   Core JS Files   -->
    <script src="{{ asset('material') }}/js/core/jquery.min.js"></script>
    <script src="{{ asset('material') }}/js/core/popper.min.js"></script>
    <script src="{{ asset('material') }}/js/core/bootstrap-material-design.min.js"></script>
    <script src="{{ asset('material') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!-- Plugin for the momentJs  -->
    <script src="{{ asset('material') }}/js/plugins/moment.min.js"></script>
    <!--  Plugin for Sweet Alert -->
    <script src="{{ asset('material') }}/js/plugins/sweetalert2.js"></script>
    <!-- Forms Validations Plugin -->
    <script src="{{ asset('material') }}/js/plugins/jquery.validate.min.js"></script>
    <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
    <script src="{{ asset('material') }}/js/plugins/jquery.bootstrap-wizard.js"></script>
    <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
    <script src="{{ asset('material') }}/js/plugins/bootstrap-selectpicker.js"></script>
    <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
    <script src="{{ asset('material') }}/js/plugins/bootstrap-datetimepicker.min.js"></script>
    <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
    <script src="{{ asset('material') }}/js/plugins/jquery.dataTables.min.js"></script>
    <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
    <script src="{{ asset('material') }}/js/plugins/bootstrap-tagsinput.js"></script>
    <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
    <script src="{{ asset('material') }}/js/plugins/jasny-bootstrap.min.js"></script>
    <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
    <script src="{{ asset('material') }}/js/plugins/fullcalendar.min.js"></script>
    <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
    <script src="{{ asset('material') }}/js/plugins/jquery-jvectormap.js"></script>
    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script src="{{ asset('material') }}/js/plugins/nouislider.min.js"></script>
    <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
    <!-- Library for adding dinamically elements -->
    <script src="{{ asset('material') }}/js/plugins/arrive.min.js"></script>
    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE'"></script>
    <!-- Chartist JS -->
    <script src="{{ asset('material') }}/js/plugins/chartist.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="{{ asset('material') }}/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('material') }}/js/material-dashboard.js?v=2.1.1" type="text/javascript"></script>
    <!-- Material Dashboard DEMO methods, don't include it in your project! -->
    <script src="{{ asset('material') }}/demo/demo.js"></script>
    <script src="{{ asset('material') }}/js/settings.js"></script>
    <script src="{{ asset('assets/js/dataTables.min.js') }}"></script>

    <script src="{{ asset('material') }}/js/spectrum.js"></script>

    <!-- Add or remove dynamic fields -->
    <script type="text/javascript">
        $(document).ready(function() {
            var x = "<?php echo isset($i) ? $i - 1 : 0 ?>"; //Initial field counter is 1
            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var addImageButton = $('.add_image_button');
            var wrapper = $('.field_wrapper'); //Input field wrapper
            var imagewrapper = $('.field_image_wrapper'); //Input field wrapper
            var wrapperDel = $('.field_wrapper_del');
            var imagewrapperDel = $('.field_image_wrapper_del');

            //Once add button is clicked
            $(addButton).click(function() {
                //Check maximum number of input fields
                if (x < maxField) {
                    ++x; //Increment field counter
                    $(wrapper).append('<div style="display: flex;">' +
                        // '<input type="text" name="option[' + x + '][id]" id="id" placeholder="Id" class="form-control" style="margin-right: 10px;margin-top: 10px;" hidden/>' +
                        '<input type="text" name="option[' + x + '][value]" id="option" placeholder="Option" class="form-control" style="margin-right: 10px;margin-top: 10px;" />' +
                        '<a href="javascript:void(0);" class="remove_button"><i class="material-icons" style="color: black;width: 20px; height:20px">close</i></a></div>'); //Add field html
                }
            });

            $(addImageButton).click(function() {
                //Check maximum number of input fields
                if (x < maxField) {
                    ++x; //Increment field counter
                    $(imagewrapper).append('<div style="display: flex;">' +
                        '<div class="fileinput fileinput-new text-center" data-provides="fileinput">' +
                        '<div class="fileinput-new thumbnail img-circle img-no-padding" style="width: 60px; height: 60px;object-fit: fill;height: 60px;">' +
                        '<img width="60" height="60" src="/default/upload_image.png" style="max-height: 60px;width: 60px;object-fit: fill;" alt="...">' +
                        '</div>' +
                        '<div class="fileinput-preview fileinput-exists thumbnail img-circle img-no-padding" style="max-height: 60px;width: 60px;object-fit: fill;"></div>' +
                        '<div>' +
                        '<span class="btn btn-outline-default btn-file btn-round"><span class="fileinput-new">Add Photo</span><span class="fileinput-exists">Change</span><input type="file" id="optionimage" name="imageoption[' + x + '][optionimage]"></span>' +
                        '<br>' +
                        '<a href="javascript:;" class="btn btn-link btn-danger fileinput-exists btn-round" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>' +
                        '</div>' +
                        '</div>' +
                        // '<input type="text" name="imageoption[' + x + '][id]" id="id" placeholder="Id" class="form-control" style="margin-right: 10px;margin-top: 10px;" hidden/>' +
                        '<input type="text" name="imageoption[' + x + '][value]" id="option" placeholder="Option" class="form-control" style="margin-right: 10px;margin-top: 10px;" />' +
                        '<a href="javascript:void(0);" class="remove_button"><i class="material-icons" style="color: black;width: 20px; height:20px">close</i></a></div>'); //Add field html
                }
            });

            function dosomething(val) {
                console.log(val);
            }

            $('#OpenImgUpload').click(function() {
                $('#optionimage').trigger('click');
            });

            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function(e) {
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });

            //Once remove button is clicked
            $(imagewrapper).on('click', '.remove_button', function(e) {
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });

            $(wrapperDel).on('click', '.remove_button', function(e) {
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });

            $(imagewrapperDel).on('click', '.remove_button', function(e) {
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                "pageLength": 50
            });
        });
        $('#OpenImgUpload').click(function() {
            $('#optionimage').trigger('click');
        });
    </script>

    @stack('js')
</body>

</html>