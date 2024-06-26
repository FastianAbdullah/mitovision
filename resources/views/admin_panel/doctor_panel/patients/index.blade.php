@extends('layouts.doctor.app')

@section('content')
    <div class="container-xl">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>Manage <b>Patients</b></h2>
                        </div>
                        <div class="col-sm-6">
                            <a href="#addPatientModal" class="btn btn-success" data-toggle="modal"><i
                                    class="material-icons">&#xE147;</i> <span>Add New Patient</span></a>
                            <a href="#" id="deleteAll" class="btn btn-danger btn-hide" data-toggle="modal" disabled>
                                <i class="material-icons">&#xE15C;</i> <span>Delete All</span>
                            </a>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>
                                <span class="custom-checkbox">
                                    <input type="checkbox" id="selectAll">
                                    <label for="selectAll"></label>
                                </span>
                            </th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Blood Group</th>
                            <th>Gender</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Iterate through the patient data and display each row -->
                        @foreach ($patients as $patient)
                            <tr>
                                <td>
                                    <input type="checkbox" class="record-checkbox" id="checkbox{{ $patient->id }}"
                                        name="options[]" value="{{ $patient->id }}">
                                </td>
                                <td>{{ $patient->name }}</td>
                                <td>{{ $patient->phone }}</td>
                                <td>{{ $patient->blood_group }}</td>
                                <td>{{ $patient->gender }}</td>
                                <td>{{ $patient->address }}</td>
                                <td>
                                    <a href="#" class="edit" data-toggle="modal"
                                        data-target="#editPatientModal-{{ $patient->id }}" data-id="{{ $patient->id }}"
                                        data-name="{{ $patient->name }}" data-phone="{{ $patient->phone }}"
                                        data-blood_group="{{ $patient->blood_group }}"
                                        data-gender="{{ $patient->gender }}" data-address="{{ $patient->address }}">
                                        <i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i>
                                    </a>
                                    <a href="#" class="delete" data-toggle="modal"
                                        data-target="#deletePatientModal-{{ $patient->id }}"
                                        data-id="{{ $patient->id }}">
                                        <i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i>
                                    </a>
                                </td>
                            </tr>

                            <!-- Add/Edit Patient Modals -->
                            <!-- Edit Patient Modal -->
                            <div id="editPatientModal-{{ $patient->id }}" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.doctors.patients.update', ['id' => $patient->id]) }}"
                                            method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Patient</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                @if ($errors->any())
                                                    <div class="alert alert-danger">
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" class="form-control" name="name"
                                                        value="{{ $patient->name }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Phone</label>
                                                    <input type="text" class="form-control" name="phone"
                                                        value="{{ $patient->phone }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Blood Group</label>
                                                    <input type="text" class="form-control" name="blood_group"
                                                        value="{{ $patient->blood_group }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Gender</label>
                                                    <input type="text" class="form-control" name="gender"
                                                        value="{{ $patient->gender }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <textarea class="form-control" name="address" required>{{ $patient->address }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-info">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Patient Modal -->
                            <div id="deletePatientModal-{{ $patient->id }}" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.doctors.patients.delete', ['id' => $patient->id]) }}"
                                            method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h4 class="modal-title">Delete Patient</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete this record?</p>
                                                <p class="text-warning"><small>This action cannot be undone.</small></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>

                {{-- <div class="rand">
                <span style="text-align: center;">
                    <!-- Pagination links -->
                    {{$patients->links()}}
                </span>
            </div> --}}
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Activate tooltip

            $('[data-toggle="tooltip"]').tooltip();

            // Select/Deselect checkboxes
            var checkbox = $('table tbody input[type="checkbox"]');
            $("#selectAll").click(function() {
                $("#deleteAll").toggleClass("btn-hide");

                if (this.checked) {
                    checkbox.each(function() {
                        this.checked = true;
                    });
                } else {
                    checkbox.each(function() {
                        this.checked = false;
                    });
                }
            });
            checkbox.click(function() {

                if (!this.checked) {
                    $("#selectAll").prop("checked", false);
                }
                toggleDeleteAllVisibility();
            });

            function toggleDeleteAllVisibility() {

                var selectedCheckboxCount = $('table tbody input[type="checkbox"]:checked').length;
                if (selectedCheckboxCount > 0) {
                    $("#deleteAll").removeClass("btn-hide");
                } else {
                    $("#deleteAll").addClass("btn-hide");
                }
            }
            // Function to handle "Delete All" button click
            $("#deleteAll").click(function() {

                var selectedIds = [];
                // Loop through checkboxes and collect IDs of selected records
                $('table tbody input[type="checkbox"]').each(function() {
                    if (this.checked) {
                        // Adjusted selector to find the checkbox within the first column
                        selectedIds.push($(this).closest('tr').find(
                            'td:first-child input[type="checkbox"]').val());
                    }
                });

                // Log or use the selectedIds array as needed
                console.log(selectedIds);

                // Perform the AJAX request to delete records
                // $.ajax({
                //     url: '/deletion',
                //     method: 'POST',
                //     data: {
                //         _token: '{{ csrf_token() }}',
                //         idsToDelete: selectedIds
                //     },
                //     success: function(response) {
                //         console.log(response.message);
                //         // Optionally, perform any additional actions after deletion
                //         window.location.href = '/employes';
                //     },
                //     error: function(error) {
                //         console.error('Error deleting employees:', error);
                //     }
                // });
            });

            $('#addEmployeeModal').submit(function(event) {
                // Prevent form submission
                event.preventDefault();

                // Validate phone number
                var phone = $('#phone').val();

                if (phone.length !== 9) {
                    alert('Please enter a valid 9-digit phone number.');

                } else {
                    // If validation passes, submit the form
                    $(this).unbind('submit').submit();
                }
            });

        });
    </script>
    <style>
        body {
            color: #566787;
            background: #f5f5f5;
            font-family: 'Varela Round', sans-serif;
            font-size: 13px;
        }

        .table-responsive {
            margin: 30px 0;
        }

        .table-wrapper {
            background: #fff;
            padding: 20px 25px;
            border-radius: 3px;
            min-width: 1000px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        }

        .table-title {
            padding-bottom: 15px;
            background: #435d7d;
            color: #fff;
            padding: 16px 30px;
            min-width: 100%;
            margin: -20px -25px 10px;
            border-radius: 3px 3px 0 0;
        }

        .table-title h2 {
            margin: 5px 0 0;
            font-size: 24px;
        }

        .table-title .btn-group {
            float: right;
        }

        .table-title .btn {
            color: #fff;
            float: right;
            font-size: 13px;
            border: none;
            min-width: 50px;
            border-radius: 2px;
            border: none;
            outline: none !important;
            margin-left: 10px;
        }

        .table-title .btn i {
            float: left;
            font-size: 21px;
            margin-right: 5px;
        }

        .table-title .btn span {
            float: left;
            margin-top: 2px;
        }

        table.table tr th,
        table.table tr td {
            border-color: #e9e9e9;
            padding: 12px 15px;
            vertical-align: middle;
        }

        table.table tr th:first-child {
            width: 60px;
        }

        table.table tr th:last-child {
            width: 100px;
        }

        table.table-striped tbody tr:nth-of-type(odd) {
            background-color: #fcfcfc;
        }

        table.table-striped.table-hover tbody tr:hover {
            background: #f5f5f5;
        }

        table.table th i {
            font-size: 13px;
            margin: 0 5px;
            cursor: pointer;
        }

        table.table td:last-child i {
            opacity: 0.9;
            font-size: 22px;
            margin: 0 5px;
        }

        table.table td a {
            font-weight: bold;
            color: #566787;
            display: inline-block;
            text-decoration: none;
            outline: none !important;
        }

        table.table td a:hover {
            color: #2196F3;
        }

        table.table td a.edit {
            color: #FFC107;
        }

        table.table td a.delete {
            color: #F44336;
        }

        table.table td i {
            font-size: 19px;
        }

        table.table .avatar {
            border-radius: 50%;
            vertical-align: middle;
            margin-right: 10px;
        }

        .pagination {
            float: right;
            margin: 0 0 5px;
        }

        .pagination li a {
            border: none;
            font-size: 13px;
            min-width: 30px;
            min-height: 30px;
            color: #999;
            margin: 0 2px;
            line-height: 30px;
            border-radius: 2px !important;
            text-align: center;
            padding: 0 6px;
        }

        .pagination li a:hover {
            color: #666;
        }

        .pagination li.active a,
        .pagination li.active a.page-link {
            background: #03A9F4;
        }

        .pagination li.active a:hover {
            background: #0397d6;
        }

        .pagination li.disabled i {
            color: #ccc;
        }

        .pagination li i {
            font-size: 16px;
            padding-top: 6px
        }

        .hint-text {
            float: left;
            margin-top: 10px;
            font-size: 13px;
        }

        /* Custom checkbox */
        .custom-checkbox {
            position: relative;
        }

        .custom-checkbox input[type="checkbox"] {
            opacity: 0;
            position: absolute;
            margin: 5px 0 0 3px;
            z-index: 9;
        }

        .custom-checkbox label:before {
            width: 18px;
            height: 18px;
        }

        .custom-checkbox label:before {
            content: '';
            margin-right: 10px;
            display: inline-block;
            vertical-align: text-top;
            background: white;
            border: 1px solid #bbb;
            border-radius: 2px;
            box-sizing: border-box;
            z-index: 2;
        }

        .custom-checkbox input[type="checkbox"]:checked+label:after {
            content: '';
            position: absolute;
            left: 6px;
            top: 3px;
            width: 6px;
            height: 11px;
            border: solid #000;
            border-width: 0 3px 3px 0;
            transform: inherit;
            z-index: 3;
            transform: rotateZ(45deg);
        }

        .rand {
            margin: auto;
            width: fit-content;
            /* Adjust the width as needed */
        }

        .w-5 {
            display: none;
        }

        .custom-checkbox input[type="checkbox"]:checked+label:before {
            border-color: #03A9F4;
            background: #03A9F4;
        }

        .custom-checkbox input[type="checkbox"]:checked+label:after {
            border-color: #fff;
        }

        .custom-checkbox input[type="checkbox"]:disabled+label:before {
            color: #b8b8b8;
            cursor: auto;
            box-shadow: none;
            background: #ddd;
        }

        /* Modal styles */
        .modal .modal-dialog {
            max-width: 400px;
        }

        .modal .modal-header,
        .modal .modal-body,
        .modal .modal-footer {
            padding: 20px 30px;
        }

        .modal .modal-content {
            border-radius: 3px;
            font-size: 14px;
        }

        .modal .modal-footer {
            background: #ecf0f1;
            border-radius: 0 0 3px 3px;
        }

        .modal .modal-title {
            display: inline-block;
        }

        .modal .form-control {
            border-radius: 2px;
            box-shadow: none;
            border-color: #dddddd;
        }

        .default {
            font-size: 50px;
            color: red;
        }

        .modal textarea.form-control {
            resize: vertical;
        }

        .modal .btn {
            border-radius: 2px;
            min-width: 100px;
        }

        .modal form label {
            font-weight: normal;
        }

        .btn-hide {
            display: none;
        }
    </style>
@endsection
