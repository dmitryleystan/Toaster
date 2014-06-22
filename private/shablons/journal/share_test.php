<p class="head">Групи</p>
<div class="page">
    <table>
        <col width="100">
        <col width="100">
        <col width="50">
        <tr><td>Ім'я групи.</td><td>К-сть учасн.</td><td>Відміт.</td></tr>

        <?php groups_list() ?>

    </table>
</div>

<div class="downtitle">
    <p class="instring"><input type="text" class="findfild" name="groupname" value="<?php echo $_POST['groupname'] ?>" /></p>
    <p style="margin-top: 5px">
        <input type="submit" class="button" value="Знайти" name="findgroup" />
        <input type="submit" class="button" value="Розшарити" name="sharetest" />
    </p>
</div>