
<?php if ($website['is-home']): ?>
    <div class="widget">
        <h3>Wydarzenia</h3>
        <?php
        require __DIR__ . '/upcomingEvents.php';
        ?>
    </div>
<?php endif; ?>

<div class="widget">
    <a name="newsletter" style="text-decoration: none;"><h3>Newsletter</h3></a>
    <?php
    require __DIR__ . '/newsletter.php';
    ?>
</div>

<div class="widget widget-social">
    <h3>Znajdź nas</h3>
    <p style="text-align:center;">
        <?php echo file_get_contents(CONTENT_DIRECTORY_PATH . '/social-icons.html'); ?>
    </p>
</div>

<?php
echo file_get_contents(CONTENT_DIRECTORY_PATH . "/sidebar.html");
?>