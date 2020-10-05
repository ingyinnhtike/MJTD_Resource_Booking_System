@extends('la.layouts.app')

@section('htmlheader_title')
    Accessories View
@endsection


@section('main-content')
<div id="page-content" class="profile2">
    <ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
        <li class=""><a href="javascript:history.back()" data-toggle="tooltip" data-placement="right" title="Back to Accessories"><i class="fa fa-chevron-left"></i></a></li>
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
						@la_display($module, 'available_quantity')
                        <div class="form-group">
                            <label class="col-md-4 col-sm-6 col-xs-6">Available Resources :</label>
                            <div class="col-md-8 col-sm-6 col-xs-6">
                                @foreach($resource_lists as $resource)
                                 <div class="label label-primary">{{$resource->name}}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    </div>
    </div>
</div>
@endsection
