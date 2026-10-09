<footer>
    <p>&copy; 2026 TASKU-Mini &mdash; Jobsheet 11</p>
</footer>

<script src="<?php echo $base; ?>assets/app.js"></script>
<?php
if (!empty($extra_scripts)) {
    foreach ($extra_scripts as $src) {
        echo '<script src="' . e($src) . '"></script>';
    }
}
?>
</body>
</html>