<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Event QR Codes</title>
    <style>
        hr.dotted {
            border: none;
            border-top: 1px dotted black;
            color: #000;
            background-color: #fff;
            height: 1px;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* Creates 2 equal columns */
            gap: 5px; /* Space between columns */
        }

        .grid-item {
            padding: 2px; /* Adjust padding as needed */
            box-sizing: border-box;
        }
    </style>
</head>

<body>
<img alt="logo" src="{{ public_path('images/nachologo.png') }}" style="margin-left: 15px" width="200" height="200"/>
<h2>Event Ticket Data</h2>
@for($i=0;$i<sizeof($codes['codes']); $i++)
    <div class="grid-container">
        <div class="grid-item">
            <img src="data:image/png;base64,{{ $codes['codes'][$i] }}" alt="QR Code">
        </div>
        <div class="grid-item">
            <p>Event Name: {{$codes['tickets'][$i]->eventName}}</p>
            <p>Event Venue:{{$codes['tickets'][$i]->eventVenue}}</p>
            <p>Event Date: {{$codes['tickets'][$i]->eventDate}}</p>
            <p>Event Start Time:{{\Carbon\Carbon::parse($codes['tickets'][$i]->startTime)->format('H:s a')}}</p>
            <p>Event End Time:{{\Carbon\Carbon::parse($codes['tickets'][$i]->endTime)->format('H:s a')}}</p>
        </div>
    </div>
    <hr class="dotted"/>
@endfor
</body>
</html>
