<!DOCTYPE html>
<html lang="en">

<head>
    <title>Service Report</title>
    <style>
        @page {
            margin: 0cm 0cm;
        }
        
        body {
            font-family: Arial, sans-serif;
            margin-top: 6.5cm;
            margin-left: 1cm;
            margin-right: 1cm;
            margin-bottom: 2cm;
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 4cm;
            padding: 0px 50px 0px 50px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            border-bottom: 1px solid #000;
        }

        h1 {
            margin-top: -30px;
            text-align: center;
            width: 100%;
            font-size: 18px;
            font-weight: bold;
        }

        .section {
            margin: 20px;
        }

        .section h3 {
            margin-bottom: 10px;
            font-size: 16px;
        }

        .section ul {
            margin: 0;
            padding: 0 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        col {
            flex: 0 0 30%;
            max-width: 30%;
            padding: 5px;
        }

        .technician-signature {
            margin-top: 20px;
            text-align: center;
        }

        .technician-signature p {
            margin: 2px 0;
        }

        .technician-signature .kiri {
            float: left;
        }

        .technician-signature .kanan {
            float: right;
        }
    </style>
</head>

<body>
    <header>
        <div class="header">
            <table style="border-collapse: collapse; width: 100%; border: none;">
                <tr>
                    <td rowspan="3" style="border: none; padding: 0; margin:0;">
                        <img src="{{ public_path('images/rslogo2.jpg') }}" alt="logo" width="150">
                    </td>
                    <td style="text-align: right; border: none; padding: 0; margin:0;">
                        <h2>Oetomo Hospital</h2>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right; border: none; padding: 0; margin:0;">
                        <p>Jl. Raya Bojongsoang No.156, Bandung 40287</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right; border: none; padding: 0; margin:0;">
                        <p>Telp. (022) 87538888</p>
                    </td>
                </tr>
            </table>
        </div>
    </header>

    <main class="content">
        <h1>Repairment Report</h1>
    
        <div class="section">
            <h3>Reason of visit</h3>
            <table>
                <thead>
                    <tr>
                        <th>Room</th>
                        <th>Item Name</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $detail->itemUnit->rooms->name }}</td>
                        <td>{{ $detail->itemUnit->items->item_name }}</td>
                        <td>{{ $detail->description }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    
        <div class="section">
            <h3>Activity</h3>
            <table>
                <thead>
                    <tr>
                        <th><strong>Detail Activity</strong></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <ul>
                                @foreach ($repairLog as $activity)
                                    <li>{{ $activity->desc }} at: {{ $activity->created_at }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table>
                <thead>
                    <tr>
                        <th><strong>Remarks</strong></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $detail->remarks ?? 'No Remarks' }}</td>
                    </tr>
                </tbody>
            </table>
    
            <h4>Evidance From Technician</h4>
            <div class="row">
                @if (count($detail->evidenceTechnician) == 0 && isset($detail->evidenceTechnician))
                    <col>No evidence</col>
                @else
                    @foreach ($detail->evidenceTechnician as $eT)
                        <col><img src="{{ public_path($eT->evidence) }}" alt="evidence" width="100" height="100">
                        </col>
                    @endforeach
                @endif
            </div>
    
            <p><strong>Work Hours:</strong>{{ $workHour['hours'] }} hour(s), {{ $workHour['minutes'] }} minute(s)</p>
        </div>
    
        <div class="section">
            <h3>Sparepart Used</h3>
            <table>
                <thead>
                    <tr>
                        <th>Sparepart Name</th>
                        <th>Serial Number</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($detail->sparepartsOfRepair) == 0)
                        <tr>
                            <td colspan="3">No sparepart used</td>
                        </tr>
                    @endif
                    @foreach ($detail->sparepartsOfRepair as $sparepart)
                        <tr>
                            <td>{{ $sparepart->sparepart->name }}</td>
                            <td>{{ $sparepart->sparepart->serial_no }}</td>
                            <td>{{ $sparepart->sparepart->description }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    
        <div class="section">
            <h3>Technician Detail</h3>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Technician Name</th>
                        <th>Start Date</th>
                        <th>Finish Date</th>
                        <th>Hours</th>
                        <th>Minutes</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < count($workHour['hoursArr']); $i++)
                        <tr>
                            <td>{{ $detail->created_at }}</td>
                            <td>{{ $detail->technician->name }}</td>
                            <td>{{ $workHour['start'] }}</td>
                            <td>{{ $workHour['start']->day == $workHour['end']->day ? $workHour['end'] : $workHour['start']->copy()->hour(17)->minute(0)->second(0) }}
                            </td>
                            <td>{{ $workHour['hoursArr'][$i] }}</td>
                            <td>{{ $workHour['minutesArr'][$i] }}</td>
                        </tr>
                        @php
                            $workHour['start']->addDay()->hour(8)->minute(0)->second(0);
                            if ($workHour['start']->isWeekend()) {
                                $workHour['start']->nextWeekday()->hour(8)->minute(0)->second(0);
                            }
                        @endphp
                    @endfor
                </tbody>
            </table>
        </div>
    
        <div class="technician-signature" style="margin-left: 20px; margin-right: 20px">
            <div class="kiri">
                <p>Bandung, {{ date('d F Y') }}</p>
                <br>
                <br>
                <br>
                <p><strong>{{ $detail->technician->name }}</strong></p>
                <p style="margin-top: 0">Technician</p>
            </div>
            <div class="kanan">
                <p>Acknowledged,</p>
                <br>
                <br>
                <br>
                <br>
            </div>
        </div>
    </main>

</body>

</html>