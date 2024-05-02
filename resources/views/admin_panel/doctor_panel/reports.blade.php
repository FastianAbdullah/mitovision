@extends('layouts.doctor.app')

@section('content')
    <div class="container-xl">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>Manage <b>Reports</b></h2>
                        </div>
                    </div>
                </div>
                <table id="example" class="table table-striped table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Doctor</th>
                            <th>Patient Name</th>
                            <th>Patient Gender</th>
                            <th>Patient BloodGroup</th>
                            <th>Description</th>
                            <th>Prediction</th>
                            <th>Result Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $report)
                            <tr>
                                <td>{{ $report->id }}</td>
                                <td>{{ $report->user->name }}</td>
                                <td>{{ $report->image->patient->name }}</td>
                                <td>{{ $report->image->patient->gender }}</td> <!-- New column: Patient Gender -->
                                <td>{{ $report->image->patient->blood_group }}</td> <!-- New column: Patient BloodGroup -->
                                <td>{{ $report->description }}</td>
                                <td>{{ $report->prediction }}</td>
                                <td>{{ $report->result_time }}</td>
                                <td>
                                    <!-- Edit button -->
                                    <a href="#" class="edit" data-toggle="modal"
                                        data-target="#editReportModal-{{ $report->id }}" data-id="{{ $report->id }}"
                                        data-prediction="{{ $report->prediction }}"
                                        data-result_time="{{ $report->result_time }}"
                                        data-user="{{ $report->user->name }}"
                                        data-patient="{{ $report->image->patient->name }}"
                                        data-description="{{ $report->description }}">
                                        <i class="material-icons" data-toggle="tooltip" title="Edit">edit</i>
                                    </a>

                                </td>
                            </tr>

                            <!-- Edit Report Modal -->
                            <div id="editReportModal-{{ $report->id }}" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form
                                            action="{{ route('admin.doctors.patients.reports.update', ['id' => $report->id]) }}"
                                            method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Report</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Display all fields for editing -->
                                                <div class="form-group">
                                                    <label>Doctor</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $report->user->name }}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Patient</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $report->image->patient->name }}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Prediction</label>
                                                    <input type="text" class="form-control" name="prediction"
                                                        value="{{ $report->prediction }}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Result Time</label>
                                                    <input type="text" class="form-control" name="result_time"
                                                        value="{{ $report->result_time }}" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <textarea class="form-control" name="description">{{ $report->description }}</textarea>
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <script>
        var table = new DataTable('#example', {
            layout: {
                bottomEnd: {
                    paging: {
                        boundaryNumbers: false
                    }
                },
                topStart: {
                    buttons: ['csv', {
                        extend: 'pdf',
                        customize: function(doc) {
                            // Set document title
                            doc.content[0].text = 'Mitosis Detection System';
                            doc.content[0].alignment = 'center';

                            // Add clear line separator
                            makeline(doc);

                            // Make table headers bold
                            doc.content[2].table.headerRows = 1; // Set the number of header rows
                            doc.content[2].table.widths = ['*', '*', '*', '*', '*', '*',
                                '*'
                            ]; // Adjust column widths if needed
                            doc.content[2].table.body[0].forEach(function(header) {
                                header.bold = true;
                            });

                            // Example custom styling


                            // Remove 'Description' column if it exists
                            var columnCount = doc.content[2].table.body[0].length;
                            for (var i = 0; i < columnCount; i++) {
                                if (doc.content[2].table.body[0][i].text === 'Description') {
                                    doc.content[2].table.body.forEach(function(row) {
                                        row.splice(i, 1);
                                    });
                                    break;
                                }
                            }

                            // Remove 'Actions' column if it exists
                            for (var i = 0; i < columnCount; i++) {
                                if (doc.content[2].table.body[0][i].text === 'Actions') {
                                    doc.content[2].table.body.forEach(function(row) {
                                        row.splice(i, 1);
                                    });
                                    break;
                                }
                            }
                            

                            doc.content.push({
                                text: 'Final Report Result',
                                style: 'sectionHeader',
                                margin: [0, 20, 0, 10]
                            });



                            var reportResult = '';
                            var tableBody = doc.content[2].table.body;
                            var mitosisDetected = false;

                            for (var i = 1; i < tableBody.length; i++) { // Skip header row
                                var prediction = tableBody[i][5].text; // Prediction column

                                reportResult = prediction === 'mitosis' ? 'Mitosis' : 'Normal';


                                var style = prediction === 'mitosis' ? 'finalResultMitosis' :
                                    'finalResultNormal';

                                if (prediction === 'mitosis') {
                                    mitosisDetected = true;
                                    doc.content.push({
                                        text: reportResult,
                                        style: style
                                    });
                                    doc.content.push({
                                        text: 'Visit Mitovision Labs as soon as possible.',
                                        style: 'description'
                                    });
                                    break; // Exit the loop if mitosis is detected
                                }
                            }

                            // If mitosis is not detected, push the last prediction result into the table
                            if (!mitosisDetected) {

                                doc.content.push({
                                    text: reportResult,
                                    style: style
                                });
                            }

                            doc.styles = {
                                title: {
                                    fontSize: 24,
                                    bold: true,
                                    margin: [0, 0, 0, 10],
                                    color: '#000000'
                                },
                                sectionHeader: {
                                    fontSize: 20,
                                    bold: true,
                                    margin: [0, 10, 0, 5],
                                    color: '#2196F3'
                                },
                                rowData: {
                                    fontSize: 12,
                                    margin: [0, 0, 0, 5],
                                    color: '#666666'
                                },
                                finalResultNormal: {
                                    fontSize: 15,
                                    color: '#008000', // Green color for Normal
                                    bold: true

                                },
                                finalResultMitosis: {
                                    fontSize: 15,
                                    color: '#FF0000', // Red color for Mitosis
                                    bold: true
                                },
                                description: {
                                    fontSize: 12,
                                    color: '#000000', // Custom color for description
                                    margin: [0, 10, 0, 0],

                                }
                            };




                        }
                    }]
                }
            }
        });

        function makeline(doc) {
            doc.content.splice(1, 0, {
                canvas: [{
                    type: 'line',
                    x1: 0,
                    y1: 0,
                    x2: 520,
                    y2: 0,
                    lineWidth: 1,
                    color: '#000000'
                }],
                margin: [5, 5, 10, 10]
            });
        }
    </script>

    <style>
        @media print {
            .edit {
                display: none;
            }
        }

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
