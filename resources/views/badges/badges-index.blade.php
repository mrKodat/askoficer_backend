@extends('layouts.app', ['activePage' => 'badges', 'titlePage' => __('badges')])

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Badges</h4>
                        <p class="card-category"> Here you can manage Badges</p>
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
                                <a href="/badge-add" class="btn btn-sm btn-primary">Add badge</a>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="badges" class="table" style="width:100%">
                                <thead class=" text-primary">
                                    <tr>
                                        <th>Badge</th>
                                        <th>Points</th>
                                        <th>Description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($badges as $badge)
                                    <tr>
                                        <td style="font-size: 18px;"><span class="badge" style="background-color:{{ $badge->color }};color: white;">{{ $badge->name }}</span></td>
                                        <td style="width: 100px;text-align: center;">{{ $badge->from }} {{ $badge->to != null ? ' - '.$badge->to : '' }}</td>
                                        <td>{{ $badge->description }}</td>
                                        <td class="td-actions text-center">
                                            <a href="/badge-edit/{{ $badge->id }}"><button type="button" rel="tooltip" class="btn btn-success" data-original-title="" title="">
                                                    <i class="material-icons">edit</i>
                                                </button></a>
                                            <a href="/badge-delete/{{ $badge->id }}"><button type="button" rel="tooltip" class="btn btn-danger" data-original-title="" title="" onclick="return confirm('Are you sure?')">
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

@push('js')
<script>
$(document).ready(function() {
    $('#badgesdatatable').DataTable( {
        "order": [[ 1, "asc" ]]
    } );
} );
</script>
@endpush