<?php
$headerFile = "app/views/$this->_controller/$page/header.php";
if (is_file($headerFile)) {
    include_once $headerFile;
}
else
{
?>
<div class="inline">
    <h1>Self Channels</h1>
    <button
    class="right"
    id="AddChannelBtn"
    data-modal-btn="AddChannelModal"
    onclick="addModal(this)">
        <i class="fas fa-plus"></i> New Channel
    </button>
</div>
<hr>
<?php
}
?>