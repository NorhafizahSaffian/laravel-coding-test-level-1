@extends('layouts.app')

<style>
        #eventTable td {
            /*border : 1px solid !important;*/
        }
</style>

@section('content')

{{-- dd(Auth::user()) --}}
        <div class="container">
            <div class="row justify-content-center">

                @if(Auth::user() !== NULL)
                <div class="col-4 col-md-4 col-sm-12 mb-3 mt-4">
                    <a class="btn btn-sm btn-primary btn-block p-2" href=" {{ route('event.create.page') }}"><i class="fas fa-plus-circle"></i> Create New Event</a>
                </div>
                @endif

                <div class="col-12 ">

                <table id="eventTable" width="100%" border="1" style="border-collapse: collapse;" class ="table table-bordered">
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
                        {   data: "id" },
                        {   data: "name" },
                        {   data: "slug" },
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
                        }, {
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
                                const userAuth = "{{ Auth::user() }}";


                                console.log(userAuth);

                                let editEventButtons = userAuth != "" ? `<span data-name="edit-events"
                                       data-toggle="tooltip"
                                       data-placement="bottom"
                                       title="Edit Event Details" >
                                    <i  class="fa fa-edit mr-2 text-primary"
                                        data-id="${eventId}"
                                        data-name="${eventName}"
                                        style="cursor: pointer"
                                     ></i>
                                </span>` : ``;

                                let deleteEventButtons = userAuth != "" ? `<span data-name="delete-events"
                                       data-toggle="tooltip"
                                       data-placement="bottom"
                                       title="Delete Event" >
                                    <i  class="fa fa-trash mr-2 text-danger"
                                        data-id="${eventId}"
                                        data-name="${eventName}"
                                        style="cursor: pointer"
                                     ></i>
                                </span>` : ``;

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
    @endsection