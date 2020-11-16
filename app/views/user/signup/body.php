<div class="box-m">
    <div class="box-header">
        <h3>Add User</h3>
    </div>
    <div class="box-body">
        <form action="/user/signup" method="post">
        <table class="c-container">
            <tbody>
                <tr>
                    <td class="t-right" style="width:135px;">User:</td>
                    <td><input style="min-width:160px;" name='user' type="text" required autofocus autocomplete="off"></td>
                </tr>
                <tr>
                    <td class="t-right" style="width:135px;">Password:</td>
                    <td><input style="min-width:160px;" name='psw' type="password" required></td>
                </tr>
                <tr>
                    <td class="t-right" style="width:135px;">Confirm Password:</td>
                    <td><input style="min-width:160px;" name='ag-psw' type="password" required></td>
                </tr>
                <tr>
                    <td align="center" colspan=2>
                        <p style="color:red"><?php if(isset($msg)) print $msg; ?></p>
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan=2>
                        <input type="submit" value="Sign Up">
                    </td>
                </tr>
            </tbody>
        </table>
        </form>
    </div>
</div>