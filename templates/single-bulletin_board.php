<?php
 /*Template Name: New Template
 */
//get_header(); ?>


<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

load_template( dirname( __FILE__ ) . '/header-bulletin_board.php', true);
//get_header(); 
?>

<style type="text/css">
    hr {
        margin: 5px 0;
    }
</style>

    <div id="primary" class="content-area">
        <main id="main" class="site-main my_single" role="main">

        <?php
        // Start the loop.
        while ( have_posts() ) : the_post();

        echo get_the_date(); ?>
                <h2><?php the_title(); ?></h2>
                <strong>Тема: </strong>
                <?php echo esc_html( get_post_meta( get_the_ID(), 'subject', true ) ); ?>
                <br />
                <strong>Для кого: </strong>
                <br>
                <?php
                $course_group = get_post_meta( get_the_ID(), 'course', true );

                $course = json_decode($course_group);

                $count = sizeof($course);
                for ($i=0; $i < $count; $i++) { 
                    echo "<span>Курс: " . $course[$i][0] .";</span><br>";
                    $gr_count = sizeof($course[$i]);
                    echo "<span>Группа: ";
                    for ($j=1; $j < $gr_count-1; $j++) { 
                        echo $course[$i][$j] . "; ";
                    }
                    echo $course[$i][$gr_count-1] . ";</span><hr>";
                }
                ?>
                <strong>Когда: </strong>
                <?php
                $event_date = get_post_meta( get_the_ID(), 'event_date', true );
                /*$date = explode('-', $event_date);
                echo $date[2] . "." . $date[1] . "." . $date[0];*/
                echo $event_date;

            /*
             * Include the post format-specific template for the content. If you want to
             * use this in a child theme, then include a file called called content-___.php
             * (where ___ is the post format) and that will be used instead.
             */
            the_content();
            ?>
             <script type="text/javascript">(function() {
              if (window.pluso)if (typeof window.pluso.start == "function") return;
              if (window.ifpluso==undefined) { window.ifpluso = 1;
                var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
                s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
                var h=d[g]('body')[0];
                h.appendChild(s);
              }})();</script>
            <div class="pluso" data-background="transparent" data-options="small,square,line,horizontal,nocounter,theme=05" data-services="vkontakte,odnoklassniki,facebook,twitter,google,email,print"></div>
            <?php
            /*get_template_part( 'content', get_post_format() );*/

            // Previous/next post navigation.
            the_post_navigation( array(
                'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'twentyfifteen' ) . '</span> ' .
                    '<span class="screen-reader-text">' . __( 'Next post:', 'twentyfifteen' ) . '</span> ' .
                    '<span class="post-title">%title</span>',
                'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'twentyfifteen' ) . '</span> ' .
                    '<span class="screen-reader-text">' . __( 'Previous post:', 'twentyfifteen' ) . '</span> ' .
                    '<span class="post-title">%title</span>',
            ) );

        // End the loop.
        endwhile;
        ?>

        </main><!-- .site-main -->
    </div><!-- .content-area -->

<?php get_footer(); ?>



<!--::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::-->
<div id="primary" style="display: none;">
    <div id="float_link">
        <a href=""></a>
    </div>
    <div id="content" role="main">
    <?php
    $mypost = array( 'post_type' => 'bulletin_board', );
    $loop = new WP_Query( $mypost );
    echo "<pre>" . print_r($loop, true) . "</pre>";
    ?>
    <?php while ( $loop->have_posts() ) : $loop->the_post();?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <div style="float: right; margin: 10px">
                    <?php the_post_thumbnail( array( 100, 100 ) ); ?>
                </div>
                <?php echo get_the_date(); ?>
                <h2><?php the_title(); ?></h2>
                <strong>Тема: </strong>
                <?php echo esc_html( get_post_meta( get_the_ID(), 'subject', true ) ); ?>
                <br />
                <strong>Для кого: </strong>
                <?php
                $course = get_post_meta( get_the_ID(), 'course', true );
                $group = get_post_meta( get_the_ID(), 'group', true );
                var_dump($course);
                echo "Курс: " . implode(', ', $course);
                echo  " Группа: " . implode(', ', $group);
                ?>
                <br />
                <strong>Когда: </strong>
                <?php
                $event_date = get_post_meta( get_the_ID(), 'event_date', true );
                $date = explode('-', $event_date);
                echo $date[2] . "." . $date[1] . "." . $date[0];
                ?>
            </header>
            <div class="entry-content"><?php the_content(); ?></div>
           </article>
    <?php endwhile; ?>
    </div>
</div>
<?php //wp_reset_query(); ?>
<?php //get_footer(); ?>