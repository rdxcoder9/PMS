<?php
register_shutdown_function(function () {
    $error = error_get_last();
    if ($error && $error['type'] === E_ERROR) {
        header("Location: error-500.php");
        exit;
    }
});

nonExistentFunction(); // This will cause a fatal error
?>
