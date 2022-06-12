<!DOCTYPE html>
<html>
    <head>
        <title>Datatables Event pagination with Search and Sort in Laravel</title>

        <!-- Meta -->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta charset="utf-8" />

        <!-- Datatable CSS -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" />

        <!-- Font Awesome  -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" rel="stylesheet" />

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
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-4 col-md-4 col-sm-12 mb-3 mt-4">
                    <a class="btn btn-sm btn-primary btn-block p-2" href=" {{ route('event.create.page') }}"><i class="fas fa-plus-circle"></i> Create New Event</a>
                </div>

                <div class="col-12 ">

                <table id="eventTable" width="100%" border="1" style="border-collapse: collapse;">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Event Name</td>
                            <td>Slug</td>
                            <td>Start At</td>
                            <td>End At</td>
                            <td>Created At</td>
                            <td>Updated At</td>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
            </div>
        </div>

        <!-- Script -->
        <script type="text/javascript">

            const convertToDisplayDate = date => {

                if ( date === null || date === "" ) {
                    return ''
                }

                const eventFromDate = new Date(date.replace(/ /g,"T"));
                const dateString = eventFromDate.toDateString();
                const localeTimeString = eventFromDate.toLocaleTimeString();

                //return `${dateString}, ${localeTimeString}`;
                return moment(date).format('ddd DD MMM YYYY, hh:mm:ss A');
            };

            $(document).ready(function () {
                // DataTable
                $("#eventTable").DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{route('events.index')}}",
                    columns: [
                        { data: "id" },
                        { data: "name" },
                        { data: "slug" },
                        {
                        data: 'startAt',
                        name: 'startAt',
                        render: (data) => {
                            return convertToDisplayDate(data)
                        }
                    }, {
                        data: 'endAt',
                        name: 'endAt',
                        render: (data) => {
                            return convertToDisplayDate(data)
                        }
                    }, 
                        {
                        data: 'created_at',
                        name: 'created_at',
                        render: (data) => {
                            return convertToDisplayDate(data)
                        }
                    }, {
                        data: 'updated_at',
                        name: 'updated_at',
                        render: (data) => {
                            return convertToDisplayDate(data)
                        }
                    }, 
                        {
                            data: "id",
                            name: "id",
                            orderable: false,
                            render: (data, type, full) => {
                                const { id: eventId, name: eventName } = full;

                                let editEventButtons = `<span data-name="edit-events"
                                       data-toggle="tooltip"
                                       data-placement="bottom"
                                       title="Edit Event Details" >
                                    <i  class="fa fa-edit mr-2 text-primary"
                                        data-id="${eventId}"
                                        data-name="${eventName}"
                                        style="cursor: pointer"
                                     ></i>
                                </span>`;

                                let deleteEventButtons = `<span data-name="delete-events"
                                       data-toggle="tooltip"
                                       data-placement="bottom"
                                       title="Delete Event" >
                                    <i  class="fa fa-trash mr-2 text-danger"
                                        data-id="${eventId}"
                                        data-name="${eventName}"
                                        style="cursor: pointer"
                                     ></i>
                                </span>`;

                                let viewEventButtons = `<span data-name="view-events"
                                       data-toggle="tooltip"
                                       data-placement="bottom"
                                       title="View Event Details" >
                                    <i  class="fa fa-eye mr-2 text-secondary"
                                        data-id="${eventId}"
                                        data-name="${eventName}"
                                        style="cursor: pointer"
                                     ></i>
                                </span>`;


                                return `<span>
                                ${editEventButtons}
                                ${viewEventButtons}
                                ${deleteEventButtons}
                                </span>`;
                            },
                        },
                    ],
                });

                $(document).on("click", 'span[data-name="delete-events"]', (e) => {
                    e.stopPropagation();
                    const currentRowId = e.target.getAttribute("data-id");
                    const currentEventName = e.target.getAttribute("data-name");

                    Swal.fire({
                        title: `Delete ${currentEventName}?`,
                        text: `The action cannot be revert.  `,
                        type: "warning",
                        showCancelButton: true,
                        reverseButtons: true,
                        confirmButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!",
                    }).then((result) => {
                        if (result.value) {
                            let urlApi = "{{ route('events.delete', ['id' => ':currentRowId' ])  }}";
                            urlApi = urlApi.replace(":currentRowId", currentRowId);

                            $.ajax({
                                type: "DELETE",
                                url: urlApi,
                                data: {
                                    id: currentRowId,
                                },
                                success: () => {
                                    Swal.fire({
                                        type: "success",
                                        title: "Event deleted successfully.",
                                    });

                                    $("#eventTable").DataTable().ajax.reload();
                                },
                            });
                        }
                    });
                });
            });

            $(document).on("click", 'span[data-name="edit-events"]', (e) => {
                const currentRowId = e.target.getAttribute("data-id");

                let url = "{{ route('events.edit.display', ['id' => ':currentRowId' ])  }}";
                url = url.replace(":currentRowId", currentRowId);

                window.location.href = url;
            });

            $(document).on("click", 'span[data-name="view-events"]', (e) => {
                const currentRowId = e.target.getAttribute("data-id");

                let url = "{{ route('events.show.display', ['id' => ':currentRowId' ])  }}";
                url = url.replace(":currentRowId", currentRowId);

                window.location.href = url;


            });
        </script>
    </body>
</html>
