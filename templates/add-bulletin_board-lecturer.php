<link rel='stylesheet' href='<?php echo plugins_url('bulletin_board/assets/css/admin/style.css');?>' type='text/css' media='all' />
<script type="text/javascript" src='<?php echo plugins_url('bulletin_board/assets/js/main.js');?>'></script>
<script type="text/javascript" src='<?php echo plugins_url('bulletin_board/assets/js/calendar_ru.js');?>'></script>

<div class="selectors_container">
    <div class="selectors">
        <div class="select_course">
            <span id="s_course" title="По умолчанию 'Для всех'">Выберите курс
                <div class="handlediv my_handle"><br></div>
            </span>
            <div class="select_">
                <?php
                for ( $course_num = 1; $course_num < 6; $course_num++ ) {
                ?>
                    <label>
                        <div>
                            <input name="bulletin_board_course" class="courses" value="<?php echo $course_num; ?>" type="radio">
                            <?php echo $course_num; ?> курс
                        </div>
                    </label>
                <?php } ?>
            </div>
        </div>
        <div class="select_group">
            <span id="s_group" title="По умолчанию 'Для всех'">Выберите группу
                <div class="handlediv my_handle"><br></div>
            </span>
            <div class="select_">
                <?php
                for ( $group_num = 1; $group_num < 7; $group_num++ ) {
                ?>
                    <label>
                        <div>
                            <input name="bulletin_board_group[]" class="groups" value="<?php echo $group_num; ?>" type="checkbox">
                            <?php echo $group_num; ?> группа
                        </div>
                    </label>
                <?php } ?>
            </div>
        </div>
        <br>    
    </div>
    <div class="btn_add">
        <span>Добавить</span>
    </div>
    <input type="hidden" name="bulletin_board_course_group" id="CourseGroup" value="">
</div>
<table>
    <tr>
        <td>Тема объявления</td>
        <td><input type="text" class="select_type" size="50" name="bulletin_board_subject" value="<?php echo $subject; ?>" />
        <div class="select_ types_list">
            <label><div><input name="bulletin_board_type" class="type_radio" value="Пересдача" type="radio">Пересдача</div></label>            
            <label><div><input name="bulletin_board_type" class="type_radio" value="Пара отменена" type="radio">Пара отменена</div></label>            
            <label><div><input name="bulletin_board_type" class="type_radio" value="Пара перенесена" type="radio">Пара перенесена</div></label>            
            <label><div><input name="bulletin_board_type" class="type_radio" value="Результат аттестации" type="radio">Результат аттестации</div></label>
            <label><div><input name="bulletin_board_type" class="type_radio" value="Необходимо явиться в деканат" type="radio">Необходимо явиться в деканат</div></label>             
        </div>
        </td>
    </tr>
    <script type="text/javascript">
    
    </script>
</table>
<label for="event_date">Выберите дату предстоящего события:</label>
<!-- <input id="event_date" name="event_date" type="date"> -->
<input type="text" id="event_date" name="event_date" value="" placeholder="дд.мм.гг" onfocus="this.select();lcs(this)"
onclick="event.cancelBubble=true;this.select();lcs(this)">
<p>
    <input type="submit" name="publish" id="publish" class="button button-primary button-large publish-bulletin" value="Опубликовать">
</p>