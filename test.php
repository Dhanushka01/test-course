@extends('admin.layouts.app')

@section('content')
@can('attendance-full')
<div class="row">
    <div class="col-md-12">
        {!! create_form([
            "title" => "<b>ATTENDANCE IN/OUT</b>",
            "method" => 'post',
            "action" => route('attendances.storefull'),
            "class" => "row specialInput",
            "id" => "full_attendance_form",
            "card_style" => 'card-primary',
            "errors" => $errors,
            "error" => $alert_ ?? '',
            "success" => $success_ ?? '',
            // "onsubmit" => 'return submit(this)',
            "form" => [
                        [
                            "field" => "hidden",
                            "name" => "attendance_mode",
                            "id" => "attendance_mode",
                            "value" => 'both'
                        ],
                        [
                            "field" => "number",
                            "label" => "EPF No",
                            "name" => "emp_id",
                            "id" => "emp_id-inout",
                            "class" => "col-md-3",
                            "value" => old("emp_id") ? ($getEmployee->epf_no ?? '')  : '',
                            "optional" => [
                                "autocomplete" => "off",
                                "max-length" => "0"
                            ]
                        ],
                        [
                            "field" => "html",
                            "code" => '
                            <div class="row mb-2" id="employee_in_info_2">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4 bold_small_text">Name</div>
                                        <div class="col-md-4 bold_small_text">Designation</div>
                                        <div class="col-md-4 bold_small_text">Division</div>
                                    </div>
                                    <div class="row pt-2">
                                        <div class="col-md-4 font-14"><input type="text" class="form-control" id="attendance_in_name_3" readonly  /></div>
                                        <div class="col-md-4 font-14"><input type="text" class="form-control" id="attendance_in_designation_3" readonly  /></div>
                                        <div class="col-md-4 font-14"><input type="text" class="form-control" id="attendance_in_division_3" readonly  /></div>
                                    </div>
                                </div>
                                <hr />

                            </div>
                            ',
                            "class" => 'col-md-9',
                        ],
                                    [
                                        "field" => "radio",
                                        "label" => "Attend",
                                        "name" => "attendance_type",
                                        "id" => "attendance_type",
                                        "class" => "col-md-3 radioCreative mt-2",
                                        "value" => "attended",
                                        "checked" => old("attendance_type") == "attended" ? true : false,
                                        "optional" => [
                                            "onclick" => "removeDutyLeave(this)",
                                        ],
                                    ],
                                    [
                                        "field" => "radio",
                                        "label" => "Absent",
                                        "name" => "attendance_type",
                                        "id" => "attendance_type",
                                        "class" => "col-md-3 radioCreative mt-2",
                                        "value" => "absent",
                                        "checked" => old("attendance_type") == "absent" ? true : false,
                                        "optional" => [
                                            "onclick" => "removeDutyLeave(this)",
                                        ],
                                    ],
                                    [
                                        "field" => "radio",
                                        "label" => "Duty Leave",
                                        "name" => "attendance_type",
                                        "id" => "attendance_type",
                                        "class" => "col-md-3 radioCreative mt-2",
                                        "value" => "dutyLeave",
                                        "checked" => old("attendance_type") == "dutyLeave" ? true : false,
                                        "optional" => [
                                            "onclick" => "setDutyLeave(this)",
                                        ],
                                    ],
                                    [
                                        "field" => "radio",
                                        "label" => "Leave Leave",
                                        "name" => "attendance_type",
                                        "id" => "attendance_type",
                                        "class" => "col-md-3 radioCreative mt-2",
                                        "value" => "leaveLeave",
                                        "checked" => old("attendance_type") == "leaveLeave" ? true : false,
                                        "optional" => [
                                            "onclick" => "removeDutyLeave(this)",
                                        ],
                                    ],
                        [
                            "field" => "date",
                            "label" => "Date",
                            "name" => "date",
                            "id" => "date",
                            "class" => "col-md-4 mt-3",
                            "value" => old("date"),
                        ],
                        [
                            "field" => "time",
                            "label" => "IN Time",
                            "name" => "time_in",
                            "id" => "time_in",
                            "class" => "col-md-4 mt-3",
                            'optional' => ['onkeyup' => 'setTime(this)', 'maxlength'=>5],

                        ],
                        [
                            "field" => "time",
                            "label" => "OUT Time",
                            "name" => "time_out",
                            "id" => "time_out",
                            "class" => "col-md-4 mt-3",
                            'optional' => ['onkeyup' => 'setTime(this)', 'maxlength'=>5],
                        ],
                        [
                            "field" => "select",
                            "label" => "Location IN",
                            "name" => "location_id_in",
                            "class" => "col-md-6",
                            "option" => $allLocation,
                            "optional" => [
                                "autocomplete" => "off",
                                "id" => "location-search-id-inout-in2",
                            ]
                        ],
                        [
                            "field" => "select",
                            "label" => "Location OUT",
                            "name" => "location_id_out",
                            "class" => "col-md-6",
                            "option" => $allLocation,
                            "optional" => [
                                "autocomplete" => "off",
                                "id" => "location-search-id-inout-out2",
                            ]
                        ],
                        [
                            "field" => "submit",
                            "name" => "save",
                            "id" => "save",
                            "value" => "Add Entry",
                            "class" => "col-md-12 text-center mb-5"
                        ],
                      ]
            ]) !!}
    </div>
    <div class="col-md-4">

    </div>
</div>
@endcan

@endsection

@section("styles")
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .jsd-search-container{
        position: absolute;
        width: auto;
        display: none;
        background-color: #fff;
        z-index: 2;
    }
    .jsd-search-container ul{
        position: relative;
        width: 100%;
        list-style: none;
        padding: 0;
        margin: 0;
        border: rgb(238, 238, 238) solid 1px;
    }
    .jsd-search-container ul li{
        padding: 5px;
        cursor: pointer;
    }
    .jsd-search-container ul li:not(:first-child){
        border-top: rgb(238, 238, 238) solid 1px;
    }
    .jsd-search-container ul li.active{
        background-color: rgb(240, 240, 240);
    }

    .jsd-search-container .loader {
        border: 3px solid #f3f3f3;
        border-radius: 50%;
        border-top: 3px solid #afafaf;
        width: 10px;
        height: 10px;
        -webkit-animation: spin 2s linear infinite; /* Safari */
        animation: spin 0.3s linear infinite;
        margin: 5px auto;
    }

      /* Safari */
      @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
      }

      @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
      }
      .select2-container .select2-selection--single {
          height: 40px;
      }
    </style>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset("js/js-search-dropdown.min.js") }}"></script>
<script type="text/javascript">
let AttendanceTypeGlobal = '';
    Jsd({
        identifier: "location-search-id",
        fetch: "{{ route('location.list.json') }}",
        param: "q",
      });
    Jsd({
        identifier: "emp_id",
        fetch: "{{ route('employees.listepf.json') }}",
        param: "q",
      });

    Jsd({
        identifier: "location-search-id-out",
        fetch: "{{ route('location.list.json') }}",
        param: "q",
      });
    Jsd({
        identifier: "emp_id-out",
        fetch: "{{ route('employees.listepf.json') }}",
        param: "q",
      });
    Jsd({
        identifier: "emp_id-inout",
        fetch: "{{ route('employees.listepf.json') }}",
        param: "q",
      });
    Jsd({
        identifier: "emp_id_overtime",
        fetch: "{{ route('employees.listepf.json') }}",
        param: "q",
      });

    Jsd({
        identifier: "location-search-id-inout-in",
        fetch: "{{ route('location.list.json') }}",
        param: "q",
      });
    Jsd({
        identifier: "location-search-id-inout-out",
        fetch: "{{ route('location.list.json') }}",
        param: "q",
      });

    $(document).ready(function(){
        $('#emp_id-hidden').change(function(){
            const val = $('#emp_id-hidden').val();
            const ftc = fetch('/admin/employees/getuserjson/'+val).then(res => res.json()).then(response => {
                $('#employee_in_info').show();
                document.getElementById('attendance_in_name').value = response.name;
                document.getElementById('attendance_in_designation').value = response.designation;
                document.getElementById('attendance_in_division').value = response.division;
            });
        });

        $('#emp_id-out-hidden').change(function(){
            const val = $('#emp_id-out-hidden').val();
            const ftc = fetch('/admin/employees/getuserjson/'+val).then(res => res.json()).then(response => {
                $('#employee_in_info_2').show();
                document.getElementById('attendance_in_name_2').value = response.name;
                document.getElementById('attendance_in_designation_2').value = response.designation;
                document.getElementById('attendance_in_division_2').value = response.division;
            });
        });

        $('#emp_id_overtime-hidden').change(function(){
            const val = $('#emp_id_overtime-hidden').val();
            const ftc = fetch('/admin/employees/getuserjson/'+val).then(res => res.json()).then(response => {
                $('#employee_overtime_info').show();
                document.getElementById('attendance_overtime_name').value = response.name;
                document.getElementById('attendance_overtime_designation').value = response.designation;
                document.getElementById('attendance_overtime_division').value = response.division;
            });
        });

        $('#emp_id-inout-hidden').change(function(){
            const val = $('#emp_id-inout-hidden').val();
            const ftc = fetch('/admin/employees/getuserjson/'+val).then(res => res.json()).then(response => {
                $('#employee_in_info_2').show();
                document.getElementById('attendance_in_name_3').value = response.name;
                document.getElementById('attendance_in_designation_3').value = response.designation;
                document.getElementById('attendance_in_division_3').value = response.division;
                $('#location-search-id-inout-in2').val(response.location_id).trigger('change');
                $('#location-search-id-inout-out2').val(response.location_id).trigger('change');
            });
        });

            @if(old("emp_id"))
                const ftc = fetch('/admin/employees/getuserjson/{{ old("emp_id") }}').then(res => res.json()).then(response => {
                    $('#employee_in_info').show();
                    document.getElementById('attendance_in_name').innerHTML = response.name;
                    document.getElementById('attendance_in_designation').innerHTML = response.designation;
                    document.getElementById('attendance_in_division').innerHTML = response.division;
                    document.getElementById('emp_id-hidden').value = {{ old("emp_id") }};
                    document.getElementById('emp_id-hidden').setAttribute("name", "emp_id");

                });
            @endif
            @if(old('location_id'))
                document.querySelector('#location-search-id-hidden').value = '{{ old('location_id') }}';
                document.querySelector('#location-search-id').value = '{{ $getLocation->name ?? '' }}';
                document.querySelector('#location-search-id-hidden').setAttribute("name", "location_id");
            @endif
    });


function setDutyLeave(event){
    const getEmpId = document.getElementById('emp_id-inout-hidden').value;
    if(!getEmpId)
    {
        alert("Please select a employee before selecting options");
        event.checked = false;
        return;
    }

    const getTiming = async () => {
        return await fetch(`/admin/attendances/getdefaultworkinghours/${getEmpId}`).then(response => response.json())
    };
    getTiming().then(response => {
        // document.getElementById('time_in').value = response.starthour;
        // document.getElementById('time_out').value = response.lasthour;
        document.getElementById('time_in').value = '';
        document.getElementById('time_out').value = '';
        document.getElementById('time_in').setAttribute("readonly", "readonly");
        document.getElementById('time_out').setAttribute("readonly", "readonly");
    });

}

function removeDutyLeave(event){
    const getEmpId = document.getElementById('emp_id-inout-hidden').value;
    if(!getEmpId)
    {
        alert("Please select a employee before selecting options");
        event.checked = false;
        return;
    }
    const getVal = event.value;
    AttendanceTypeGlobal = getVal;
    if(getVal === "absent")
    {
        document.getElementById('time_in').value = '';
        document.getElementById('time_out').value = '';
        document.getElementById('time_in').setAttribute("readonly", "readonly");
        document.getElementById('time_out').setAttribute("readonly", "readonly");
    }else if(getVal === "leaveLeave")
    {
        document.getElementById('time_in').value = '';
        document.getElementById('time_out').value = '';
        document.getElementById('time_in').setAttribute("readonly", "readonly");
        document.getElementById('time_out').setAttribute("readonly", "readonly");
    }else{
        document.getElementById('time_in').removeAttribute("readonly");
        document.getElementById('time_out').removeAttribute("readonly");
    }

}

</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(function () {
        $("#location-search-id-inout-out2").select2();
        $("#location-search-id-inout-in2").select2();

        $('#full_attendance_form').submit(function(x){
            const getEmpId = document.getElementById('emp_id-inout-hidden').value;
        if(!getEmpId)
        {
            alert("Please select a employee before selecting options");
            return false;
        }
        const att = $('input[name="attendance_type"]').is(":checked");
        if(!att)
        {
            alert("Select the attendance type");
            return false;
        }
        const date = $('#date').val().trim();
            if(!date)
            {
                alert("Select a date");
                return false;
            }
            if(AttendanceTypeGlobal === "attended")
            {
                const inTime = $('#time_in').val().trim();
                const outTime = $('#time_out').val().trim();
                if(!inTime || !outTime)
                {
                    alert("Select IN/OUT Time");
                    return false;
                }
            }
        });
    });
    function setTime(e) {
        let val = e.value;
        val = val.replace(/[^0-9.]/g, "");
        if (val.length >= 4) {
            val = val.replace(/[-:]/g, "");
            let split = val.split("");
            let output = "";
            for (let index in split) {
                const inx = parseInt(index);
                if (inx % 2 === 0 && inx !== 0) {
                    output += ":" + split[index];
                } else {
                    output += split[index];
                }
            }

            if (val.length >= 4) {
                const split = output.split(":");
                e.value = (parseInt(split[0]) <= 23 ? split[0] : 23) + ":" + (parseInt(split[1]) <= 59 ? split[1] : 59);
                return;
            }

            e.value = output;
        }else{
            e.value = val;
        }
    }
</script>
@endsection
