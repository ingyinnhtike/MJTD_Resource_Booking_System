@extends('la.layouts.app')
@section('htmlheader_title')
All Schedule View
@endsection
@section('main-content')
<div id="page-content" class="profile2">
    
    <ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
        <li class=""><a href="{{ url(config('laraadmin.adminRoute') . '/all_schedules') }}" data-toggle="tooltip" data-placement="right" title="Back to All Schedules"><i class="fa fa-chevron-left"></i></a></li>
        <li class="active"><a role="tab" data-toggle="tab" class="active" href="#tab-general-info" data-target="#tab-info"><i class="fa fa-bars"></i> General Info</a></li>
        <li><a role="tab" data-toggle="tab" class="active" href="#tab-timeslots" data-target="#tab-timeslots"><i class="fa fa-bars"></i> Reservable Time Slots</a></li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active fade in" id="tab-info">
            <div class="tab-content">
                <div class="panel infolist">
                    <div class="panel-default panel-heading">
                        <h4>General Info</h4>
                    </div>
                    <div class="panel-body">
                        @la_display($module, 'schedule_name')
                        @la_display($module, 'start_on')
                        @la_display($module, 'no_of_days_visible')
                        @la_display($module, 'same_layout')
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane fade in" id="tab-timeslots">
            <div class="tab-content">
                <div class="panel infolist">
                    <div class="panel-default panel-heading">
                        <h4>Reservable Time Slots</h4>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            @if($module->row->same_layout == true)
                                <form method="post" action="{{ url(config('laraadmin.adminRoute') . '/save')}}" enctype="multipart/form-data" class="form-inline">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div id="staticSlots" class="col-xs-12">
                                        <textarea name="time_slots" id="time_slots" value="" style="background-color:  #fafafa ; height:350px; width:200px; padding-left:30px; padding-right: 30px; font-size: 15px;"><?php
                                            if(session()->exists('data') && session()->get('data') != null) {
                                                $val = session()->get('data');
                                                foreach ($val as $v) {
                                                    echo ($v['start'] . '-' . $v['end']);
                                                    echo "\n";
                                                }
                                            }
                                            ?>
                                        </textarea>
                                        <input type="hidden" id="schedule_id" name="schedule_id" value="{{$schedule_id}}">
                                    </div>
                                    <div class="slotWizard col-xs-12">
                                        <h5>
                                            Create slots every
                                            <input type='number' name="slots" min='0' step='15' value='30' id='quickLayoutConfig' size='5' title='Minutes' class='form-control input-sm'/>
                                            minutes between
                                            <input type='text' name="start" value='08:00' id='quickLayoutStart' size='10' title='From time' class='form-control input-sm' maxlength='5'/>
                                            and
                                            <input type='text' name="end" value='18:00' id='quickLayoutEnd' size='10' title='End time' class='form-control input-sm' maxlength='5'/>
                                            <button type="button" onclick="createSlot()" class="btn btn-xs btn-warning">+ Create</button>
                                        </h5>
                                    </div>
                                    <div class="slotHelpText col-xs-12">
                                        <p>Format: <span>HH:MM - HH:MM Optional Label</span></p>
                                        <p>Enter one slot per line.  Slots must be provided for all 24 hours of the day beginning and ending at 12:00 AM.</p>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="modal-footer">
                                        <input type="submit" class="btn btn-primary pull-left" value=" Update"/>
                                    </div>
                                </form>
                            @else
                                <div class="form-inline">
                                    <div role="tabpanel text-black">
                                        <ul id="tabs" style="width:700px;" class="nav nav-tabs" role="tablist">
                                            <?php $page_data = array(
                                            '2' => '<li role="presentation" class="active"><a style="color:black;" href="#tabs-0" aria-controls="tabs-0" role="tab"
                                            data-toggle="tab">Sunday</a></li>',
                                            '3' => '<li role="presentation" class="active"><a style="color:black;" href="#tabs-1" aria-controls="tabs-0" role="tab"
                                            data-toggle="tab">Monday</a></li>',
                                            '4' => '<li role="presentation"><a style="color:black;" href="#tabs-2" aria-controls="tabs-0" role="tab"
                                            data-toggle="tab">Tuesday</a></li>',
                                            '5' => '<li role="presentation"><a style="color:black;" href="#tabs-3" aria-controls="tabs-3" role="tab"
                                            data-toggle="tab">Wednesday</a></li>',
                                            '6' => '<li role="presentation"><a style="color:black;" href="#tabs-4" aria-controls="tabs-4" role="tab"
                                            data-toggle="tab">Thursday</a></li>',
                                            '7' => '<li role="presentation"><a style="color:black;" href="#tabs-5" aria-controls="tabs-5" role="tab"
                                            data-toggle="tab">Friday</a></li>',
                                            '8' => '<li role="presentation"><a style="color:black;" href="#tabs-6" aria-controls="tabs-6" role="tab"
                                            data-toggle="tab">Saturday</a></li>'
                                            );
                                            if($module->row['start_on'] && $module->row['no_of_days_visible']){
                                                print_r($page_data[$module->row['start_on']]);
                                                if($module->row['start_on'] == 8 && $module->row['no_of_days_visible'] > 1){
                                                    switch($module->row['no_of_days_visible']){
                                                        case 2:
                                                            print_r($page_data['2']);
                                                            break;
                                                        case 3:
                                                            print_r($page_data['2']);
                                                            print_r($page_data['3']);
                                                            break;
                                                        case 4:
                                                            print_r($page_data['2']);
                                                            print_r($page_data['3']);
                                                            print_r($page_data['4']);
                                                            break;
                                                        case 5:
                                                            print_r($page_data['2']);
                                                            print_r($page_data['3']);
                                                            print_r($page_data['4']);
                                                            print_r($page_data['5']);
                                                            break;
                                                        case 6:
                                                            print_r($page_data['2']);
                                                            print_r($page_data['3']);
                                                            print_r($page_data['4']);
                                                            print_r($page_data['5']);
                                                            print_r($page_data['6']);
                                                            break;
                                                        case 7:
                                                            print_r($page_data['2']);
                                                            print_r($page_data['3']);
                                                            print_r($page_data['4']);
                                                            print_r($page_data['5']);
                                                            print_r($page_data['6']);
                                                            print_r($page_data['7']);
                                                            break;
                                                    }
                                                }
                                                elseif($module->row['start_on'] == 7 && $module->row['no_of_days_visible'] > 2){
                                                    switch($module->row['no_of_days_visible']){
                                                        case 3:
                                                            print_r($page_data['8']);
                                                            print_r($page_data['2']);
                                                            break;
                                                        case 4:
                                                            print_r($page_data['8']);
                                                            print_r($page_data['2']);
                                                            print_r($page_data['3']);
                                                            break;
                                                        case 5:
                                                            print_r($page_data['8']);
                                                            print_r($page_data['2']);
                                                            print_r($page_data['3']);
                                                            print_r($page_data['4']);
                                                            
                                                            break;
                                                        case 6:
                                                            print_r($page_data['8']);
                                                            print_r($page_data['2']);
                                                            print_r($page_data['3']);
                                                            print_r($page_data['4']);
                                                            print_r($page_data['5']);
                                                            
                                                            break;
                                                        case 7:
                                                            print_r($page_data['8']);
                                                            print_r($page_data['2']);
                                                            print_r($page_data['3']);
                                                            print_r($page_data['4']);
                                                            print_r($page_data['5']);
                                                            print_r($page_data['6']);
                                                            
                                                            break;
                                                    }
                                                }
                                                elseif($module->row['start_on'] == 6 && $module->row['no_of_days_visible'] > 3){
                                                    switch($module->row['no_of_days_visible']){
                                                        case 4:
                                                            print_r($page_data['7']);
                                                            print_r($page_data['8']);
                                                            print_r($page_data['2']);
                                                            break;
                                                        case 5:
                                                            print_r($page_data['7']);
                                                            print_r($page_data['8']);
                                                            print_r($page_data['2']);
                                                            print_r($page_data['3']);
                                                            break;
                                                        case 6:
                                                            print_r($page_data['7']);
                                                            print_r($page_data['8']);
                                                            print_r($page_data['2']);
                                                            print_r($page_data['3']);
                                                            print_r($page_data['4']);
                                                            
                                                            break;
                                                        case 7:
                                                            print_r($page_data['7']);
                                                            print_r($page_data['8']);
                                                            print_r($page_data['2']);
                                                            print_r($page_data['3']);
                                                            print_r($page_data['4']);
                                                            print_r($page_data['5']);
                                                            
                                                            break;
                                                    }
                                                }
                                                elseif($module->row['start_on'] == 5 && $module->row['no_of_days_visible'] > 4){
                                                    switch($module->row['no_of_days_visible']){
                                                        case 5:
                                                            print_r($page_data['6']);
                                                            print_r($page_data['7']);
                                                            print_r($page_data['8']);
                                                            print_r($page_data['2']);
                                                            break;
                                                        case 6:
                                                            print_r($page_data['6']);
                                                            print_r($page_data['7']);
                                                            print_r($page_data['8']);
                                                            print_r($page_data['2']);
                                                            print_r($page_data['3']);
                                                            break;
                                                        case 7:
                                                            print_r($page_data['6']);
                                                            print_r($page_data['7']);
                                                            print_r($page_data['8']);
                                                            print_r($page_data['2']);
                                                            print_r($page_data['3']);
                                                            print_r($page_data['4']);
                                                            
                                                            break;
                                                    }
                                                }
                                                elseif($module->row['start_on'] == 4 && $module->row['no_of_days_visible'] > 5){
                                                    switch($module->row['no_of_days_visible']){
                                                        case 6:
                                                            print_r($page_data['5']);
                                                            print_r($page_data['6']);
                                                            print_r($page_data['7']);
                                                            print_r($page_data['8']);
                                                            print_r($page_data['2']);
                                                            
                                                            break;
                                                        case 7:
                                                            print_r($page_data['5']);
                                                            print_r($page_data['6']);
                                                            print_r($page_data['7']);
                                                            print_r($page_data['8']);
                                                            print_r($page_data['2']);
                                                            print_r($page_data['3']);
                                                            
                                                            break;
                                                    
                                                    }
                                                }
                                                elseif($module->row['start_on'] == 3 && $module->row['no_of_days_visible'] > 6){
                                                    switch($module->row['no_of_days_visible']){
                                                    
                                                        case 7:
                                                        print_r($page_data['4']);
                                                        print_r($page_data['5']);
                                                        print_r($page_data['6']);
                                                        print_r($page_data['7']);
                                                        print_r($page_data['8']);
                                                        print_r($page_data['2']);
                                                        
                                                        break;
                                                    }
                                                }
                                                else{
                                                    for ($i = 0; $i < $module->row['no_of_days_visible']-1 ; $i++) {
                                                        print_r($page_data[$module->row['start_on'] + $i + 1]);
                                                    }
                                                }
                                            }
                                            ?>
                                        </ul>

                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane" id="tabs-0">
                                                <div id="1" class="col-xs-12">
                                                    <div class="col-xs-6">
                                                        <textarea name="time_slots" id="time_slots_0" style="background-color:  #fafafa ; height:350px; width:200px; padding-left:30px; padding-right: 30px; font-size: 15px;">
                                                        <?php
                                                        if(session()->exists('data_0') && session()->get('data_0') != null) {
                                                            $val = session()->get('data_0');
                                                            foreach ($val as $v) {
                                                                echo ($v['start'] . '-' . $v['end']);
                                                                echo "\n";
                                                            }
                                                        }
                                                        ?>
                                                        </textarea>
                                                        <div class="container">
                                                                <h5>
                                                                Create slots every
                                                                <input type='number' name="slots_0" min='0' step='15' value='30' id='quickLayoutConfig_0' size='5' title='Minutes' class='form-control'/>
                                                                minutes between
                                                                <input type='text' name="start_0" value='08:00' id='quickLayoutStart_0' size='10' title='From time' class='form-control' maxlength='5'/>
                                                                and
                                                                <input type='text' name="end_0" value='18:00' id='quickLayoutEnd_0' size='10' title='End time' class='form-control' maxlength='5'/>
                                                                <button type="button" class="btn btn-xs btn-warning" onclick="createSlot_Number(0)">+ Create</button>
                                                                </h5>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="tabs-1">
                                                <div id="1" class="col-xs-12">
                                                    <div class="col-xs-6">
                                                        <textarea name="time_slots" id="time_slots_1" style="background-color:  #fafafa ; height:350px; width:200px; padding-left:30px; padding-right: 30px; font-size: 15px;">
                                                        <?php
                                                        if(session()->exists('data_1') && session()->get('data_1') != null) {
                                                            $val = session()->get('data_1');
                                                            foreach ($val as $v) {
                                                                echo($v['start'] . '-' . $v['end']);
                                                                echo "\n";
                                                            }
                                                        }
                                                        ?>
                                                        </textarea>
                                                        <div class="container">
                                                                <h5>
                                                                Create slots every
                                                                <input type='number' name="slots_1" min='0' step='15' value='30' id='quickLayoutConfig_1' size='5' title='Minutes' class='form-control'/>
                                                                minutes between
                                                                <input type='text' name="start_1" value='08:00' id='quickLayoutStart_1' size='10' title='From time' class='form-control' maxlength='5'/>
                                                                and
                                                                <input type='text' name="end_1" value='18:00' id='quickLayoutEnd_1' size='10' title='End time' class='form-control' maxlength='5'/>
                                                                <button type="button" onclick="createSlot_Number(1)" class="btn btn-xs btn-warning">+ Create</button>
                                                                </h5>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="tabs-2">
                                                <div id="1" class="col-xs-12">
                                                    <div class="col-xs-6">
                                                        <textarea name="time_slots" id="time_slots_2" style="background-color:  #fafafa ; height:350px; width:200px; padding-left:30px; padding-right: 30px; font-size: 15px;">
                                                        <?php
                                                        if(session()->exists('data_2') && session()->get('data_2') != null) {
                                                            $val = session()->get('data_2');
                                                            foreach ($val as $v) {
                                                                print_r($v['start'] . '-' . $v['end']);
                                                                echo "\n";
                                                            }
                                                        }
                                                        ?>
                                                        </textarea>
                                                        <div class="container">
                                                                <h5>
                                                                Create slots every
                                                                <input type='number' name="slots_2" min='0' step='15' value='30' id='quickLayoutConfig_2' size='5' title='Minutes' class='form-control'/>
                                                                minutes between
                                                                <input type='text' name="start_2" value='08:00' id='quickLayoutStart_2' size='10' title='From time' class='form-control' maxlength='5'/>
                                                                and
                                                                <input type='text' name="end_2" value='18:00' id='quickLayoutEnd_2' size='10' title='End time' class='form-control' maxlength='5'/>
                                                                <button type="button" onclick="createSlot_Number(2)" class="btn btn-xs btn-warning">+ Create</button>
                                                                </h5>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="tabs-3">
                                                <div id="1" class="col-xs-12">
                                                    <div class="col-xs-6">
                                                        <textarea name="time_slots" id="time_slots_3" style="background-color:  #fafafa ; height:350px; width:200px; padding-left:30px; padding-right: 30px; font-size: 15px;">
                                                        <?php
                                                        if(session()->exists('data_3') && session()->get('data_3') != null) {
                                                            $val = session()->get('data_3');
                                                            foreach ($val as $v) {
                                                                print_r($v['start'] . '-' . $v['end']);
                                                                echo "\n";
                                                            }
                                                        }
                                                        ?>
                                                        </textarea>
                                                        <div class="container">
                                                                <h5>
                                                                Create slots every
                                                                <input type='number' name="slots_3" min='0' step='15' value='30' id='quickLayoutConfig_3' size='5' title='Minutes' class='form-control'/>
                                                                minutes between
                                                                <input type='text' name="start_3" value='08:00' id='quickLayoutStart_3' size='10' title='From time' class='form-control' maxlength='5'/>
                                                                and
                                                                <input type='text' name="end_3" value='18:00' id='quickLayoutEnd_3' size='10' title='End time' class='form-control' maxlength='5'/>
                                                                <button type="button" onclick="createSlot_Number(3)" class="btn btn-xs btn-warning">+ Create</button>
                                                                </h5>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="tabs-4">
                                                <div id="1" class="col-xs-12">
                                                    <div class="col-xs-6">
                                                        <textarea name="time_slots" id="time_slots_4" style="background-color:  #fafafa ; height:350px; width:200px; padding-left:30px; padding-right: 30px; font-size: 15px;">
                                                        <?php
                                                        if(session()->exists('data_4') && session()->get('data_4') != null) {
                                                            $val = session()->get('data_4');
                                                            foreach ($val as $v) {
                                                                print_r($v['start'] . '-' . $v['end']);
                                                                echo "\n";
                                                            }
                                                        }
                                                        ?>
                                                        </textarea>
                                                        <div class="container">
                                                                <h5>
                                                                Create slots every
                                                                <input type='number' name="slots_4" min='0' step='15' value='30' id='quickLayoutConfig_4' size='5' title='Minutes' class='form-control'/>
                                                                minutes between
                                                                <input type='text' name="start_4" value='08:00' id='quickLayoutStart_4' size='10' title='From time' class='form-control' maxlength='5'/>
                                                                and
                                                                <input type='text' name="end_4" value='18:00' id='quickLayoutEnd_4' size='10' title='End time' class='form-control' maxlength='5'/>
                                                                <button type="button" onclick="createSlot_Number(4)" class="btn btn-xs btn-warning">+ Create</button>
                                                                </h5>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="tabs-5">
                                                <div id="1" class="col-xs-12">
                                                    <div class="col-xs-6">
                                                        <textarea name="time_slots" id="time_slots_f" style="background-color:  #fafafa ; height:350px; width:200px; padding-left:30px; padding-right: 30px; font-size: 15px;">
                                                        <?php
                                                        if(session()->exists('data_f') && session()->get('data_f') != null) {
                                                            $val = session()->get('data_f');
                                                            foreach ($val as $v) {
                                                                print_r($v['start'] . '-' . $v['end']);
                                                                echo "\n";
                                                            }
                                                        }
                                                        ?>
                                                        </textarea>
                                                        <div class="container">
                                                                <h5>
                                                                Create slots every
                                                                <input type='number' name="slots_f" min='0' step='15' value='30' id='quickLayoutConfig_f' size='5' title='Minutes' class='form-control'/>
                                                                minutes between
                                                                <input type='text' name="start_f" value='08:00' id='quickLayoutStart_f' size='10' title='From time' class='form-control' maxlength='5'/>
                                                                and
                                                                <input type='text' name="end_f" value='18:00' id='quickLayoutEnd_f' size='10' title='End time' class='form-control' maxlength='5'/>
                                                                <button type="button" onclick="createSlot_Number('f')" class="btn btn-xs btn-warning">+ Create</button>
                                                                </h5>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="tabs-6">
                                                <div id="1" class="col-xs-12">
                                                    <div class="col-xs-6">
                                                        <textarea name="time_slots" id="time_slots_6" style="background-color:  #fafafa ; height:350px; width:200px; padding-left:30px; padding-right: 30px; font-size: 15px;">
                                                        <?php
                                                        if(session()->exists('data_6') && session()->get('data_6') != null) {
                                                            $val = session()->get('data_6');
                                                            foreach ($val as $v) {
                                                                print_r($v['start'] . '-' . $v['end']);
                                                                echo "\n";
                                                            }
                                                        }
                                                        ?>
                                                        
                                                        </textarea>
                                                        <div class="container">
                                                                <h5>
                                                                Create slots every
                                                                <input type='number' name="slots_6" min='0' step='15' value='30' id='quickLayoutConfig_6' size='5' title='Minutes' class='form-control'/>
                                                                minutes between
                                                                <input type='text' name="start_6" value='08:00' id='quickLayoutStart_6' size='10' title='From time' class='form-control' maxlength='5'/>
                                                                and
                                                                <input type='text' name="end_6" value='18:00' id='quickLayoutEnd_6' size='10' title='End time' class='form-control' maxlength='5'/>
                                                                <button type="button" onclick="createSlot_Number(6)" class="btn btn-xs btn-warning">+ Create</button>
                                                                </h5>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="slotHelpText col-xs-12">
                                        <p>Format: <span>HH:MM - HH:MM Optional Label</span></p>
                                        <p>Enter one slot per line.  Slots must be provided for all 24 hours of the day beginning and ending at 12:00 AM.</p>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="modal-footer">
                                        <form method="post" action="{{ url(config('laraadmin.adminRoute') . '/save_0')}}" enctype="multipart/form-data" class="form-inline">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" id="schedule_id" name="schedule_id" value="{{$schedule_id}}">
                                            <input type="submit" class="btn btn-primary pull-left" value=" Update"/>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>  
                    </div>
                </div>
            </div>
        </div>        
    </div>
</div>

@endsection
@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/mine.css') }}"/>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
<style>
  #feedback { font-size: 1.4em; }
  #custom-table .ui-selecting { background: #FECA40; }
  #custom-table .ui-selected { background: #F39814; color: white; }
  #custom-table { list-style-type: none; margin: 0; padding: 0; width: 60%; }
  #custom-table td { margin: 3px; padding: 0.4em; height: 50px; }
  </style>
@endpush
@push('scripts')
<script src="{{ asset('la-assets/mine.js') }}"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
        $('.acinput').hide();
        $('.acces').click(function(){
            $('.acinput').show();
        })
    });
      $(function() {
        
        $("tr").selectable();   
        $("tr").click(function(){
        $("#ok").show();
        var array = $(".ui-selected").map(function() {
        return [$.map($(this).data(), function(v) {
            return v;
        })];
        }).get();
        console.log(array);

        var id = $(".ui-selected").map(function() {
        return $(this).data('id');
        }).get();
        //console.log(id);


        var begin = $(".ui-selected").map(function() {
        return $(this).data('date');
        }).get();
        //console.log(begin);
        $("#begin").val(begin[0]);
        
        $.each(array, function(j, v) 
        {
            //console.log(v[2]);   
            $('#end').val(v[2]);                    
        });
     });




   }); 
</script>
<script type="text/javascript">
    function createSlot(){
        var slots = $("#quickLayoutConfig").val();
        var start = $("#quickLayoutStart").val();
        var end = $("#quickLayoutEnd").val();
        var schedule_id = $("#schedule_id").val();

        $.ajax({
            dataType: 'json',
            url : "{{ url(config('laraadmin.adminRoute') . '/store_data') }}",
            type: 'POST',
            data : {'_token': '{{ csrf_token() }}', 'slots' : slots, 'start' : start, 'end' : end, 'schedule_id' : schedule_id},
            success: function ( json ) {
                // console.log(json);
                // location.reload();
                var json = json.data;
                var result = "";
                for (var i = 0 ; i < json.length; i++) {
                    result += json[i].start + "-" + json[i].end + "\n";
                }
                $("textarea#time_slots").val(result);

            }
        });
    }
    function createSlot_Number(num){
        var slots = $("#quickLayoutConfig_" + num).val();
        var start = $("#quickLayoutStart_" + num).val();
        var end = $("#quickLayoutEnd_" + num).val();
        var schedule_id = $("#schedule_id").val();

        $.ajax({
            dataType: 'json',
            url : "{{ url(config('laraadmin.adminRoute') . '/store_data_num') }}",
            type: 'POST',
            data : {'_token': '{{ csrf_token() }}', 'slots' : slots, 'start' : start, 'end' : end, 'schedule_id' : schedule_id, 'num' : num},
            success: function ( json ) {
                var json = json.data;
                var result = "";
                for (var i = 0 ; i < json.length; i++) {
                    result += json[i].start + "-" + json[i].end + "\n";
                }
                $("textarea#time_slots_" + num).val(result);
            }
        });
    }
</script>
@endpush

