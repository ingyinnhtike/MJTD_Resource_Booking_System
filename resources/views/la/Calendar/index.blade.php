@extends("la.layouts.app")
@section("contentheader_title", "Calendar")
@section("contentheader_description", "Calendar")
@section("section", "Calendar")
@section("sub_section", "Listing")
@section("htmlheader_title", "Calendar")
@section("headerElems")

@endsection
@section("main-content")
<div class="row">
    <div class="col-sm-12">
        <div class="box box-purple">
            <div class="box-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>
    
<div class="modal fade bd-example-modal-lg" id="ViewBooking" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Reservation</h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <!-- {!! Form::open(['action' => 'LA\ReservationsController@cancel']) !!} -->
                        <input type="hidden" id="reservation_id" name="reservation_id" class="form-control input-sm" >
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label class="control-label">Resource : <span style="color: red;">*</span></label>                
                                <input type="text" id="resource" name="resource" class="form-control input-sm" readonly>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label for="inputEmail4">Begin : <span style="color: red;">*</span></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="date" id="begin_date" name="begin_date" readonly class="form-control input-sm" value=""> 
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="begin_time" id="begin_time" readonly class="form-control input-sm">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail4">End : <span style="color: red;">*</span></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="date" id="end_date" name="end_date" class="form-control input-sm" value="" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="end_time" id="endtime" class="form-control input-sm" readonly>
                                    </div>
                                </div>                  
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Title : <span style="color: red">*</span></label>
                                <input type="text" readonly class="form-control input-sm" id="title" name="title">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Description : </label>
                                <textarea cols="30" rows="2" readonly class="form-control input-sm" name="description"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <div class="row">   
                                    <div class="col-md-12 mx-auto">
                                        <label class="control-label">Participants : </label>                
                                        <select class="js-example-basic-multiple form-control input-sm" id="participants" name="user_id[]" disabled multiple="multiple">
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Number of Participant</label>
                                <input type="number" readonly class="form-control input-sm" id="no_of_participant" name="no_of_participant" value=0>     
                            </div>
                            <div class="form-group col-md-6">
                                <label>Invitees(comma(,) separted for each mail) :</label>
                                <input type="text" readonly class="form-control input-sm" id="invitees" name="invitees">
                            </div>
                        </div>
                        <div class="row" id="accessories_div" style="display: none;">
                            <div class="col-md-4">
                                <label>Accessories</label>
                            </div> 
                            <div class="col-md-4">
                                <label>Quantity Requested</label>
                            </div>    
                        </div>
                        <div class="inc_row">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                            <!-- {!! Form::submit( 'Cancel Reservation', ['class'=>'btn btn-sm btn-warning']) !!} -->
                        </div>
                    <!-- {!! Form::close() !!}  -->
                <div>
            </div> 
        </div>                
    </div>
</div>
@endsection
@push('styles')

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" />
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/css/calendar.css') }}"/>
<!-- <link rel="stylesheet" type="text/css" href="{{ asset('la-assets/mine.css') }}"/> -->
@endpush
@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script>
var reservations = <?php echo json_encode($reservations); ?>;
    $(document).ready(function(){
        $("#calendar").fullCalendar({
            left:   'title',
            header : {
                left : "prev, next, today",
                center : "title", 
                right : "month,agendaWeek,agendaDay,listYear"
            },
            slotLabelFormat:"HH:mm",
            //defaultView: 'agendaWeek',
            events : [
                @foreach($reservations as $reservation)
                {
                    id : '{{$reservation->id}}',
                    title: '{{ $reservation->title." ".$reservation->begin_time."-".$reservation->end_time }}',
                    start: '{{ $reservation->begin_date." ".$reservation->begin_time }}',
                    end: '{{ $reservation->end_date." ".$reservation->end_time }}'
                },
                @endforeach
            ],
            eventClick: function (event) {
                ViewReservation(event.id);
            }
        })
    });
function ViewReservation(reservation_id){
    for (var i = reservations.length - 1; i >= 0; i--) {
        if(reservations[i].id == reservation_id){
            var reservation = reservations[i];
            var modal = $("#ViewBooking");
            modal.find("#reservation_id").val(reservation.id);
            modal.find('#title').val(reservation.title);
            modal.find('#begin_date').val(reservation.begin_date);
            modal.find('#end_date').val(reservation.end_date);
            modal.find('#description').val(reservation.description);
            modal.find('#begin_time').val(reservation.begin_time);
            modal.find('#endtime').val(reservation.end_time);
            modal.find("#no_of_participant").val(reservation.no_of_participant);

            $.ajax({
                dataType: 'json',
                url : "{{ url(config('laraadmin.adminRoute') . '/getResource') }}",
                type: 'POST',
                data : {'_token': '{{ csrf_token() }}', 'reservation_id' : reservation_id},
                success: function ( response ) {
                    var resource = response.resource;
                    modal.find('#resource').val(resource.name + '- Number of maximum people('+ resource.no_of_maximum_people + ')');
                }
            });
            $.ajax({
                dataType: 'json',
                url : "{{ url(config('laraadmin.adminRoute') . '/getParticipants') }}",
                type: 'POST',
                data : {'_token': '{{ csrf_token() }}', 'reservation_id' : reservation_id},
                success: function ( response ) {
                    var user_list = [];
                    var users = response.users;
                    for (var i = response.users.length - 1; i >= 0; i--) {
                        user_list.push(response.users[i].id);
                    }
                    modal.find('#participants').val(user_list).trigger('change');
                }
            });
            $.ajax({
                dataType: 'json',
                url : "{{ url(config('laraadmin.adminRoute') . '/getInvitees') }}",
                type: 'POST',
                data : {'_token': '{{ csrf_token() }}', 'reservation_id' : reservation_id},
                success: function ( response ) {
                    var invitees = response.invitees;
                    
                    modal.find('#invitees').val(invitees[0].email);
                }
            });
            $.ajax({
                dataType: 'json',
                url : "{{ url(config('laraadmin.adminRoute') . '/getAccessories') }}",
                type: 'POST',
                data : {'_token': '{{ csrf_token() }}', 'reservation_id' : reservation_id},
                success: function ( response ) {
                    modal.find(".inc_row").html('');
                    $("#accessories_div").css('display', 'none');
                    var accessories = response.accessories;
                    if(accessories.length > 0){
                        $("#accessories_div").css('display', 'block');
                        for (var i = accessories.length - 1; i >= 0; i--) {
                            var accessory = accessories[i];
                            var new_entry1 = `<div class="row" id="accessories_grid">
                                <div class="col-md-4">
                                    <div class="form-group">

                                        <input type="text" class="form-control input-sm" value=`+accessory.name+`>
                                        
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" name="requested" id="requested" readonly value=`+accessory.quantity+` class="form-control input-sm" placeholder="Quantity Requested">
                                    </div>                       
                                </div>
                            </div>`;                    
                            modal.find(".inc_row").append(new_entry1);
                        }
                    }
                    
                }
            });

            $("#ViewBooking").modal('show');
        }
    }
}
</script>

@endpush