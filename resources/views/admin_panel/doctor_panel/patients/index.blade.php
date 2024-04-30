
@extends('layouts.doctor.app')

@section('content')

<div id="patientsTable class">
    <div class="container">
        <h2>Patients Table</h2>
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Phone</th>
                    <th>Name</th>
                    <th>Number</th>
                    <th>Blood Group</th>
                    <th>Gender</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                <!-- Iterate through the patient data and display each row -->
                @foreach($patients as $patient)
                <tr>
                    <td>{{ $patient->phone }}</td>
                    <td>{{ $patient->name }}</td>
                    <td>{{ $patient->number }}</td>
                    <td>{{ $patient->blood_group }}</td>
                    <td>{{ $patient->gender }}</td>
                    <td>{{ $patient->address }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


@endsection