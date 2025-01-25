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
        @php
                    // Recursive function to render inputs
                    function renderInputs($yamlContent, $parentKey = '')
                    {
                        foreach ($yamlContent as $key => $value) {
                            $fieldName = $parentKey ? $parentKey . '[' . $key . ']' : $key;

                            if (is_array($value)) {
                                echo "<label><strong>$key</strong></label>";
                                echo "<div style='margin-left: 20px;'>";
                                renderInputs($value, $fieldName);
                                echo "</div>";
                            } else {
                                echo "<div class='mb-3'>";
                                echo "<label for='$fieldName'>$key</label>";
                                echo "<input type='text' class='form-control' name='$fieldName' value='" . htmlspecialchars($value, ENT_QUOTES) . "'>";
                                echo "</div>";
                            }
                        }
                    }

                    renderInputs($yamlContent);
                @endphp
        <button type="submit">Save Config</button>
    </form>

</body>
</html>