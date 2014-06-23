<p class="head"><?php echo $test[1]; ?></p>

<div style = "height: 195px;">
    <p>Назва тесту:</p>
    <p><input type="text" name="testname" value="<?php echo $test[1]; ?>" /></p>
    <p>Предмет: <?php echo $test[3]; ?></p>
    <p>Групи для яких тест доступний(відмітьте які бажаєте видалити зі списку):</p>
    <table> <col width="30"> <col width="100">

    <?php group_test_list($test[0], $test[2]); ?>

    </table>
</div>

<p style="margin-top: 200px">
    <input type="submit" class="button" value="Зберегти" name="savetsinf" />
</p>