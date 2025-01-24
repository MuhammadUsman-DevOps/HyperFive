<!-- resources/views/config.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Config Form</title>
</head>
<body>

    <h1>Config Data from VM</h1>

    <form action="" method="POST">
        @csrf
        @foreach ($yamlContent as $key => $value)
    <div>
        <label for="{{ $key }}">{{ ucfirst($key) }}:</label>
        @if (is_array($value))
            <!-- If value is an array, render a dropdown -->
            <select name="{{ $key }}" id="{{ $key }}">
                @foreach ($value as $subKey => $subValue)
                    <option value="{{ $subKey }}" {{ old($key) == $subKey ? 'selected' : '' }}>{{ $subValue }}</option>
                @endforeach
            </select>
        @else
            <!-- If value is a string, render an input field -->
            <input type="text" name="{{ $key }}" id="{{ $key }}" value="{{ old($key, htmlspecialchars($value)) }}">
        @endif
    </div>
@endforeach
        <button type="submit">Save Config</button>
    </form>

</body>
</html>