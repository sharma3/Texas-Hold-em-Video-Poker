<div align="center">
<form method=post action=main.php name=register>
<? hidden_field("act",$act); ?>
<? hidden_field("sact","save"); ?>
  <table border="0" width="80%" class="form_lbl">
		<tr>
      <td width="100%" height=40>
				<b><font face="Verdana" color="#74468f" size="4">
					Register an account
				</font></b></span>
			</td>
		</tr>
		<tr>
      <td width="100%">
				<b>Fields marked with asterisk (<span class="err_txt">*</span>)
        are compulsory. This information is a must for successful account creation.
			</td>
    </tr>
    <tr>
      <td width="100%">
        <table border="0" width="100%" class="form_lbl">
          <tr>
            <td width="50%" align="right">Choose a Sign in ID <span class="err_txt">*</span></td>
            <td width="50%"><input type="text" name="fields_p[login]" value="<? echo $fields_p['login']; ?>" size=20></font></td>
          </tr>
          <tr><td colspan=2>
						<font size=1>Carefully choose your password you will have to remember it, since we not collecting your email we have no way of sending you your passsword if you lost it.</font>
					</td></tr>
					<tr>
            <td align="right">Choose a password <span class="err_txt">*</span></td>
            <td><input type="password" name="fields_p[password]" value="" size=20></font></td>
          </tr>
          <tr>
            <td align="right">Retype password <span class="err_txt">*</span></td>
            <td><input type="password" name="rpassword" value="" size=20></font></td>
          </tr>
          <tr>
            <td colspan="2" align="center"><input type="submit" value="Now Time To Play " name="submit"></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</div>
