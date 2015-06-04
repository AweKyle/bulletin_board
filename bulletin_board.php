<?php
/*
Plugin Name: Bulletin board
Plugin URI: http://awe-kyle.ru/
Description: Плагин, добавляющий на сайт функционал доски объявлений. Данный плагин позволяет: размещать актуальное расписание; размещать объявления, касающиеся учебного процесса (экзамены, зачёты, пересдачи и прочее); размещать результаты экзаменов, аттестаций, пересдач; своевременно извещать студентов о каком-либо событии;
Version: 1.0
Author: Nikolay Voronin
Author URI: http://awe-kyle.ru/
License: GPLv2
*/

add_action( 'init', 'create_bulletin_board' );
add_action( 'admin_init', 'my_admin' );
add_action( 'save_post', 'add_bulletin_board_fields', 10, 2 );
add_action( 'save_post', 'my_project_updated_send_email' );

add_filter( 'template_include', 'include_template_function', 1 );


function create_bulletin_board() {
    register_post_type( 'bulletin_board',
        array(
            'labels' => array(
                'name' => 'Доска объявлений',
                'singular_name' => 'Доска объявлений',
                'add_new' => 'Добавить',
                'add_new_item' => 'Добавить новое объявление',
                'edit' => 'Редактировать',
                'edit_item' => 'Редактировать объявление',
                'new_item' => 'Новое объявление',
                'view' => 'Просмотр',
                'view_item' => 'Просмотр объявления',
                'search_items' => 'Поиск объявлений',
                'not_found' => 'Объявления не найдены',
                'not_found_in_trash' => 'Объявления в корзине не найдены',
                'parent' => 'Main bulletin_board'
            ),
            'public' => true,
            'menu_position' => 15,
            'supports' => array( 'title', 'editor' ),
            'taxonomies' => array( '' ),
            //'menu_icon' => plugins_url( 'images/image.png', __FILE__ ),
            'has_archive' => true
        )
    );
    
    $username = 'cs_editor';
    $email = 'edu@sc.vsu.ru';
    $password = 'qqqqq11111';
    $userdata = array(
        'user_login'    =>  $username,
        'user_email'    =>  $email,
        'user_pass'     =>  $password,
        'user_status'   =>  2,
    );
    $user = wp_insert_user( $userdata );
}

function my_admin() {
    add_meta_box( 'bulletin_board_meta_box',
        'Дополнительные поля (можно не заполнять)',
        'display_bulletin_board_meta_box',
        'bulletin_board', 'advanced', 'high'
    );
}

function display_bulletin_board_meta_box( $bulletin_board ) {
    $subject = esc_html( get_post_meta( $bulletin_board->ID, 'subject', true ) );
    $course = get_post_meta( $bulletin_board->ID, 'course', true );
    $group = get_post_meta( $bulletin_board->ID, 'group', true );
    $event_date = get_post_meta( $bulletin_board->ID, 'event_date', true );
    ?>

    <?php

    if (isset($course) && !empty($course)) {
    	//$arr = explode('","', $course);
    	$course_group = json_decode($course);

        $count = sizeof($course_group);
        for ($i=0; $i < $count; $i++) { 
            echo "<span>Курс: " . $course_group[$i][0] .";</span><br>";
            $gr_count = sizeof($course_group[$i]);
            echo "<span>Группа: ";
            for ($j=1; $j < $gr_count-1; $j++) { 
                echo $course_group[$i][$j] . "; ";
            }
            echo $course_group[$i][$gr_count-1] . ";</span><hr>";
        }
    } ?>

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
<?php
   // render_view('add-bulletin_board-admin');

     echo ($event_date) ? $event_date : "";
}

function add_bulletin_board_fields( $bulletin_board_id, $bulletin_board ) {
    if ( $bulletin_board->post_type == 'bulletin_board' ) {
        if ( isset( $_POST['bulletin_board_course_group'] ) && $_POST['bulletin_board_course_group'] != '' ) {
        	$var = str_replace('"', '', $_POST['bulletin_board_course_group']);
            update_post_meta( $bulletin_board_id, 'course', $var );
        }
        if ( isset( $_POST['bulletin_board_group'] ) && !empty($_POST['bulletin_board_group']) ) {
            if(sizeof($_POST['bulletin_board_group']) > 1) {
                unset($_POST['bulletin_board_group'][0]);
            }
            update_post_meta( $bulletin_board_id, 'group', $_POST['bulletin_board_group'] );
        }
        if ( isset( $_POST['bulletin_board_subject'] ) && $_POST['bulletin_board_subject'] != '' ) {
            update_post_meta( $bulletin_board_id, 'subject', $_POST['bulletin_board_subject'] );
        }
        if ( isset( $_POST['event_date'] ) && $_POST['event_date'] != '' ) {
            update_post_meta( $bulletin_board_id, 'event_date', $_POST['event_date'] );
        }
    }
}

function my_project_updated_send_email( $post_id ) {

	// Если это ревизия, то не отправляем письмо
	if ( wp_is_post_revision( $post_id ) )
		return;

	$post_title =esc_html( get_post_meta( $post_id, 'subject', true ) );
	if (empty($post_title)) {
		$post_title = get_title( $post_id );
	}
	$post_url = get_permalink( $post_id );
	$post_date = get_post_meta( $post_id, 'event_date', true );
	if (!empty($post_date)) {
		$post_date = "Дата события: " . get_post_meta( $post_id, 'event_date', true );
	}
	else {
		$post_date = "";
	}

	$subject = 'Добавлено новое объявление';

	$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
	$headers .= "From: Автоматическая рассылка <bulletin@cs.vsu.ru>\r\n"; 
	$headers .= "Bcc: bulletin@cs.vsu.ru\r\n"; 

	$message = "<html> 
	    <head> 
	        <title>На сайте <a href='http://cs.vsu.ru'>cs.vsu.ru</a> добавлено новое объявление</title> 
	    </head> 
	    <body> "; 
	$message .= $post_title . ": " . $post_url . "<br>" . $post_date . "<br>" . the_content() . "</body></html>";

	$users = get_users();
	foreach ($users as $user) {
		//echo '<li>' . $user->user_email . '</li>';
		wp_mail( $user->user_email, $subject, $message, $headers );
	}

	// Отправляем письмо.
}

function include_template_function( $template_path ) {
    if ( get_post_type() == 'bulletin_board' ) {
        if ( is_single() ) {
            if ( $theme_file = locate_template( array ( 'single-bulletin_board.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/templates/single-bulletin_board.php';
            }
        }
        if ( is_archive() ) {
            if ( $theme_file = locate_template( array ( 'archive-bulletin_board.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/templates/archive-bulletin_board.php';
            }
        }
        if ( is_page() ) {
            if ( $theme_file = locate_template( array ( 'page-bulletin_board.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/templates/page-bulletin_board.php';
            }
        }
    }
    return $template_path;
}


function render_view($view) {
    $template_path = plugin_dir_path( __FILE__ ) . '/templates/'.$view.'.php';
    include_once $template_path;
}

?>