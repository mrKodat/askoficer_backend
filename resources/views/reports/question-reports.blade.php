@extends('layouts.app', ['activePage' => 'question-reports', 'titlePage' => __('Question Reports')])

@section('content')
<?php

use App\Models\Question;
use App\Models\User; ?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="/report-add" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Questions') }}</h4>
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

                            <div class="table-responsive">
                                <table id="questiondatatable" class="table" style="width:100%">
                                    <thead class=" text-primary">
                                        <tr>
                                            <th>Question</th>
                                            <th style="width: 35%;">Report</th>
                                            <th>Author</th>
                                            <th>Submitted On</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($questionreports as $report)
                                        <tr>
                                            <?php $question = Question::find($report->question_id)->title; ?>
                                            <td style="width: 35%;">{{ $question }}<br><a href="/question-edit/{{ $report->question_id }}">View Question</a></td>
                                            <td>{{ $report->content }}</td>
                                            <?php $author = User::find($report->author_id)->displayname; ?>
                                            <td>{{ $author }}</td>
                                            <td>{{ $report->date }}</td>
                                            <td class="td-actions text-center">

                                                <a href="/report-delete/{{ $report->id }}"><button type="button" rel="tooltip" class="btn btn-danger" data-original-title="" title="" onclick="return confirm('Are you sure?')">
                                                        <i class="material-icons">close</i>
                                                    </button></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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
    $(document).ready(function() {
        $('#questiondatatable').DataTable({
            "order": [
                [3, "DESC"]
            ]
        });
    });
</script>
@endpush