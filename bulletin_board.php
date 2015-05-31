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
add_action('admin_menu', 'register_my_custom_submenu_page');


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
    }

    render_view('add-bulletin_board-admin');

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

function register_my_custom_submenu_page() {
    add_plugins_page( 'bulletin_board.php', 'Дополнительная страница инструментов', 'Название инструмента', 'manage_options', 'my-custom-submenu-page', 'my_custom_submenu_page_callback' ); 
}

function my_custom_submenu_page_callback() {
    // контент страницы
    echo '<div class="wrap">';
        echo '<h2>Моя страница подменю</h2>';
    echo '</div>';

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


function custom_registration_function() {
    if (isset($_POST['submit'])) {
        registration_validation(
        $_POST['username'],
        $_POST['password'],
        $_POST['email'],
        $_POST['start_year'],
        $_POST['fname'],
        $_POST['lname'],
        $_POST['nickname'],
        $_POST['bio']
        );
        
        // sanitize user form input
        global $username, $password, $email, $start_year, $first_name, $last_name, $nickname, $bio;
        $username   =   sanitize_user($_POST['username']);
        $password   =   esc_attr($_POST['password']);
        $email      =   sanitize_email($_POST['email']);
        $start_year    =   absint($_POST['start_year']);
        $first_name =   sanitize_text_field($_POST['fname']);
        $last_name  =   sanitize_text_field($_POST['lname']);
        $nickname   =   sanitize_text_field($_POST['nickname']);
        $bio        =   esc_textarea($_POST['bio']);

        // call @function complete_registration to create the user
        // only when no WP_error is found
        complete_registration(
        $username,
        $password,
        $email,
        $start_year,
        $first_name,
        $last_name,
        $nickname,
        $bio
        );
    }

    registration_form(
        $username,
        $password,
        $email,
        $start_year,
        $first_name,
        $last_name,
        $nickname,
        $bio
        );
}

function registration_form( $username, $password, $email, $start_year, $first_name, $last_name, $nickname, $bio ) {
    echo '
    <style>
    div {
        margin-bottom:2px;
    }
    
    input{
        margin-bottom:4px;
    }
    </style>
    ';

    echo '
    <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
    <div>
    <label for="username">Username <strong>*</strong></label>
    <input type="text" name="username" value="' . (isset($_POST['username']) ? $username : null) . '">
    </div>
    
    <div>
    <label for="password">Password <strong>*</strong></label>
    <input type="password" name="password" value="' . (isset($_POST['password']) ? $password : null) . '">
    </div>
    
    <div>
    <label for="email">Email <strong>*</strong></label>
    <input type="text" name="email" value="' . (isset($_POST['email']) ? $email : null) . '">
    </div>
    
    <div>
    <label for="start_year">start_year</label>
    <input type="text" name="start_year" value="' . (isset($_POST['start_year']) ? $start_year : null) . '">
    </div>
    
    <div>
    <label for="firstname">First Name</label>
    <input type="text" name="fname" value="' . (isset($_POST['fname']) ? $first_name : null) . '">
    </div>
    
    <div>
    <label for="start_year">Last Name</label>
    <input type="text" name="lname" value="' . (isset($_POST['lname']) ? $last_name : null) . '">
    </div>
    
    <div>
    <label for="nickname">Nickname</label>
    <input type="text" name="nickname" value="' . (isset($_POST['nickname']) ? $nickname : null) . '">
    </div>
    
    <div>
    <label for="bio">About / Bio</label>
    <textarea name="bio">' . (isset($_POST['bio']) ? $bio : null) . '</textarea>
    </div>
    <input type="submit" name="submit" value="Register"/>
    </form>
    ';
}

function registration_validation( $username, $password, $email, $start_year, $first_name, $last_name, $nickname, $bio )  {
    global $reg_errors;
    $reg_errors = new WP_Error;

    if ( empty( $username ) || empty( $password ) || empty( $email ) ) {
        $reg_errors->add('field', 'Required form field is missing');
    }

    if ( strlen( $username ) < 4 ) {
        $reg_errors->add('username_length', 'Username too short. At least 4 characters is required');
    }

    if ( username_exists( $username ) )
        $reg_errors->add('user_name', 'Sorry, that username already exists!');

    if ( !validate_username( $username ) ) {
        $reg_errors->add('username_invalid', 'Sorry, the username you entered is not valid');
    }

    if ( strlen( $password ) < 5 ) {
        $reg_errors->add('password', 'Password length must be greater than 5');
    }

    if ( !is_email( $email ) ) {
        $reg_errors->add('email_invalid', 'Email is not valid');
    }

    if ( email_exists( $email ) ) {
        $reg_errors->add('email', 'Email Already in use');
    }
    
    if ( !empty( $start_year ) ) {
        $max = date('Y');
        $min = 2010;
        if ( !filter_var($start_year, FILTER_VALIDATE_INT, array("options" => array("min_range"=>$min, "max_range"=>$max)))) {
            $reg_errors->add('start_year', 'start_year is not a valid year');
        }
    }

    if ( is_wp_error( $reg_errors ) ) {

        foreach ( $reg_errors->get_error_messages() as $error ) {
            echo '<div>';
            echo '<strong>ERROR</strong>:';
            echo $error . '<br/>';

            echo '</div>';
        }
    }
}

function complete_registration() {
    global $reg_errors, $username, $password, $email, $start_year, $first_name, $last_name, $nickname, $bio;
    if ( count($reg_errors->get_error_messages()) < 1 ) {
        $userdata = array(
        'user_login'    =>  $username,
        'user_email'    =>  $email,
        'user_pass'     =>  $password,
        'start_year'    =>  $start_year,
        'first_name'    =>  $first_name,
        'last_name'     =>  $last_name,
        'nickname'      =>  $nickname,
        'description'   =>  $bio,
        );
        $user = wp_insert_user( $userdata );
        echo 'Registration complete. Goto <a href="' . get_site_url() . '/wp-login.php">login page</a>.';   
    }
}

// Register a new shortcode: [cr_custom_registration]
add_shortcode('cr_custom_registration', 'custom_registration_shortcode');

// The callback function that will replace [book]
function custom_registration_shortcode() {
    ob_start();
    custom_registration_function();
    return ob_get_clean();
}



function add_new_bulletin() { ?>

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

        <input type="submit" name="publish" id="publish" class="button button-primary button-large publish-bulletin" value="Опубликовать">

<?php
}


?>