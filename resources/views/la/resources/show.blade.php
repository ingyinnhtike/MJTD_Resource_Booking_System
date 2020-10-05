@extends('la.layouts.app')

@section('htmlheader_title')
    Resource View
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
                        @la_display($module, 'name')
						@la_display($module, 'schedule')
						@la_display($module, 'image')
						@la_display($module, 'notes')
						@la_display($module, 'status')
						@la_display($module, 'is_public')
						@la_display($module, 'room_types')
						@la_display($module, 'select_accessory')
                        @if(count($user_lists) > 0)
                        <div class="form-group">
                            <label class="col-md-4 col-sm-6 col-xs-6">Allowed Users :</label>
                            <div class="col-md-8 col-sm-6 col-xs-6">
                                @foreach($user_lists as $user)
                                 <div class="label label-primary">{{$user->name}}</div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        @if(count($group_lists) > 0)
                        <div class="form-group">
                            <label class="col-md-4 col-sm-6 col-xs-6">Allowed Groups :</label>
                            <div class="col-md-8 col-sm-6 col-xs-6">
                                @foreach($group_lists as $group)
                                 <div class="label label-primary">{{$group->name}}</div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
