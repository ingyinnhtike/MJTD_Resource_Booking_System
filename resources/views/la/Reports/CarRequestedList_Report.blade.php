@extends("la.layouts.app")

@section("contentheader_title", "Car Requested List Report")
@section("contentheader_description", "")
@section("section", "Car Requested List Report")
@section("sub_section", "Listing")
@section("htmlheader_title", "Car Requested List Report")

@section("main-content")

<div class="box box-purple">  
    <div class="box-body">
        {!! Form::open(['action' => 'ReportsController@carrequestedreport_filter', 'method' => 'POST']) !!}
        <div class="row form-group">
            <div class="col-sm-2">
                <label>Car Number</label>
                <select class="form-control input-sm" data-placeholder="Select User" id="car_number" rel="select2" name="car_number">
                    <option value="0" selected>*</option>
                    @foreach($car_lists as $car)
                        @if($car->id == $carnumber)
                        <option value="{{$car->id}}" selected>{{$car->car_no}}</option>
                        @else
                        <option value="{{$car->id}}">{{$car->car_no}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-sm-2">
                <label>From Date</label>
                <div class="input-group date"><input class="form-control input-sm" placeholder="Enter From Date" data-rule-minlength="0" id="from_date" name="from_date" type="text" value="{{$from_date}}"><span class="input-group-addon input_dt"><span class="fa fa-calendar"></span></span></div>
            </div>
            <div class="col-sm-2">
                <label>To Date</label>
                <div class="input-group date"><input class="form-control input-sm" placeholder="Enter To Date" data-rule-minlength="0" id="to_date" name="to_date" type="text" value="{{$to_date}}"><span class="input-group-addon input_dt"><span class="fa fa-calendar"></span></span></div>
            </div>
            <div class="col-md-1" style="margin-top:25px;">
                {{ Form::button('<i class="fa fa-search"> 
                
                </i>', ['type' => 'submit', 'class' => 'btn btn-primary btn-sm'] )  }} 
            </div>
            
        </div>
        {!! Form::close() !!}
        
        <div class="tab-pane active" id="fa-icons">            
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Requested By</th>
                        <th>Begin Date</th>
                        <th>End Date</th>
                        <th>Begin Time</th>
                        <th>End Time</th>
                        <th>Destination</th>
                        <th>Number of participants</th>
                        <th>Remark</th>
                        <th>Car Number</th>
                        <th>Car Driver</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $car_requestedlists)
                        <tr>
                            <td>{{$car_requestedlists->id}}</td>
                            <td><a href="{{route('admin.car_requests.show',$car_requestedlists->id)}}">{{$car_requestedlists->username}}</a></td>
                            <td>{{$car_requestedlists->start_date}}</td>
                            <td>{{$car_requestedlists->end_date}}</td>
                            <td>{{$car_requestedlists->start_time}}</td>
                            <td>{{$car_requestedlists->end_time}}</td>
                            <td>{{$car_requestedlists->way}}</td>
                            <td>{{$car_requestedlists->no_of_participant}}</td>
                            <td>{{$car_requestedlists->remark}}</td>
                            <td>{{$car_requestedlists->car_no}}</td>
                            <td>{{$car_requestedlists->car_driver}}</td>
                            <td>{{$car_requestedlists->status}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')

<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script>
 
$('#fa-icons #example1').DataTable({
       
       'dom' : 'Bfrtip', 
       

       buttons: [   
         {
          extend:   'excel',
          title: "Detail Booking Report " + " " + ($("#resource option:selected").text() == '*' ? '' : $("#carnumber option:selected").text()),
          filename: 'Detail Booking Report'
          
         }                    
       ]
   });

   $(".dt-buttons").show(); 
    document.getElementsByClassName('dt-button')[0].children[0].innerHTML = "<i class='fa fa-download'> Export Excel</i>";
    document.getElementsByClassName('dt-button')[0].className += " btn btn-success btn-sm";


$(function () {

    $('table[data-form="deleteFormusers"]').on('click', '.form-delete', function(e){
    e.preventDefault();
    var $form=$(this);
    $('#confirm').modal({ backdrop: 'static', keyboard: false })
        .on('click', '#delete-btn', function(){
            $form.submit();
        });
    });
    
    
});
</script>
<script>



</script>
@endpush
