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
                    <form id="create_event_form">
                        <div class="row">
                            <div class="form-group col-12">
                                <label>
                                    <strong>Event Name <span class="text-danger">*</span></strong>
                                </label>
                                <input id="event_name" name="event_name" value="{{$events->name}}" class="w-100" />
                            </div>
                            <div class="form-group col-12">
                                <label>
                                    <strong>Slug <span class="text-danger">*</span></strong>
                                </label>
                                <input id="event_slug" name="event_slug" value="{{$events->slug}}" class="w-100" />
                            </div>

                            <div class="form-group col-6 col-md-6 col-sm-12">
                                <label>
                                    <strong>Start Date<span class="text-danger" required>*</span></strong>
                                </label>
                                <input type="text" id="start_at" name="start_at" class="w-100" />
                            </div>
                            <div class="form-group col-6 col-md-6 col-sm-12">
                                <label>
                                    <strong>End Date<span class="text-danger" required>*</span></strong>
                                </label>
                                <input type="text" id="end_at" name="end_at" class="w-100" />
                            </div>
                        </div>
                    </form>

                    <div class="row justify-content-end">
                        <div class="col-12 col-sm-6 col-md-5 col-lg-4 col-xl-4">
                            <button id="btn-subscribe" class="btn btn-primary btn-sm float-right px-5" type="button">
                                Edit Event
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $("#start_at").datetimepicker({
                closeText: "Save",
                showTimepicker: true,
                amNames: ["AM", "A"],
                pmNames: ["PM", "P"],
                dateFormat: "dd-mm-yy",
                timeFormat: "hh:mm TT",
            });

            $("#end_at").datetimepicker({
                closeText: "Save",
                showTimepicker: true,
                amNames: ["AM", "A"],
                pmNames: ["PM", "P"],
                dateFormat: "dd-mm-yy",
                timeFormat: "hh:mm TT",
            });
        </script>
    </body>
</html>
