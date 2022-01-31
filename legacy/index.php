<?php

$request_uri = $_SERVER['REQUEST_URI'] ?? '';

echo "Hello from the old legacy app.<br>";
if ($request_uri) {
    echo "Looking for {$request_uri} by any chance?";
}
