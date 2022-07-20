@extends('layouts.app', ['activePage' => 'questions', 'titlePage' => __('questions')])

@section('content')

<?php

use App\Models\Category;
use App\Models\User;
?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Questions</h4>
                        <p class="card-category"> Here you can manage Questions</p>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="material-icons">close</i>
                            </button>
                            <span>
                                {{ session('status')}}</span>
                        </div>
                        @endif

                        @if (session('categories'))
                        <div>{{ session['categories'] }}</div>
                        @endif

                        <div class="row">
                            <div class="col-12 text-right">
                                <a href="/question-add" class="btn btn-sm btn-primary">Add question</a>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="datatable" class="table" style="width:100%">
                                <thead class=" text-primary">
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>Author</th>
                                        <th>Category</th>
                                        <th>Published At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($questions as $i => $question)
                                    <tr>
                                        <th>{{ $i + 1 }}</th>
                                        <td>{{ $question->title }}</td>
                                        <td>{{ $question->type }}</td>
                                        <?php $author = User::findOrFail($question->author_id)->displayname; ?>
                                        <td>{{ $author }}</td>
                                        @if($question->category_id != null) 
                                            <?php $category = Category::findOrFail($question->category_id)->name; ?>
                                            <td>{{ $category }}</td>
                                        @else <td>-</td>
                                        @endif
                                        <td>{{ $question->created_at }}</td>
                                        <td class="td-actions text-center">
                                            <a href="/question-edit/{{ $question->id }}"><button type="button" rel="tooltip" class="btn btn-success" data-original-title="" title="">
                                                    <i class="material-icons">edit</i>
                                                </button></a>
                                            <a href="/question-delete/{{ $question->id }}"><button type="button" rel="tooltip" class="btn btn-danger" data-original-title="" title="" onclick="return confirm('Are you sure?')">
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
            </div>
        </div>
    </div>
</div>
@endsection