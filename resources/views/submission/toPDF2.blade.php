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
        <h3>Pengajuan Perbaikan</h3>
        <table>
            <tr>
                <td><strong>Ruangan:</strong></td>
                <td>{{ $detail->itemUnit->rooms->name }}</td>
            </tr>
            <tr>
                <td><strong>Alat:</strong></td>
                <td>{{ $detail->itemUnit->items->item_name }}</td>
            </tr>
            <tr>
                <td><strong>No Seri:</strong></td>
                <td>{{ $detail->itemUnit->serial_number }}</td>
            </tr>
            <tr>
                <td><strong>Deskripsi:</strong></td>
                <td>{{ $detail->description }}</td>
            </tr>
            <tr>
                <td><strong>Evidence:</strong></td>
                <td>
                    @if ($detail->evidence || $detail->evidence != '')
                        <img src="{{ public_path('temp/' . $detail->evidence) }}" alt="evidence" width="100"
                            height="100">
                    @else
                        No evidence
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h3>Activity</h3>
        <p>Hours: {{ $workHour['hours'] }}</p>
        <p>Minutes: {{ $workHour['minutes'] }}</p>
    </div>

    <div class="section">
        <h3>Sparepart Used</h3>
        <ul>
            @foreach ($detail->sparepartsOfRepair as $sparepart)
                <li>{{ $sparepart->sparepart->name }} - {{ $sparepart->quantity }}</li>
            @endforeach
        </ul>
    </div>

    <div class="section">
        <h3>Technician Detail</h3>
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
</body>

</html>
