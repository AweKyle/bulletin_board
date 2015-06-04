<?php
$user_meta = get_userdata( get_current_user_id() );
?>
<div class="advanced_settings"><span>	
<?php
if ((empty($user_meta->user_course) OR empty($user_meta->user_group)) OR (!isset($user_meta->user_course) OR !isset($user_meta->user_group))) {
	echo "Укажите ваш курс и номер группы";
	//update_user_meta( get_current_user_id(), 'user_course', $meta_value );
}
else {
	echo "Вы учитесь на " . $user_meta->user_course . " курсе, в " . $user_meta->user_group . " группе";
}
?>
</span></div>
<div class="sub_advanced_settings">
	<form method="post" action="" name="adv_set" id="adv_set">
		<label>Курс:<input type="text" name="cur_course" value="" /></label>
		<label>Группа:<input type="text" name="cur_group" value="" /></label>
		<input class="submit_setting" type="submit" name="submit_setting" value="Подтвердить" />
	</form>
</div>