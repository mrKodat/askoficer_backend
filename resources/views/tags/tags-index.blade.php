@extends('layouts.app', ['activePage' => 'tags', 'titlePage' => __('tags')])

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Tags</h4>
                        <p class="card-category"> Here you can manage tags</p>
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

                        <div class="row">
                            <div class="col-12 text-right">
                                <a href="/tag-add" class="btn btn-sm btn-primary">Add Tag</a>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="datatable" class="table" style="width:100%">
                                <thead class=" text-primary">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <!-- <th>Description</th> -->
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tags as $i => $tag)
                                    <tr>
                                        <th>{{ $i + 1 }}</th>
                                        <td>{{ $tag->name }}</td>
                                        <!-- <td>{{ $tag->description }}</td> -->
                                        <td style="font-size: 18px;"><span class="badge badge-success">{{ $tag->status == 1 ? 'Enabled' : 'Disabled' }}</span></td>
                                        <td class="td-actions text-center">
                                            <a href="/tag-edit/{{ $tag->id }}"><button type="button" rel="tooltip" class="btn btn-success" data-original-title="" title="">
                                                    <i class="material-icons">edit</i>
                                                </button></a>
                                            <a href="/tag-delete/{{ $tag->id }}"><button type="button" rel="tooltip" class="btn btn-danger" data-original-title="" title="" onclick="return confirm('Are you sure?')">
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