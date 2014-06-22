<p class="head">Користувачі групи</p>
<!-- наповнення -->
<div class="page">
    <table>
        <col width="100">
        <col width="100">
        <col width="50">
        <tr><td>Ім' . "'" . 'я корист.</td><td>Права</td><td>Відміт.</td></tr>

        <?php g_users_list(); ?>

    </table>
</div>
<!-- кінець наповнення -->
<div class="downtitle">
    <p class="instring"><input type="text" class="findfild" name="username"
                               value="' . $_POST['username'] . '"/></p>  <!-- поле пошуку -->
    <p style="margin-top: 5px">														<!-- кнопочки -->
        <input type="submit" class="button" value="Знайти" name="finduser" />
        <input type="submit" class="button" value="Видалити" name="delus" />
    </p>
</div>