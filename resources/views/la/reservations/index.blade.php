@extends("la.layouts.app")
@section("contentheader_title", "Reservations")
@section("contentheader_description", "Reservations listing")
@section("section", "Reservations")
@section("sub_section", "Listing")
@section("htmlheader_title", "Reservations Listing")

@section("main-content")

<div class="box box-info">
    <!--<div class="box-header"></div>-->
    <div class="box-body">

        <div class="dropdown">
            <a class="btn btn-info dropdown-toggle form-control" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Choose Resource
            </a>

            <div class="dropdown-menu form-control" aria-labelledby="dropdownMenuLink">
                @foreach($all_schedule as $all_schedules)
                    <a href="{{route('admin.reservations.show',$all_schedules->id)}}" class="">{{$all_schedules->schedule_name}}</a></br>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/mine.css') }}"/>
@endpush
@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
$(function () {
$("#example1").DataTable({
});
});
</script>
@endpush