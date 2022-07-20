@extends('layouts.app', ['activePage' => 'points', 'titlePage' => __('points')])

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Points</h4>
                        <p class="card-category"> Here you can manage points</p>
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

                        <!-- <div class="row">
                            <div class="col-12 text-right">
                                <a href="/point-add" class="btn btn-sm btn-primary">Add point</a>
                            </div>
                        </div> -->

                        <div class="table-responsive">
                            <table id="points" class="table" style="width:100%">
                                <thead class=" text-primary">
                                    <tr>
                                        <th>Points</th>
                                        <th>Action</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($points as $point)
                                    <tr>
                                        <td>{{ $point->description }}</td>
                                        <td>{{ $point->points }}</td>
                                        <td class="td-actions text-center">
                                            <a href="/point-edit/{{ $point->id }}"><button type="button" rel="tooltip" class="btn btn-success" data-original-title="" title="">
                                                    <i class="material-icons">edit</i>
                                                </button></a>
                                            <!-- <a href="/point-delete/{{ $point->id }}"><button type="button" rel="tooltip" class="btn btn-danger" data-original-title="" title="" onclick="return confirm('Are you sure?')">
                                                    <i class="material-icons">close</i>
                                                </button></a> -->
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

@push('js')
<script>
    $(document).ready(function() {
        $('#pointsdatatable').DataTable({
            "order": [
                [1, "asc"]
            ]
        });
    });
</script>
@endpush