@extends("la.layouts.app")

@section("contentheader_title")
    <a href="{{ url(config('laraadmin.adminRoute') . '/car_requests') }}">Car Request</a> :
@endsection
@section("contentheader_description", $car_request->$view_col)
@section("section", "Car Requests")
@section("section_url", url(config('laraadmin.adminRoute') . '/car_requests'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Car Requests Edit : ".$car_request->$view_col)

@section("main-content")

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="box box-purple">
    <div class="box-header">
        
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                {!! Form::model($car_request, ['route' => [config('laraadmin.adminRoute') . '.car_requests.update', $car_request->id ], 'method'=>'PUT', 'id' => 'car_request-edit-form']) !!}
                
                
                
                        <div class="request_status">
                        @la_input($module, 'request_status')
                        </div>
                        <div class="row">
                            <div class='col-sm-6'>
                                <div class="form-group bootstrap-timepicker timepicker">
                                <label for="">Start Date :</label>
                                   <input type="date" id="startdate" class="form-control" name="start_date" onchange="getstartdate(); checkRequestTime();">
                                </div>
                            </div>

                            <div class='col-sm-6'>
                                <div class="form-group bootstrap-timepicker timepicker">
                                <label for="">End Date :</label>
                                <input type="date" id="enddate" class="form-control" name="end_date">  
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class='col-sm-6'>
                                <div class="form-group bootstrap-timepicker timepicker">
                                <label for="">Start Time :</label>
                                    <div class='input-group time' id='timepicker1'>
                                    <input id="start_time" name="start_time" type="text" class="form-control input-small" onchange="checkRequestTime();">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class='col-sm-6'>
                                <div class="form-group bootstrap-timepicker timepicker">
                                <label for="">End Time :</label>
                                    <div class='input-group time' id='timepicker2'>
                                        <input type='text' name="end_time" class="form-control" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    <label class="control-label" id="dmes">Destination :</label>
                    <span id="errormsg" style="color: red; display: none;">
                        If you want to go to Downtown, please make a reservation one day in advance or if you want to go to  Zone and Thanlyin, please request half an hour in advance!
                    </span>                
                        <select class="js-example-basic-multiple form-control" onchange="checkRequestTime(this.value);" id="destination" name="destination">
                            <option selected disabled>Choose Destination</option>
                                <option value="1">Zone</option>
                                <option value="1">Thanlyin</option>
                                <option value="2">Downtown</option>
                        </select>
                    <div class="desvalid" style="display: none;">
                        @la_input($module, 'way')
                        @la_input($module, 'purpose')
                        @la_input($module, 'no_of_participant')
                        @la_input($module, 'participants')
                        @la_input($module, 'remark')
                    </div>
				
                
                    <div class="modal-footer">
                        <div class="desvalid" style="display: none;">
                            {!! Form::submit( 'Update', ['class'=>'btn btn-info']) !!} <a href="{{ url(config('laraadmin.adminRoute') . '/car_requests') }}" class="btn btn-default pull-right">Cancel</a>                
                        </div>
                    </div>   
                    
            </div>
        </div>
    </div>
</div>

@endsection
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css">
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>

<script>
$(function () {
    $("#car_request-edit-form").validate({
        
    });
});

</script>
<script type="text/javascript">
    $('#timepicker1').datetimepicker({
        format: 'LT'
  });
  
  $('#timepicker2').datetimepicker({
    format: 'LT'
  });


  function getstartdate() {
    var dategtc = new Date($('#startdate').val());
    console.log(dategtc);
    var day=dategtc.getDay();

    $('#enddate').val($('#startdate').val());
    };


function checkRequestTime(start_time){
    var destination = $("#destination option:selected").val();
    var startDate = $('#startdate').val();
    
    var now = moment(now).format('YYYY-MM-DD');
    
    var deltaMinutes = 30
    var d = new Date();
    var dt = d.setMinutes( d.getMinutes() + 30 );
    var current_time = moment(dt).format('HH:mm');
    console.log(current_time);
    
    var startTime = $('#start_time').val();
    var start_time = moment(startTime, ["h:mm A"]).format("HH:mm");
    //console.log(start_time);
    var req_status = $("input[name='request_status']:checked").val();
    //console.log(req_status);
    if((destination == 2 && startDate > now) || (destination == 1 && start_time > current_time) || (destination == 1 && startDate > now) || req_status == 'Urgent' )
    {
        $(".desvalid").css('display', 'block');
        $("#errormsg").css('display', 'none');

    }else{
        $(".desvalid").css('display', 'none');
        $("#errormsg").css('display', 'block');       
    }
    
}

$(document).ready(function(){
    $(".request_status").click(function () {
        var req_status = $("input[name='request_status']:checked").val();
        console.log(req_status);
        if(req_status == 'Urgent')
        {
            $(".desvalid").css('display', 'block');
            $("#errormsg").css('display', 'none');
        }else
        {
            $(".desvalid").css('display', 'none');
        }
    });
});

    




</script>
@endpush
