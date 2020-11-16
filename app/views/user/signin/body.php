<div class="box-m">
    <div class="box-header">
        <h3>Sign In</h3>
    </div>
    <div class="box-body">
        <form action="/user/signin" method="post">
        <table class="c-container">
            <tbody>
                <tr>
                    <td class="t-right" style="width:110px;">User:</td>
                    <td><input style="min-width:160px;" name='user' type="text" required autofocus autocomplete="off"></td>
                </tr>
                <tr>
                    <td class="t-right" style="width:110px;">Password:</td>
                    <td><input style="min-width:160px;" name='psw' type="password" required></td>
                </tr>
                <tr>
                    <td align="center" colspan=2>
                        <p style="color:red"><?php if(isset($msg)) print $msg; ?></p>
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan=2>
                        <input type="submit" value="Sign In">
                    </td>
                </tr>
            </tbody>
        </table>
        </form>
    </div>
</div>