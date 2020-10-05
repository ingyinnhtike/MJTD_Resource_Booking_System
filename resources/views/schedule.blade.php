
@extends("la.layouts.app")
@section('main-content')

<div class="col-lg-10 col-md-9 col-sm-7">
<div class="card">
    <div class="card-header">
        <b>All Schedules</b>
    </div>
    <div class="card-body p-1">
        <a href="{{ url('/addclass') }}">
            <button type="button" class="btn btn-sm btn-primary mb-1"><i class="fa fa-plus text-light"></i>&nbsp;&nbsp;Add
            Schedule</button>
        </a>
        @if(session('status'))
        <div class="alert alert-danger mb-2" role="alert">
            {{session('status')}}
        </div>
        @endif
        <table class="table table-bordered">
            <tr style="background-color: #D5D8DC;">
                <th class="p-1">ID</th>
                <th class="p-1">Title</th>
                <th class="p-1">Price</th>
                <th class="p-1">Description</th>
                <th class="p-1" style="text-align: center;">Photo</th>
                <th class="p-1">Created at</th>
                <th class="p-1" style="text-align: center;">Actions</th>
            </tr>
            
            <tr style="border: solid white;">
                <td colspan="6"></td>
                <td style="border: solid white; text-align: center;">
                    <button class="btn btn-default btn-delete btn-xs" type="submit" data-href="/delete.php?id=54" data-toggle="modal"
                    data-target="#confirm-delete"><i class="fa fa-times"></i></button>
                </td>
            </tr>
            <div class="modal" id="confirm-delete" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <p>Are you sure, you want to delete? </p>
                            <p class="text-secondary">
                                <small>
                                This will delete all your records.
                                </small>
                            </p>
                            <p class="debug-url"></p>
                        </div>
                        <div class="modal-footer">
                            <a href="" style="text-decoration: none;">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</but
                                ton>
                            </a>
                            <a href="{{ url('class/deleteall') }}"><button
                                type="button" class="btn btn-danger">Delete</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </table>
    </div>
</div>
</div>
</div>
@endsection