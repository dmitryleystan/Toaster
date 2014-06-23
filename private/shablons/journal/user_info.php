<p class="head"><?php echo $user[1]; ?></p>

<div id="info">
    <p>Прізвище:</p>
    <p><input type="text" name="userfname" value="<?php echo $user[3][0]; ?>" /></p>
    <p>Імя:</p>
    <p><input type="text" name="userlname" value="<?php echo $user[3][1]; ?>" /></p>
    <p>По-батькові:</p>
    <p><input type="text" name="userfathname" value="<?php echo  $user[3][2]; ?>" /></p>
    <p><a href="./reg/change_user_psw.php?uid=' . $us -> uid . '">Змінити пароль</a></p>
    <p>Групи до яких належить користувач:</p>
    <p>
        <?php echo $user[2]; ?>
    </p>
</div>

<p style="margin-top: 125px">														<!-- кнопочки -->
    <input type="submit" class="button" value="Зберегти" name="saveusinf" />
</p>