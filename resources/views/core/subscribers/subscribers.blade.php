<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscribers</title>
</head>
<body>
<h2>Subscriber List</h2>

@if(session('error'))
    <p style="color: red;">{{ session('error') }}</p>
@endif

<table border="1">
    <thead>
    <tr>
        <th>PLMN ID</th>
        <th>UE ID</th>
    </tr>
    </thead>
    <tbody>
    @foreach($subscribers as $subscriber)
        <tr>
            <td>{{ $subscriber['plmnID'] }}</td>
            <td>{{ $subscriber['ueId'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<br>
<a href="{{ route('dashboard') }}">Back to Dashboard</a>
<a href="{{ route('logout') }}">Logout</a>
</body>
</html>
