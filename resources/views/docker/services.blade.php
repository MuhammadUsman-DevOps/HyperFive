<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Docker Services</title>
</head>
<body>
<h1>Docker Services</h1>

<table border="1">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($services as $service)
        <tr>
            <td>{{ $service['id'] }}</td>
            <td>{{ $service['name'] }}</td>
            <td>{{ $service['status'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
