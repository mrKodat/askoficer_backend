@extends('layouts.app', ['activePage' => 'comments', 'titlePage' => __('Comments')])

@section('content')
<?php

use App\Models\Question;
use App\Models\User; ?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="/comment-add" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Comments') }}</h4>
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
                                <table id="datatable" class="table" style="width:100%">
                                    <thead class=" text-primary">
                                        <tr>
                                            <th>Type</th>
                                            <th>Author</th>
                                            <th style="width: 50%">Comment</th>
                                            <th>In reponse to</th>
                                            <th>Submitted on</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allComments as $comment)
                                        <tr>
                                            <td>{{ $comment->type }}</td>
                                            <?php $author = User::find($comment->author_id)->displayname; ?>
                                            <td>{{ $author }}</td>
                                            <td style="width: 50%">{{ $comment->content }}</td>
                                            <?php $question = Question::find($comment->comment_id != null ? $comment->comment_id  : $comment->question_id)->title; ?>
                                            <td>{{ $question }}<br><a href="/question-edit/{{ $comment->comment_id != null ? $comment->comment_id  : $comment->question_id  }}">View Question</a></td>
                                            <td>{{ $comment->date }}</td>
                                            <td class="td-actions text-center">

                                                <a href="/comment-delete/{{ $comment->id }}"><button type="button" rel="tooltip" class="btn btn-danger" data-original-title="" title="" onclick="return confirm('Are you sure?')">
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