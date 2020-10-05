@extends('la.layouts.app')

@section('htmlheader_title')
    Booking Detail
@endsection

@section('main-content')
<div id="page-content" class="profile2">
    
    <ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
        <li class=""><a href="javascript:history.back()" data-toggle="tooltip" data-placement="right" title="Back to Resources"><i class="fa fa-chevron-left"></i></a></li>
        <li class="active"><a role="tab" data-toggle="tab" class="active" href="#tab-general-info" data-target="#tab-info"><i class="fa fa-bars"></i> General Info</a></li>
    </ul>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active fade in" id="tab-info">
            <div class="tab-content">
                <div class="panel infolist">
                    <div class="panel-default panel-heading">
                        <h4>General Info</h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="name" class="col-md-4 col-sm-6 col-xs-6">Title :</label>
                            <div class="col-md-8 col-sm-6 col-xs-6 fvalue">{{$bookinglist->title}}</div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 col-sm-6 col-xs-6">Description :</label>
                            <div class="col-md-8 col-sm-6 col-xs-6 fvalue">{{$bookinglist->description}}</div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 col-sm-6 col-xs-6">Resource :</label>
                            <div class="col-md-8 col-sm-6 col-xs-6 fvalue">{{$resourcename->name}}</div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 col-sm-6 col-xs-6">Booking Date :</label>
                            <div class="col-md-8 col-sm-6 col-xs-6 fvalue">{{$bookinglist->begin_date}}</div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-md-4 col-sm-6 col-xs-6">Booking Time :</label>
                            <div class="col-md-8 col-sm-6 col-xs-6 fvalue">{{$bookinglist->begin_time}} - {{$bookinglist->end_time}}</div>
                        </div>
                        <table class="table table-striped table-border">
                            <thead>
                                <tr>
                                    <th class="col-sm-4">Participant Users</th>
                                    <th class="col-sm-4">Invitees</th>
                                    <th class="col-sm-4" colspan="2">Accessories List</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        @foreach($participants_list as $participants_lists)
                                        {{$participants_lists->name}}<br>
                                        @endforeach
                                    </td>
                                    <td>
                                        {{$invitees->email}}
                                    </td>
                                    @foreach($accessories_list as $accessories_lists)
                                    <td>
                                        {{$accessories_lists->name}}<br>
                                    </td>
                                    <td>
                                        {{$accessories_lists->quantity}}<br>
                                    </td>
                                    @endforeach
                                </tr>                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
