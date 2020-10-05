@extends('la.layouts.app')
@section('htmlheader_title')
Reservations View
@endsection
@section('main-content')
<div id="page-content" class="profile2">
    
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active fade in" id="tab-info">
            <div class="tab-content">
                <div class="panel infolist">
                    <div class="panel-default panel-heading">
                        <h4>Bookings</h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-group col-sm-12">
                            <div class="col-sm-6">
                                <form method="post" action="{{ url(config('laraadmin.adminRoute') . '/reservations/previous')}}" enctype="multipart/form-data" class="form-inline">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" class="scheduleid" name="schedule_id" value="{{$scheduleid}}">
                                    <input type="hidden" name="week" value="{{json_encode($week)}}">
                                    <button type="submit" class="btn btn-info previous" value="Previous">Previous</button>
                                </form>
                                <span class="startdate"></span>
                                <span>/</span>
                                <span class="enddate"></span>
                                <form method="post" action="{{ url(config('laraadmin.adminRoute') . '/reservations/next')}}" enctype="multipart/form-data" class="form-inline">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" class="scheduleid" name="schedule_id" value="{{$scheduleid}}">
                                    <input type="hidden" name="week" value="{{json_encode($week)}}">
                                    <button type="submit" class="btn btn-info next" value="Next" >Next</button>
                                </form>
                            </div>
                            <div class="col-sm-6">
                                <button type="button" class="btn btn-primary addreservation pull-right" data-toggle="modal" data-target-id="2" data-target="#AddNewBooking">Add Reservation</button>
                            </div>
                        </div>
                    <div>
                    <table id="custom-table">
                        <thead>
                            <?php

                            if($module->row['same_layout']){
                                $for_same_day = DB::table('slot_ones')
                                    ->select('*')
                                    ->where('schedule_id', $scheduleid)
                                    ->orderBy('created_at', 'desc')
                                    ->first();
                            }else{
                                $for_same_day = DB::table('slot_zeros')
                                    ->select('*')
                                    ->where('schedule_id', $scheduleid)
                                    ->orderBy('created_at', 'desc')
                                    ->first();
                            }
                                
                            if($module->row['start_on'] == 8 && $module->row['no_of_days_visible'] > 1){
                                switch($module->row['no_of_days_visible']){
                                    case 1:
                                        if($module->row['same_layout'])
                                        $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_6);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='saturday' data-sat=5></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>" . $res['start'] . "</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                    echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sat dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 2:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_6);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='saturday' data-sat=5></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>" . $res['start'] . "</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                    echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sat dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_0);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='sunday' data-sun=6></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                foreach ($result as $res) {
                                                echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sun dates {$data_resource->id}'></td>";
                                                }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 3:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_6);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='saturday' data-sat=5></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                foreach ($result as $res) {
                                                    echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sat dates {$data_resource->id}'></td>";
                                                }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_0);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='sunday' data-sun=6></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sun dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_1);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='monday' data-day=0></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        $variable = str_replace( ['\'', '"', ',' , ';', '<', '>' ], ' ', $res['start']);
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} data-mondaycolor='' class='slots dates {$data_resource->id} mondaycolor {$res['start']}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 4:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_6);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='saturday' data-sat=5></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sat dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_0);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='sunday' data-sun=6></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sun dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_1);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='monday' data-day=0></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} data-mondaycolor='' class='slots dates {$data_resource->id} mondaycolor {$res['start']}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_2);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='tuesday' data-tue=1></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots tuesdaycolor dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 5:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_6);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='saturday' data-sat=5></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sat dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_0);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='sunday' data-sun=6></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sun dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_1);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='monday' data-day=0></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} data-mondaycolor='' class='slots dates {$data_resource->id} mondaycolor {$res['start']}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_2);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='tuesday' data-tue=1></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots tuesdaycolor dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_3);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='wednesday' data-wed=2></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots wed dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 6:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_6);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='saturday' data-sat=5></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sat dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_0);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='sunday' data-sun=6></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sun dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_1);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='monday' data-day=0></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} data-mondaycolor='' class='slots dates {$data_resource->id} mondaycolor {$res['start']}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_2);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='tuesday' data-tue=1></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots tuesdaycolor dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_3);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='wednesday' data-wed=2></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots wed dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_4);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='thursday' data-thu=3></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots thu dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 7:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_6);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='saturday' data-sat=5></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sat dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_0);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='sunday' data-sun=6></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sun dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_1);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='monday' data-day=0></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} data-mondaycolor='' class='slots dates {$data_resource->id} mondaycolor {$res['start']}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_2);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='tuesday' data-tue=1></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots tuesdaycolor dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_3);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='wednesday' data-wed=2></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots wed dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_4);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='thursday' data-thu=3></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots thu dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_5);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='friday' data-fri=4></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots fri dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;                                    
                                }
                            }elseif($module->row['start_on'] == 7 && $module->row['no_of_days_visible'] > 1){
                                switch($module->row['no_of_days_visible']){
                                    case 1:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_5);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='friday' data-fri=4></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots fri dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 2:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_5);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='friday' data-fri=4></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots fri dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_6);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='saturday' data-sat=5></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sat dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 3:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_5);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='friday' data-fri=4></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots fri dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_6);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='saturday' data-sat=5></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sat dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_0);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='sunday' data-sun=6></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sun dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 4:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_5);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='friday' data-fri=4></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots fri dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_6);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='saturday' data-sat=5></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sat dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_0);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='sunday' data-sun=6></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sun dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_1);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='monday' data-day=0></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} data-mondaycolor='' class='slots dates {$data_resource->id} mondaycolor {$res['start']}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 5:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_5);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='friday' data-fri=4></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots fri dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_6);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='saturday' data-sat=5></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']}} lass='res'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_0);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='sunday' data-sun=6></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sun dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_1);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='monday' data-day=0></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} data-mondaycolor='' class='slots dates {$data_resource->id} mondaycolor {$res['start']}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_2);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='tuesday' data-tue=1></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots tuesdaycolor dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 6:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_5);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='friday' data-fri=4></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots fri dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_6);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='saturday' data-sat=5></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sat dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_0);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='sunday' data-sun=6></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sun dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_1);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='monday' data-day=0></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} data-mondaycolor='' class='slots dates {$data_resource->id} mondaycolor {$res['start']}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_2);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='tuesday' data-tue=1></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots tuesdaycolor dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_3);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='wednesday' data-wed=2></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots wed dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 7:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_5);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='friday' data-fri=4></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots fri dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_6);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='saturday' data-sat=5></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sat dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_0);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='sunday' data-sun=6></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sun dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_1);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='monday' data-day=0></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} data-mondaycolor='' class='slots dates {$data_resource->id} mondaycolor {$res['start']}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_2);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='tuesday' data-tue=1></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots tuesdaycolor dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_3);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='wednesday' data-wed=2></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots wed dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_4);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='thursday' data-thu=3></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots thu dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                }
                            }elseif($module->row['start_on'] == 6 && $module->row['no_of_days_visible'] > 1){
                                switch($module->row['no_of_days_visible']){
                                    case 1:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_4);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='thursday' data-thu=3></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots thu dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 2:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_4);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='thursday' data-thu=3></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots thu dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_5);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='friday' data-fri=4></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots fri dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 3:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_4);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='thursday' data-thu=3></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots thu dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_5);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='friday' data-fri=4></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots fri dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_6);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='saturday' data-sat=5></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sat dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 4:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_4);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='thursday' data-thu=3></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots thu dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_5);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='friday' data-fri=4></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots fri dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_6);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='saturday' data-sat=5></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sat dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_0);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='sunday' data-sun=6></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sun dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 5:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_4);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='thursday' data-thu=3></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots thu dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_5);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='friday' data-fri=4></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots fri dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_6);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='saturday' data-sat=5></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sat dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_0);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='sunday' data-sun=6></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sun dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_1);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='monday' data-day=0></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} data-mondaycolor='' class='slots dates {$data_resource->id} mondaycolor {$res['start']}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 6:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_4);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='thursday' data-thu=3></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots thu dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_5);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='friday' data-fri=4></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots fri dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_6);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='saturday' data-sat=5></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sat dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_0);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='sunday' data-sun=6></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sun dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_1);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='monday' data-day=0></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} data-mondaycolor='' class='slots dates {$data_resource->id} mondaycolor {$res['start']}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_2);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='tuesday' data-tue=1></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots tuesdaycolor dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 7:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_4);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='thursday' data-thu=3></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots thu dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_5);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='friday' data-fri=4></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots fri dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_6);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='saturday' data-sat=5></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sat dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_0);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='sunday' data-sun=6></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sun dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_1);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='monday' data-day=0></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} data-mondaycolor='' class='slots dates {$data_resource->id} mondaycolor {$res['start']}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_2);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='tuesday' data-tue=1></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots tuesdaycolor dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_3);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='wednesday' data-wed=2></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots wed dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                }
                            }elseif($module->row['start_on'] == 5 && $module->row['no_of_days_visible'] > 1){
                                switch($module->row['no_of_days_visible']){
                                    case 1:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_3);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='wednesday' data-wed=2></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots wed dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 2:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_3);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='wednesday' data-wed=2></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots wed dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_4);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='thursday' data-thu=3></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots thu dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 3:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_3);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='wednesday' data-wed=2></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots wed dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_4);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='thursday' data-thu=3></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots thu dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_5);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='friday' data-fri=4></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots fri dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 4:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_3);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='wednesday' data-wed=2></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots wed dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_4);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='thursday' data-thu=3></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots thu dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_5);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='friday' data-fri=4></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots fri dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_6);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='saturday' data-sat=5></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sat dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 5:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_3);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='wednesday' data-wed=2></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots wed dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_4);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='thursday' data-thu=3></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots thu dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_5);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='friday' data-fri=4></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots fri dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_6);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='saturday' data-sat=5></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sat dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_0);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='sunday' data-sun=6></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sun dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 6:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_3);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='wednesday' data-wed=2></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                    echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots wed dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_4);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='thursday' data-thu=3></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots thu dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_5);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='friday' data-fri=4></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots fri dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_6);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='saturday' data-sat=5></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sat dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_0);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='sunday' data-sun=6></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sun dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_1);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='monday' data-day=0></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} data-mondaycolor='' class='slots dates {$data_resource->id} mondaycolor {$res['start']}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 7:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_3);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='wednesday' data-wed=2></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots wed dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_4);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='thursday' data-thu=3></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots thu dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_5);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='friday' data-fri=4></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots fri dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_6);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='saturday' data-sat=5></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sat dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_0);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='sunday' data-sun=6></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sun dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_1);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='monday' data-day=0></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} data-mondaycolor='' class='slots dates {$data_resource->id} mondaycolor {$res['start']}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_2);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='tuesday' data-tue=1></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                     echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots tuesdaycolor dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                }
                            }elseif($module->row['start_on'] == 4 && $module->row['no_of_days_visible'] > 1){
                                switch($module->row['no_of_days_visible']){
                                    case 1:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_2);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='tuesday' data-tue=1></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots tuesdaycolor dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 2:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_2);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='tuesday' data-tue=1></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots tuesdaycolor dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_3);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='wednesday' data-wed=2></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots wed dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 3:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_2);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='tuesday' data-tue=1></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots tuesdaycolor dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_3);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='wednesday' data-wed=2></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots wed dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_4);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='thursday' data-thu=3></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots thu dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 4:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_2);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='tuesday' data-tue=1></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots tuesdaycolor dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_3);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='wednesday' data-wed=2></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots wed dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_4);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='thursday' data-thu=3></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots thu dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_5);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='friday' data-fri=4></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots fri dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 5:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_2);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='tuesday' data-tue=1></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots tuesdaycolor dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_3);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='wednesday' data-wed=2></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots wed dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_4);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='thursday' data-thu=3></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots thu dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_5);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='friday' data-fri=4></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots fri dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_6);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='saturday' data-sat=5></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sat dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 6:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_2);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='tuesday' data-tue=1></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots tuesdaycolor dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_3);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='wednesday' data-wed=2></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots wed dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_4);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='thursday' data-thu=3></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots thu dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_5);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='friday' data-fri=4></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots fri dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_6);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='saturday' data-sat=5></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sat dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_0);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='sunday' data-sun=6></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sun dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 7:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_2);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='tuesday' data-tue=1></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots tuesdaycolor dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_3);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='wednesday' data-wed=2></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots wed dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_4);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='thursday' data-thu=3></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots thu dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_5);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='friday' data-fri=4></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots fri dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_6);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='saturday' data-sat=5></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sat dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_0);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='sunday' data-sun=6></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sun dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_1);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='monday' data-day=0></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} data-mondaycolor='' class='slots dates {$data_resource->id} mondaycolor {$res['start']}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                }
                            }elseif($module->row['start_on'] == 3 && $module->row['no_of_days_visible'] > 1){
                                switch($module->row['no_of_days_visible']){
                                    case 1:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_1);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='monday' data-day=0></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} data-mondaycolor='' class='slots dates {$data_resource->id} mondaycolor {$res['start']}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 2:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_1);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='monday' data-day=0></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} data-mondaycolor='' class='slots dates {$data_resource->id} mondaycolor {$res['start']}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_2);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='tuesday' data-tue=1></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots tuesdaycolor dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 3:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_1);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='monday' data-day=0></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} data-mondaycolor='' class='slots dates {$data_resource->id} mondaycolor {$res['start']}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_2);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='tuesday' data-tue=1></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots tuesdaycolor dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_3);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='wednesday' data-wed=2></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots wed dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 4:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_1);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='monday' data-day=0></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} data-mondaycolor='' class='slots dates {$data_resource->id} mondaycolor {$res['start']}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_2);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='tuesday' data-tue=1></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots tuesdaycolor dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_3);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='wednesday' data-wed=2></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots wed dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_4);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='thursday' data-thu=3></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots thu dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 5:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_1);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='monday' data-day=0></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} data-mondaycolor='' class='slots dates {$data_resource->id} mondaycolor {$res['start']}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_2);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='tuesday' data-tue=1></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots tuesdaycolor dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_3);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='wednesday' data-wed=2></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots wed dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_4);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='thursday' data-thu=3></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots thu dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_5);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='friday' data-fri=4></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots fri dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 6:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_1);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='monday' data-day=0></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} data-mondaycolor='' class='slots dates {$data_resource->id} mondaycolor {$res['start']}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_2);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='tuesday' data-tue=1></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots tuesdaycolor dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_3);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='wednesday' data-wed=2></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots wed dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_4);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='thursday' data-thu=3></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots thu dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_5);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='friday' data-fri=4></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots fri dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_6);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='saturday' data-sat=5></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sat dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    break;
                                    case 7:
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_1);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='monday' data-day=0></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} data-mondaycolor='' class='slots dates {$data_resource->id} mondaycolor {$res['start']}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_2);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='tuesday' data-tue=1></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots tuesdaycolor dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_3);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='wednesday' data-wed=2></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots wed dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_4);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='thursday' data-thu=3></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots thu dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_5);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='friday' data-fri=4></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots fri dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_6);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='saturday' data-sat=5></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sat dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                        if($module->row['same_layout'])
                                            $result = unserialize($for_same_day->time_slot);
                                        else
                                            $result = unserialize($for_same_day->time_slot_0);
                                        if (!empty($result)) {
                                            echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='sunday' data-sun=6></th> ";
                                            foreach ($result as $res) {
                                                echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                            }
                                            echo "</tr>";
                                            foreach ($data_resources as $data_resource) {
                                                echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                                    foreach ($result as $res) {
                                                        echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sun dates {$data_resource->id}'></td>";
                                                    }
                                                echo "</tr>";
                                            }
                                        }
                                    
                                    break;
                                }
                            }elseif(isset($for_same_day)){
                                if($module->row['same_layout'])
                                    $result = unserialize($for_same_day->time_slot);
                                else
                                    $result = unserialize($for_same_day->time_slot_0);
                                if (!empty($result)) {
                                    echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='sunday' data-sun=6></th> ";
                                    foreach ($result as $res) {
                                        echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                    }
                                    echo "</tr>";
                                    foreach ($data_resources as $data_resource) {
                                        echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                            foreach ($result as $res) {
                                                echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sun dates {$data_resource->id}'></td>";
                                            }
                                        echo "</tr>";
                                    }
                                }
                                if($module->row['same_layout'])
                                    $result = unserialize($for_same_day->time_slot);
                                else
                                    $result = unserialize($for_same_day->time_slot_1);
                                if (!empty($result)) {
                                    echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='monday' data-day=0></th> ";
                                    foreach ($result as $res) {
                                        echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                    }
                                    echo "</tr>";
                                    foreach ($data_resources as $data_resource) {
                                        echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                            foreach ($result as $res) {
                                                echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} data-mondaycolor='' class='slots dates {$data_resource->id} mondaycolor {$res['start']}'></td>";
                                            }
                                        echo "</tr>";
                                    }
                                }
                                if($module->row['same_layout'])
                                    $result = unserialize($for_same_day->time_slot);
                                else
                                    $result = unserialize($for_same_day->time_slot_2);
                                if (!empty($result)) {
                                    echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='tuesday' data-tue=1></th> ";
                                    foreach ($result as $res) {
                                        echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                    }
                                    echo "</tr>";
                                    foreach ($data_resources as $data_resource) {
                                        echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                            foreach ($result as $res) {
                                                echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots tuesdaycolor dates {$data_resource->id}'></td>";
                                            }
                                        echo "</tr>";
                                    }
                                }
                                if($module->row['same_layout'])
                                    $result = unserialize($for_same_day->time_slot);
                                else
                                    $result = unserialize($for_same_day->time_slot_3);
                                if (!empty($result)) {
                                    echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='wednesday' data-wed=2></th> ";
                                    foreach ($result as $res) {
                                        echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                    }
                                    echo "</tr>";
                                    foreach ($data_resources as $data_resource) {
                                        echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                            foreach ($result as $res) {
                                                echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots wed dates {$data_resource->id}'></td>";
                                            }
                                        echo "</tr>";
                                    }
                                }
                                if($module->row['same_layout'])
                                    $result = unserialize($for_same_day->time_slot);
                                else
                                    $result = unserialize($for_same_day->time_slot_4);
                                if (!empty($result)) {
                                    echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='thursday' data-thu=3></th> ";
                                    foreach ($result as $res) {
                                        echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                    }
                                    echo "</tr>";
                                    foreach ($data_resources as $data_resource) {
                                        echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                            foreach ($result as $res) {
                                                echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots thu dates {$data_resource->id}'></td>";
                                            }
                                        echo "</tr>";
                                    }
                                }
                                if($module->row['same_layout'])
                                    $result = unserialize($for_same_day->time_slot);
                                else
                                    $result = unserialize($for_same_day->time_slot_5);
                                if (!empty($result)) {
                                    echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='friday' data-fri=4></th> ";
                                    foreach ($result as $res) {
                                        echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                    }
                                    echo "</tr>";
                                    foreach ($data_resources as $data_resource) {
                                        echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                            foreach ($result as $res) {
                                                echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots fri dates {$data_resource->id}'></td>";
                                            }
                                        echo "</tr>";
                                    }
                                }
                                if($module->row['same_layout'])
                                    $result = unserialize($for_same_day->time_slot);
                                else
                                    $result = unserialize($for_same_day->time_slot_6);
                                if (!empty($result)) {
                                    echo "<tr class='ui-widget-content'><th class='resdate days px-5' id='saturday' data-sat=5></th> ";
                                    foreach ($result as $res) {
                                        echo "<td class='reslabel'>".$res['start'].'&nbsp;'."</td>";
                                    }
                                    echo "</tr>";
                                    foreach ($data_resources as $data_resource) {
                                        echo "<tr data-id={$data_resource->id} class='ui-widget-content'><th>".$data_resource->name."</th>";
                                            foreach ($result as $res) {
                                                echo "<td data-id='' data-resourceid={$data_resource->id} data-date={$res['start']} class='slots sat dates {$data_resource->id}'></td>";
                                            }
                                        echo "</tr>";
                                    }
                                }
                            }
                        ?>
                        </thead> 
                    </table>
                </div>

                <!-- hidden div -->
                <div>
                    @foreach($reservation as $reservations)
                        <input type="hidden" class="begindate" value="{{$reservations->begin_date}}">
                        <input type="hidden" class="begintime" value="{{$reservations->begin_time}}">
                        <input type="hidden" class="resource" value="{{$reservations->resource_id}}">
                    @endforeach
                </div>
                  
            </div>  
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="AddNewBooking" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Reservation</h5>
            </div>
            <div class="modal-body">
                <div id="ok" class="container-fluid">
                    {!! Form::open(['action' => 'LA\ReservationsController@store', 'id' => 'new_reservation_form']) !!}
                        <input type="hidden" value="{{ Auth::user()->id }}" name="owner_id">
                        <input type="hidden" id="selected_booking_id" name="schedule_id" value = "{{$scheduleid}}" class="form-control input-sm" >
                        <input type="hidden" name="week" value="{{json_encode($week)}}">
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label class="control-label">Resource</label>                
                                <select class="js-example-basic-multiple form-control" onchange="checkAvailable(); getAccessoriesByResource(this.value);" id="resource" name="resource" required>
                                    <option selected disabled>Choose Resource</option>
                                    @foreach($data_resources as $resources)
                                        <option value="{{$resources->id}}">
                                            {{$resources->name}}</span> - Number of maximum people
                                            ({{$resources->no_of_maximum_people}})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <input type="hidden" id="scheduleid" value="{{$scheduleid}}">
                        <div class="row form-group">
                            <div class="col-md-6" >
                                <span id="errormsg" style="color: red; display: none;">Resource is not available for that time!</span>
                                <label for="inputEmail4">Begin : <span style="color: red;">*</span></label>
                                <div class="row">
                                    <div class="col-md-6" >
                                        <input type="date" id="begindate" name="begin_date" required class="form-control input-sm" value="" onchange="checkRequestDate(); getTheDays({{$module->row['same_layout']}});" required> 
                                    </div>
                                    <div class="col-md-6">
                                        <select name="begin_time" id="begintime" onchange="checkAvailable();" value="" class="form-control input-sm times"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail4">End : <span style="color: red;">*</span></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="date" id="enddate" name="end_date" class="form-control input-sm" value="" onchange="checkRequestDate(); getTheEndDays({{$module->row['same_layout']}});" required>
                                    </div>
                                    <div class="col-md-6">
                                        <select name="end_time" id="end_time" onchange="checkAvailable()" class="form-control input-sm times"></select>
                                    </div>
                                </div>                  
                            </div>
                        </div>
                        <div class="resvalid" style="display:none;">
                        
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4" id="title">Title : <span style="color: red">*</span></label>
                                <input type="text" required class="form-control input-sm" id="" name="title">
                            </div>
                            <div class="form-group col-md-6">
                                <label id="description">Description : </label>
                                <textarea cols="30" rows="2" class="form-control input-sm" name="description"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label">Participants : </label>                
                                <select class="js-example-basic-multiple form-control input-sm" name="user_id[]" multiple="multiple">
                                    @foreach($user as $users)
                                        @if($users->id != 1)
                                        <option value="{{$users->id}}">{{$users->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Number of Participant</label>
                                <input type="number" class="form-control input-sm" name="no_of_participant" value=0>     
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Invitees(comma(,) separted for each mail) :</label>
                                <input type="text" class="form-control input-sm" name="invitees">
                            </div>
                            <?php $room_types = App\Models\Room_Type::all(); ?>
                            @foreach($image as $rooms)
                                <input type="hidden" value="{{$rooms->id}}" >
                            @endforeach
                            <div id="room_type_div" style="display: none;">
                                <div class="dropdown form-group col-md-6" >
                                    <label>Room Type :</label>
                                    <select class="form-control" id="slick" name="room_type_id" onchange="getImageID(this.value);">
                                    <option selected disabled>Choose Room Type</option>
                                    @foreach($image as $rooms)
                                        <option value="{{$rooms->id}}" data-imagesrc="{{$rooms->filename}}">{{$rooms->name}}</option>
                                    @endforeach
                                    </select>
                                </div>
                                <!-- <div class="col-md-3" style="padding-top: 29px">
                                    <button type="button" id="imgbtn" value="" class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModal1">
                                    View Image
                                    </button>
                                </div> -->
                            </div>
                        </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <span id="imgname">
                                            </span>
                                        </div>
                                        <div class="modal-body" >
                                            <img src="" id="imgs" style="width:500px; height:300px;" alt="pic1">
                                        </div>
                                    </div>
                            </div>
                        </div>
                    <div class="resvalid" style="display:none;">
                    <div id="accessory" style="display:none">
                        <div class="row" >
                            <div class="col-md-3">
                                    <label>Accessories</label>
                            </div> 
                            <div class="col-md-3">
                                    <label>Quantity Requested</label>
                            </div>    
                               
                            <div class="col-md-3">
                                    <label>Actions</label>
                            </div>    
                        </div>
                        <div class="inc_row">
                            <input type="hidden" name="count1" id="count1" value="1">
                            <?php $i = 1 ?>
                            <div class="row" id="accessories_grid_{{ $i }}">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <!-- <select class="form-control input-sm" data-placeholder="Select Accessories" rel="select2" onchange="GetAccessory(this.value, {{$i}})" id="accessories_{{$i}}" name="accessories_{{$i}}" required>
                                            <option selected disabled>Choose Accessories</option>
                                            @foreach($accessorie as $accessories)
                                                <option value="{{ $accessories->id }}">{{ $accessories->name }}</option>
                                            @endforeach
                                        </select> -->
                                        <input type="text" class="form-control input-sm" id="accessories_{{$i}}" name="accessories_{{$i}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" name="requested_{{ $i }}" id="requested_{{ $i }}" onkeypress="return isNumberdecimal(this.event)"  class="form-control input-sm" placeholder="Quantity Requested">
                                    </div>                       
                                </div>
                                
                                <div class="col-md-3 next">
                                    <div class="form-group">
                                        <a class="btn btn-primary btn-sm" onclick="insertRow()"><i class="fa fa-plus"></i></a>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteRow({{ $i }})"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   </div> 
                    <div class="resvalid" style="display:none;">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                            {!! Form::submit( 'Submit', ['class'=>'btn btn-sm btn-success']) !!}
                        </div>
                    {!! Form::close() !!}
                    </div>
                <div>
            </div> 
        </div>                
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
                    {!! Form::open(['action' => 'LA\ReservationsController@cancel']) !!}
                        <input type="hidden" id="reservation_id" name="reservation_id" class="form-control input-sm" >
                        <input type="hidden" id="schedule_id" name="schedule_id" value = "{{$scheduleid}}" class="form-control input-sm" >
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
                                            @foreach($user as $users)
                                                @if($users->id != 1)
                                                <option value="{{$users->id}}">{{$users->name}}</option>
                                                @endif
                                            @endforeach
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
                            {!! Form::submit( 'Cancel Reservation', ['class'=>'btn btn-sm btn-warning']) !!}
                        </div>
                    {!! Form::close() !!} 
                <div>
            </div> 
        </div>                
    </div>
</div>

@endsection
@push('styles')
<link rel="stylesheet" href="{{ asset('css/notiflix-2.4.0.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/mine.css') }}"/>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="css/msdropdown/dd.css" />
<style>
    #feedback { font-size: 1.4em; }
    #custom-table .ui-selecting { background: #FECA40; }
    #custom-table .ui-selected { background: #F39814; color: white; }
    #custom-table { list-style-type: none; margin: 0; padding: 0; width: 100%; border: solid #36648B 1px;  }
    #custom-table td { margin: 3px; padding: 0.4em; height: 30px; border: solid #36648B 1px; }
    #custom-table
    {
        margin-top: 30px;
    }
    .addreservation
    {
        margin-left: 900px;
    }
    th{
        padding-left: 10px;
        padding-bottom: 0px;
        border: solid #36648B 1px;
    }
    .resdate{
        width: 200px;
        padding: 0 3px;
        background-color: #36648B !important;
        color: #F0F0F0 !important;
    }
    td.reslabel {
        padding-left: 2px;
        background-color: #EDEDED !important;
        color: #333333 !important;
    }
    .mySlides
    { 
         display: none;
    }



  /* .dd-selected{
      color: black;
  }
    img {
    width: 50px;
    height: 50px;
    }
    a{
        height: 60px;
    } */

    
</style>
@endpush
@push('scripts')

<script src="{{ asset('la-assets/mine.js') }}"></script>
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

<script type="text/javascript" src="https://cdn.rawgit.com/prashantchaudhary/ddslick/master/jquery.ddslick.min.js" ></script>
<script src="{{ asset('js/notiflix-2.4.0.min.js') }}"></script>
<!----------------------------------------------------------------------------------------------------->
<script>
    function getImageID(image_id){
        $('#exampleModal1').modal('show');
        
        $.ajax({
            type: "POST",
            data: {"_token": "{{ csrf_token() }}", "image_id" : image_id},
            url: "{{ url(config('laraadmin.adminRoute') . '/getimageid') }}",
            success: function(response)
            {
                var imgs=response.img;
                var img_filename=imgs[0].filename;
                var img_name=imgs[0].name;
                
                $('#imgs').attr('src', img_filename);
                $("#imgname").html('<h4 id="img_name">'+img_name+'</h4>');
                
            }
        });
    }
   
  
</script> 

<script type="text/javascript">

    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
        $('.acinput').hide();
        $('.acces').click(function(){
            $('.acinput').show();
        });

        var first, day;

        var week = <?php echo json_encode($week); ?>;
        dateBinding(week);

        $("#new_reservation_form").validate({

        });
    });
    
</script>
<!----------------------------------------------------------------------------------------------------->
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('#csrf-token').attr('content')
        }
    });
</script>
<!-------------------------time binding in new reservations ----------------------------->
<script type="text/javascript">



    function getTheDays(same_layout) {
        var dategtc = new Date($('#begindate').val());
        //console.log(dategtc);
        var day=dategtc.getDay();

        $('#enddate').val($('#begindate').val());
        
        var scheduleidone =$('#selected_booking_id').val();
        // var date = new Date(dategtc.getTime() - (dategtc.getTimezoneOffset() * 60000 )).toISOString().split("T")[0];
       
        $.ajax({
            type: "POST",
            data: {"_token": "{{ csrf_token() }}","day": day,"scheduleidone": scheduleidone, "same_layout" : same_layout},
            url: "{{ url(config('laraadmin.adminRoute') . '/getstartendtime') }}",
            success: function(response)
            {
                var result=response.result;
                //console.log(result);
                var day=response.day;
                //console.log(day);
                var data=response.betimes;
                // console.log(data);
                var i = 0;
                if(result == true)
                {
                    $("#test").val('aa');
                }
                else{
                    $("#test").val("vv");
                }
                
                $("#begintime").html('');
                $("#begintime").append('<option selected disabled>Choose Begin Time</option>');

                if(day=='0'){
                    for(i=0;i<data.length;i++)
                    {
                        $("#begintime").append('<option value=' + data[i].start+ '>' +data[i].start+ '</option>');
                    }
                }else if(day=='1'){
                    for(i=0;i<data.length;i++)
                    {
                        $("#begintime").append('<option value=' + data[i].start+ '>' +data[i].start+ '</option>');
                    }
                }else if(day=='2'){
                    for(i=0;i<data.length;i++)
                    {
                        $("#begintime").append('<option value=' + data[i].start+ '>' +data[i].start+ '</option>');
                    }
                }else if(day=='3'){
                    for(i=0;i<data.length;i++)
                    {
                        $("#begintime").append('<option value=' + data[i].start+ '>' +data[i].start+ '</option>');
                    }
                }
                else if(day=='4'){
                    for(i=0;i<data.length;i++)
                    {
                        $("#begintime").append('<option value=' + data[i].start+ '>' +data[i].start+ '</option>');
                    }
                }
                else if(day=='5'){
                    for(i=0;i<data.length;i++)
                    {
                        $("#begintime").append('<option value=' + data[i].start+ '>' +data[i].start+ '</option>');
                    }
                }
                else if(day=='6'){
                    for(i=0;i<data.length;i++)
                    {
                        $("#begintime").append('<option value=' + data[i].start+ '>' +data[i].start+ '</option>');
                    }
                }
            }
        });

        getTheEndDays(same_layout);
    }
        
    function getTheEndDays(same_layout) {
        var enddate = new Date($('#enddate').val());
        var day = enddate.getDay();

        var scheduleidone =$('#selected_booking_id').val();
        // var date = new Date(enddate.getTime() - (enddate.getTimezoneOffset() * 60000 )).toISOString().split("T")[0];
        
        $.ajax({
            type: "POST",
            data: {"_token": "{{ csrf_token() }}","day": day,"scheduleidone": scheduleidone, "same_layout" : same_layout},
            url: "{{ url(config('laraadmin.adminRoute') . '/getstartendtime') }}",
            success: function(response)
            {
                var day=response.day;
                var data=response.betimes;
                var i = 0;
                $("#end_time").html('');
                $("#end_time").append('<option selected disabled>Choose End Time</option>');

                if(day=='0')
                {
                    for(i=0;i<data.length;i++)
                    {
                        $("#end_time").append('<option value=' + data[i].end+ '>' +data[i].end+ '</option>');
                    }
                }else if(day=='1')
                {
                    for(i=0;i<data.length;i++)
                    {
                        $("#end_time").append('<option value=' + data[i].end+ '>' +data[i].end+ '</option>');
                    }
                }else if(day=='2')
                {
                    for(i=0;i<data.length;i++)
                    {
                        $("#end_time").append('<option value=' + data[i].end+ '>' +data[i].end+ '</option>');
                    }
                }else if(day=='3')
                {
                    for(i=0;i<data.length;i++)
                    {
                        $("#end_time").append('<option value=' + data[i].end+ '>' +data[i].end+ '</option>');
                    }
                }else if(day=='4')
                {
                    for(i=0;i<data.length;i++)
                    {
                        $("#end_time").append('<option value=' + data[i].end+ '>' +data[i].end+ '</option>');
                    }
                }else if(day=='5')
                {
                    for(i=0;i<data.length;i++)
                    {
                        $("#end_time").append('<option value=' + data[i].end+ '>' +data[i].end+ '</option>');
                    }
                }else if(day=='6')
                {
                    for(i=0;i<data.length;i++)
                    {
                        $("#end_time").append('<option value=' + data[i].end+ '>' +data[i].end+ '</option>');
                    }
                }
            }
        });
    }

    function checkAvailable(){
        var begindate=$('#begindate').val();
        var resource = $("#resource option:selected").val();
        var begintime = $( "#begintime option:selected" ).val();
        var endtime = $( "#end_time option:selected" ).val();
        $.ajax({
            type: "POST",
            data: {"_token": "{{ csrf_token() }}", "begindate" : begindate, "begintime" : begintime, "endtime" : endtime, 'resource' : resource},
            url: "{{ url(config('laraadmin.adminRoute') . '/getdatetime') }}",
            success: function(response)
            {
                var result=response;
                console.log(result);
                if(result == "true")
                {
                    $("#errormsg").css('display', 'block');
                    
                }else
                    $("#errormsg").css('display', 'none'); 
            }
        });
    }
</script>
<!-- date binding -->
<script type="text/javascript">
var reservations = <?php echo json_encode($reservation); ?>;
// console.log(reservations);
var data_resources = <?php echo json_encode($data_resources); ?>;
function dateBinding(week){

    $('.startdate').html(week[0]);
    $('.startdate').attr("data-start",week[0]);
    $('.enddate').html(week[6]);
    $('.enddate').attr("data-end",week[6]);

    var mon = $(".days").map(function() {
        return $(this).data('day');
    }).get();
    if(mon==0)
    {
        $('#monday').html("Monday, "+week[0]);
    }
    var tue = $(".days").map(function() {
        return $(this).data('tue');
    }).get();
    if(tue==1)
    {
        $('#tuesday').html("Tuesday, "+week[1]);
    }
    var wed = $(".days").map(function() {
        return $(this).data('wed');
    }).get();
    if(wed==2)
    {
        $('#wednesday').html("Wednesday, "+week[2]);
    }
    var thu = $(".days").map(function() {
        return $(this).data('thu');
    }).get();
    if(thu==3)
    {
        $('#thursday').html("Thursday, "+week[3]);
    }
    var fri = $(".days").map(function() {
        return $(this).data('fri');
    }).get();
    if(fri==4)
    {
        $('#friday').html("Friday, "+week[4]);
    }
    var sat = $(".days").map(function() {
        return $(this).data('sat');
    }).get();
    if(sat==5)
    {
        $('#saturday').html("Saturday, "+week[5]);
    }
    var sun = $(".days").map(function() {
        return $(this).data('sun');
    }).get();
    if(sun==6)
    {
        $('#sunday').html("Sunday, "+week[6]);
    }
     //set date for monday to table column
     var weekdayone=week[0];
    $('.mondaycolor').attr("data-color",weekdayone);

    //set date for tuesday to table column
    var tuesday=week[1];
    $('.tuesdaycolor').attr("data-color",tuesday);

    //set date for wed to table column
    var wednesday=week[2];
    $('.wed').attr("data-color",wednesday);
    
    //set date for thu to table column
    var thursday=week[3];
    $('.thu').attr("data-color",thursday);

    //set date for fri to table column
    var friday=week[4];
    $('.fri').attr("data-color",friday);

    //set date for sat to table column
    var saturday=week[5];
    $('.sat').attr("data-color",saturday);

    //set date for sun to table column
    var sunday=week[6];
    $('.sun').attr("data-color",sunday);

    //get resourceid value from table column
    var resourceid = $(".slots").map(function() {
    var resource_id= $(this).data('resourceid');
    var time = $(this).data('date');
    var endtime = $(this).data('endtime');
    var curweekdate = $(this).attr("data-color");
    var cdtid = curweekdate+time+resource_id;
    var cetid = curweekdate+endtime+resource_id;
    var curdatetimeid = cdtid.replace(/([:-])+/g, "");
    var curenddatetimeid = cetid.replace(/([:-])+/g, "");
    
    //set data-attribute for start to table column
        $(this).attr("data-id",curdatetimeid);
    }).get();

    colorBinding();
}

function colorBinding(){
    //get resourceid value from database
    var resource= $(".resource").map(function() {
        return $(this).val();         
    }).get();

    //get resourceid value from table column
    var resourceid = $(".slots").map(function() {
        var resource_id = $(this).data('resourceid');
        var time = $(this).data('date');
        var endtime = $(this).data('endtime');
        var date = $(this).data('color');
        var dtid = date + time + resource_id;
        var date_time = date + time;

        var datetimeid = dtid.replace(/([:-])+/g, "");
        date_time = date_time.replace(/([:-])+/g, "");

        $(this).attr("data-id",datetimeid);
        $(this).attr("data-datetime", date_time);
    }).get();

    var now = new Date();
    var current_date_time = moment(now).format('YYYYMMDDHHmm');

    for (var i = reservations.length - 1; i >= 0; i--) {
        var reservation = reservations[i];

        var start_date_time = reservation.begin_date.concat(reservation.begin_time);
        var end_date_time = reservation.end_date.concat(reservation.end_time);

        start_date_time = start_date_time.replace(/([:-])+/g, "");
        end_date_time = end_date_time.replace(/([:-])+/g, "");

        start_date_time = start_date_time.concat(reservation.resource_id);
        end_date_time = end_date_time.concat(reservation.resource_id);
        var count = 0;

        $('.slots').each(function(slot)
        {
            var slot_data = $(this).data('id');
            res_val = slot_data.toString().substring(12);

            if(parseInt(start_date_time) <= slot_data && slot_data < parseInt(end_date_time) &&  res_val == reservation.resource_id) {

                <?php if (Entrust::hasRole("Reception") || Entrust::hasRole("SUPER_ADMIN")): ?>
                    $('[data-id="'+slot_data+'"]').html('<a href="javascript:viewReservation('+reservation.id+');">'+reservations[i].name+'</a>');
                <?php endif ?>
                if(reservation.status == 'Confirmed'){
                    $('[data-id="'+slot_data+'"]').css('background-color', '');
                    $('[data-id="'+slot_data+'"]').addClass('bg-success');
                }else{
                    $('[data-id="'+slot_data+'"]').css('background-color', '');
                    $('[data-id="'+slot_data+'"]').addClass('bg-warning');
                }
                ++count;
                if(count > 1){
                    $('[data-id="'+start_date_time+'"]').attr("colspan", count);  
                    $('[data-id="'+start_date_time+'"]').next("td").remove(); 
                }
            }
            
        });     
    }
}

function viewReservation(reservation_id){
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

            for (var i = data_resources.length - 1; i >= 0; i--) {
                if(data_resources[i].id == reservation.resource_id){
                    modal.find('#resource').val(data_resources[i].name + '- Number of maximum people('+ data_resources[i].no_of_maximum_people + ')');
                }
            }
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
<!------------------------------------Accessories Grid------------------------------------------------------>
<script>
var accessories = <?php echo $accessorie; ?>;
// var accessories = [];
function getAccessoriesByResource(resource_id){
    $.ajax({
        "url" : "{{ url(config('laraadmin.adminRoute') . '/accessories_by_resourceid') }}",
        type: 'POST',
        data : {'_token': '{{ csrf_token() }}', 'resource_id' : resource_id},
        success: function(data)
        {
            // console.log(data);
        }
    });

    for (var i = data_resources.length - 1; i >= 0; i--) {
        if(data_resources[i].id == resource_id){
            var data_resource = data_resources[i];
            console.log(data_resource);
            if(data_resource.room_types == true){
                $("#room_type_div").css('display', 'block');
                
            }else
                $("#room_type_div").css('display', 'none');
                

            if(data_resource.select_accessory == true){
                $("#accessory").css('display', 'block');
            }else{
                $("#accessory").css('display', 'none');
            }
        }
    }
}
function GetAccessory(accessories_id, grid_count){
    for (var i = 0; i < accessories.length; i++) {
        var accessory = accessories[i];
        if (accessory.id == accessories_id) {
            $("#accessories_grid_"+grid_count+" #available_"+grid_count).val(accessory.available_quantity);
        }
    }
}
function isNumberdecimal(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode <= 45 || charCode > 57 || charCode == 47 )) {
        return false;
    }
    return true;
}
var grid1;
function insertRow()
{
    grid1 = $("#count1").val();
    grid1++;
    $("#count1").val(grid1);
    var new_entry1 = `<div class="row" id="accessories_grid_${grid1}">
            <div class="col-md-3">
                <div class="form-group">
                    
                    <input type="text" class="form-control input-sm" data-placeholder="Select Accessories" rel="select2" onchange="GetAccessory(this.value, ${grid1})" required id="accessories_${grid1}" name="accessories_${grid1}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <input type="text" name="requested_${grid1}" id="requested_${grid1}" onkeypress="return isNumberdecimal(this.event)" class="form-control input-sm" placeholder="Quantity Requested">
                </div>                       
            </div>
           
            <div class="col-md-3 next">
                <div class="form-group">
                    <a class="btn btn-primary btn-sm" onclick="insertRow()"><i class="fa fa-plus"></i></a>
                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(${grid1})"><i class="fa fa-minus"></i></button>
                </div>
            </div>
        </div>`;
    grid1--;                        
    $(".inc_row").append(new_entry1);
}

function deleteRow(grid_no){
    var count = $("#count1").val();
    if(count > 1)
    {
        $("#accessories_grid_"+grid_no).remove();   
    }
    else
    {
        alert('Rows cannot be removed');
    }
    count--;
    $("#count1").val(count);
}

var now = moment(now).format('YYYY-MM-DD');	
console.log(now);

function checkRequestDate(){
    var now = moment(now).format('YYYY-MM-DD');
    console.log(now);
    var startDate = $('#begindate').val();
    console.log(startDate);
    var end_date = $('#enddate').val(startDate);
    var endDate = $('#enddate').val();
    
    console.log(endDate);
    Notiflix.Report.Init({
        width: '300px',
        height: '50px',
        svgSize: '50px'
            });
    if( startDate >= now && endDate >= now)
    {
        $(".resvalid").css('display', 'block');	
        $("#errormsg").css('display', 'none');	


    }else{
        $(".resvalid").css('display', 'none');	
        $("#errormsg").css('display', 'block');     
        
    }
    
    
    
}








</script>
@endpush




