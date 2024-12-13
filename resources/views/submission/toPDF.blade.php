<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Service Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            border-bottom: 1px solid #000;

        }

        .header .kiri img {
            width: 100px;
        }

        .header .kanan {
            text-align: right;
            font-size: 12px;
        }

        h1 {
            margin-top: 20px;
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

    <h1>Repairment Report</h1>

    <div class="section">
        <h3>Reason Of Visit</h3>
        <table>
            <thead>
                <tr>
                    <th>Room</th>
                    <th>Item Name</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detailsWithWorkHours as $d)
                    <tr>
                        <td>{{ $d['detail']->itemUnit->rooms->name }}</td>
                        <td>{{ $d['detail']->itemUnit->items->item_name }}</td>
                        <td>{{ $d['detail']->description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h3>Activity</h3>
        @foreach ($detailsWithWorkHours as $d)
            <table>
                <thead>
                    <tr>
                        <th>Detail Activity</th>
                        {{-- <th>Remarks</th> --}}
                        {{-- <th>Evidence</th>  --}}
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $d['detail']->itemUnit->items->item_name }}</td>
                        {{-- <td>{{ $d['detail']->remarks }}</td> --}}
                        {{-- <td><img src="{{ public_path('temp/' . $d['detail']->evidence) }}" alt="evidence"
                                width="100" height="100"></td> --}}
                    </tr>
                </tbody>
            </table>
            
            <table>
                <thead>
                    <tr>
                        {{-- <th>Item Name</th> --}}
                        <th>Remarks</th>
                        {{-- <th>Evidence</th>  --}}
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        {{-- <td>{{ $d['detail']->itemUnit->items->item_name }}</td> --}}
                        <td>{{ $d['detail']->remarks }}</td>
                        {{-- <td><img src="{{ public_path('temp/' . $d['detail']->evidence) }}" alt="evidence"
                                width="100" height="100"></td> --}}
                    </tr>
                </tbody>
            </table>

            <h4>Evidance From Technician</h4>
            <ul style="list-style: none;">
                @if (count($d['detail']->evidenceTechnician) == 0 && isset($d['detail']->evidenceTechnician))
                    <li>No evidence</li>
                @else
                    @foreach ($d['detail']->evidenceTechnician as $eT)
                        <li><img src="{{ public_path($eT->evidence) }}" alt="evidence" width="100"
                                height="100"></li>
                    @endforeach
                @endif
            </ul>

            <p><strong>Work Hours:</strong> 1 hours, 2 minutes</p>
        @endforeach
    </div>

    <div class="section">
        <h3>Sparepart Used</h3>
        <ul>
            -
        </ul>
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
                @foreach ($detailsWithWorkHours as $d)
                    <tr>
                        <td>2024-12-12 16:15:00</td>
                        <td>{{ $d['technician'] }}</td>
                        <td>2024-12-12 16:15:00</td>
                        <td>2024-12-12 17:17:00</td>
                        <td>1</td>
                        <td>2</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="technician-signature" style="margin-left: 20px; margin-right: 20px">
        <div class="kiri">
            <p>Bandung, {{ date('d F Y') }}</p>
            <br>
            <br>
            <br>
            <p><strong>{{ $detailsWithWorkHours[0]['technician'] }}</strong></p>
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
</body>

</html>
