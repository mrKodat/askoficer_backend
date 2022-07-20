@extends('layouts.app', ['activePage' => 'all-reports', 'titlePage' => __('All Reports')])

@section('content')
<?php

use App\Models\Question;
use App\Models\User; ?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="/allreport-add" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Reports') }}</h4>
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
                                <table id="allcommentsdatatable" class="table" style="width:100%">
                                    <thead class=" text-primary">
                                        <tr>
                                            <th>Type</th>
                                            <th>Question</th>
                                            <th style="width: 35%">Report</th>
                                            <th>Author</th>
                                            <th>Submitted On</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allreports as $allreport)
                                        <tr>
                                            <td>{{ $allreport->type }}</td>
                                            <?php $question = Question::find($allreport->question_id)->title; ?>
                                            <td>{{ $question }}<br><a href="/question-edit/{{ $allreport->answer_id != null ? $allreport->answer_id  : $allreport->question_id  }}">View Question</a></td>
                                            <td style="width: 35%">{{ $allreport->content }}</td>
                                            <?php $author = User::find($allreport->author_id)->displayname; ?>
                                            <td>{{ $author }}</td>
                                            <td>{{ $allreport->date }}</td>
                                            <td class="td-actions text-center">

                                                <a href="/report-delete/{{ $allreport->id }}"><button type="button" rel="tooltip" class="btn btn-danger" data-original-title="" title="" onclick="return confirm('Are you sure?')">
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
        $('#allcommentsdatatable').DataTable({
            "order": [
                [4, "DESC"]
            ]
        });
    });
</script>
@endpush