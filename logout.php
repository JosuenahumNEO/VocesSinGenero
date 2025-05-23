<?php
session_start();
session_unset();
session_destroy();
echo "<script>
    localStorage.removeItem('user');
    window.location.href = 'login.php';
</script>";
exit;
?>
