<p class="head">Користувачі</p>

<div class="page">
    <table>
        <col width="100">
        <col width="100">
        <col width="50">
        <tr><td>Ім'я корист.</td><td>Права</td><td>Відміт.</td></tr>

        <?php users_list($username); ?>

    </table>
</div>

<div class="downtitle">
    <p class="instring"><input type="text" class="findfild" name="username"
       value="<?php echo $_POST['username']; ?>"/></p>
    <p style="margin-top: 5px">
        <input type="submit" class="button" value="Знайти" name="finduser" />
        <input type="submit" class="button" value="Реєструвати" name="mreg" />
        <input type="submit" class="button" value="Видалити" name="delus" />
    </p>
</div>