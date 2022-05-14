<?php
echo str_replace("{{year}}", date("Y"), file_get_contents(CONTENT_DIRECTORY_PATH."/footer.html"));
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="/js/app.js"></script>
