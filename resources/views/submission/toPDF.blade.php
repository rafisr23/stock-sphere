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
    <p>{{ $submission->unit->street }}</p>
    <p>{{ $submission->unit->city }}, {{ $submission->unit->postal_code }}</p>
    <h2>{{ $submission->room->name }}</h2>
    @foreach ($detailsWithWorkHours as $d)
        <table class="table table-bordered">
            <thead>
                <th>Item name</th>
                <th>Description</th>
                <th>Remarks</th>
                <th>Evidence</th>
            </thead>
            <tbody>
                <td>{{ $d['detail']->itemUnit->items->item_name }}</td>
                <td>{{ $d['detail']->description }}</td>
                <td>{{ $d['detail']->remarks }}</td>
                <td>{{ $d['detail']->evidence }}</td>
            </tbody>
            <thead>
                <th>
                    Evidence from technician
                </th>
            </thead>
            <tbody>
                @foreach ($d['detail']->evidenceTechnician as $eT)
                    <p>{{ $eT->evidence }}</p>
                @endforeach
            </tbody>
        </table>
        <p>Work Hours: {{ $d['workHours']['hours'] }} hours, {{ $d['workHours']['minutes'] }} minutes</p>
    @endforeach
</body>

</html>
