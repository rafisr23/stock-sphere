<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reports of Repairments</title>
</head>

<body>
    <h1>{{ $submission->unit->customer_name }}</h1>
    <h2>{{ $submission->room->name }}</h2>
    @foreach ($detailsWithWorkHours as $d)
        <p>Detail ID: {{ $d['detail']->id }}</p>
        <p>Description: {{ $d['detail']->description }}</p>
        <p>Remarks: {{ $d['detail']->remarks }}</p>
        <p>Evidence: {{ $d['detail']->evidence }}</p>
        <p>Technician's evidence:</p>
        @foreach ($d['detail']->evidenceTechnician as $eT)
            <p>{{ $eT->evidence }}</p>
        @endforeach
        <p>Work Hours: {{ $d['workHours']['hours'] }} hours, {{ $d['workHours']['minutes'] }} minutes</p>
    @endforeach
</body>

</html>
