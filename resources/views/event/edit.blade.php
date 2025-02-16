<!DOCTYPE html>
<html>
    <head>
        <title>Edit Event</title>

        <!-- Meta -->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta charset="utf-8" />

        <!-- Datatable CSS -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"/>

        <!-- Font Awesome  -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" rel="stylesheet">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css" />

        <!-- Font Awesome  -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" rel="stylesheet" />

        <!-- Open Sans -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro&display=swap" rel="stylesheet" type="text/css" />

        <!-- JQuery Stylesheets -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" />

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>

        <!-- Popper.js, then Bootstrap JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" crossorigin="anonymous"></script>

        <!-- Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" crossorigin="anonymous"></script>

        <!-- Jquery Validation -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js" crossorigin="anonymous"></script>

        <!-- Datatable JS -->
        <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

        <!-- SweetAlert JS-->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

        <!-- UI Timepicker Addon JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>

        <!-- Date format using moment js -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    </head>
    <body>
        <div class="m-2">
            <button id="btn_back" class="btn btn-dark btn-sm" onclick="history.back();">
                <i class="fa fa-arrow-left mr-1"></i>
                Back
            </button>
        </div>

        <h2 class="text-center">Edit Event</h2>

        {{-- dd($events) --}}

        <div class="d-flex no-gutters justify-content-center">
            <div class="col-12 col-sm-12 col-md-10 col-lg-9 col-xl-8">
                <div class="bg-white p-1 p-sm-2 p-lg-3">
                    <form id="edit_event_form">
                        @csrf
                        <div class="row">
                            <div class="form-group col-12">
                                <label>
                                    <strong>Event Name <span class="text-danger">*</span></strong>
                                </label>
                                <input id="name" name="name" value="{{$events->name}}" class="w-100" />
                            </div>
                            <div class="form-group col-12">
                                <label>
                                    <strong>Slug <span class="text-danger">*</span></strong>
                                </label>
                                <input id="slug" name="slug" value="{{$events->slug}}" class="w-100" />
                            </div>

                            <div class="form-group col-6 col-md-6 col-sm-12">
                                <label>
                                    <strong>Start Date<span class="text-danger" required>*</span></strong>
                                </label>
                                <div class="input-group date" id="startAt">
                                <input type="text"  name="startAt" class="w-100" value="{{ Carbon\Carbon::parse( $events->startAt)->format('d-m-Y h:i:s A') }}"/>
                            </div>
                            </div>
                            <div class="form-group col-6 col-md-6 col-sm-12">
                                <label>
                                    <strong>End Date<span class="text-danger" required>*</span></strong>
                                </label>
                                <div class="input-group date" id="endAt">
                                <input type="text" name="endAt" class="w-100" value="{{ Carbon\Carbon::parse( $events->endAt)->format('d-m-Y h:i:s A') }}"/>
                            </div>
                            </div>
                        </div>
                    </form>

                    <div class="row justify-content-end">
                        <div class="col-12 col-sm-6 col-md-5 col-lg-4 col-xl-4">
                            <button id="btn-edit" class="btn btn-primary btn-sm float-right px-5" type="button">
                                Edit Event
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $("input[name=startAt]").datetimepicker({
                closeText: "Save",
                showTimepicker: true,
                timeInput: true,
                amNames: ["AM", "A"],
                pmNames: ["PM", "P"],
                dateFormat: "dd-mm-yy",
                timeFormat: "hh:mm TT",
            });

            $("input[name=endAt]").datetimepicker({
                closeText: "Save",
                showTimepicker: true,
                timeInput: true,
                amNames: ["AM", "A"],
                pmNames: ["PM", "P"],
                dateFormat: "dd-mm-yy",
                timeFormat: "hh:mm TT",
            });$


            // Form validation
            $('#edit_event_form').validate({
                rules         : {
                    name  : {
                        required: true,
                    },
                    slug: {
                        required: true
                    },
                    start_at: {
                        required: function(element) {
                            const nonContractKey = {!! json_encode(config('settings.contract.types.non-contract.key')) !!}
                            return $('input[type=radio][name=contract_type]:checked').val() !== nonContractKey;
                        }
                    },
                    end_start: {
                        required: function(element) {
                            const nonContractKey = {!! json_encode(config('settings.contract.types.non-contract.key')) !!}
                            return $('input[type=radio][name=contract_type]:checked').val() !== nonContractKey;
                        }
                    }
                },
                messages      : {
                    name: {
                        required: "Event Name is required. ",
                    },
                    slug: {
                        required: "Slug is required. "
                    },
                    date_start_format: {
                        required: "Start At is required. ",
                    },
                    endAt: {
                        required: "End At is required. "
                    }
                },
                errorClass    : "d-block text-danger",
                validClass    : "is-valid",
            });



             // Submit form
            $('#btn-edit').click(function () {
                
                let formValid = $('#edit_event_form').valid();



                if (formValid) {
                    // loading();

                    var date_start_format = moment($('input[name="startAt"]').val(),'DD-MM-YYYY hh:mm A').format('YYYY-MM-DD HH:mm:ss');
                    $('#startAt>input').val(date_start_format);

                    var end_start_format = moment($('input[name="endAt"]').val(),'DD-MM-YYYY hh:mm A').format('YYYY-MM-DD HH:mm:ss');
                    $('#endAt>input').val(end_start_format);

                    $.ajax({
                        type   : "PUT",
                        url    : "{{ route('events.update', ['id' => $events->id ]) }}",
                        data   : $('#edit_event_form').serialize(),
                        success: function (response) {

                            console.log(response);


                            if ( response['status_code'] === 200 ) {
                        Swal.fire({
                            title: `Success`,
                            text : response['message'],
                            type : 'success',
                        }).then((result) => {
                            let eventDetailRoute = "{{ route('events.show.display', ['id' => ':currentRowId' ])  }}";
                            eventDetailRoute = eventDetailRoute.replace(":currentRowId", response['data'].id);

                            location.replace(eventDetailRoute);
                        });
                    } else {
                        Swal.fire({
                            title: `FAIL`,
                            text : response['message'],
                            type : 'error',
                        });
                    }
                        },
                        error  : (err) => {

                            console.log(err);
                        }
                    });
                }
            });
        </script>
    </body>
</html>
