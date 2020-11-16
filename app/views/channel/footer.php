<?php
$footerFile = "app/views/$this->_controller/$page/footer.php";
if (is_file($footerFile)) {
    include_once $footerFile;
}
else
{
?>

<div class="modal"  id="AddChannelModal" data-modal="AddChannelModal">
    <div class="box-m">
        <div class="box-header">
            <h3>Add Channel</h3>
        </div>
        <div class="box-body">
            <form action="/channel/add" method="post">
            <table class="c-container">
                <tbody>
                    <tr>
                        <td class="t-right">Channel Name:</td>
                        <td><input name='name' type="text" required autofocus autocomplete="off"></td>
                    </tr>
                    <tr>
                        <td>Public:</td>
                        <td><input type="checkbox" name="isPublic" checked></td>
                    </tr>
                    <tr>
                        <td align="center" colspan=2>
                            <p><?php if(isset($msg)) print $msg; ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" colspan=2>
                            <input type="submit" value="Add">
                        </td>
                    </tr>
                </tbody>
            </table>
            </form>
        </div>
    </div>
</div>
<?php
}
?>