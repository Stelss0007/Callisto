<?php get_header(); ?>

<section class="slider">
    <div class="prev"></div>
    <div class="next"></div>

    <?php for ($i = 1; $i <= 5; $i++) { ?>
        <div class="slide">
            <img src="<?php echo get_template_directory_uri(); ?>/images/slider.jpg" alt="edfa" />
            <div class="text_block">
                <h1 class="title"><?php echo $i; ?>Grow your business</h1>
                <p>
                    of our low voltage 
                    experience. Our expertise in 
                    Fire Alarm applications and 
                    codes allows us to stand out 
                </p>
                <a class="pie" href="#">Learn More</a>
            </div>
        </div>
    <?php } ?>

    <div class="pagination">
        <?php for ($i = 1; $i <= 5; $i++) { ?>
            <div class="pie btn <?= ($i != 1) ? : 'active'; ?>"><?= $i; ?></div>
        <?php } ?>
    </div>
</section>

<?php $post = get_post($id = 2); ?>
<div <?php post_class(); ?>>
    <h1><?php echo $post->post_title; ?></h1>
    <p>
        <?php echo $post->post_content; ?>
    </p>
</div>
</div>
<div id="demo">
    <div class="container">
        <div class="row">
            <div class="span12">

                <div id="owl-demo" class="owl-carousel owl-theme">
                    <div class="item"><h1>1</h1></div>
                    <div class="item"><h1>2</h1></div>
                    <div class="item"><h1>3</h1></div>
                    <div class="item"><h1>4</h1></div>
                    <div class="item"><h1>5</h1></div>
                    <div class="item"><h1>6</h1></div>
                    <div class="item"><h1>7</h1></div>
                    <div class="item"><h1>8</h1></div>
                    <div class="item"><h1>9</h1></div>
                    <div class="item"><h1>10</h1></div>
                    <div class="item"><h1>11</h1></div>
                    <div class="item"><h1>12</h1></div>
                    <div class="item"><h1>13</h1></div>
                    <div class="item"><h1>14</h1></div>
                    <div class="item"><h1>15</h1></div>
                    <div class="item"><h1>16</h1></div>
                </div>

                <div class="customNavigation">
                    <a class="btn prev">Previous</a>
                    <a class="btn next">Next</a>
                    <a class="btn play">Autoplay</a>
                    <a class="btn stop">Stop</a>
                </div>

            </div>
        </div>
    </div>

</div>
<!--<div class="cyan_bg">
    <section class="coll_1200" style="text-align: center">
        <h2 class="big_blue_title">systems we design, provide and install</h2>
        <div id="owl-demo" class="owl-carousel owl-theme devices">
            <div class="item">
                <div class="img-area">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/icon_fire.png" alt="" />
                </div>
                <div class="text">
                    <h3 class="title">Fire alarm</h3>
                    <p>
                        Fire Alarm is the basis for all 
                        of our low voltage 
                        experience. Our expertise in 
                        Fire Alarm applications and 
                        codes allows us to stand out 
                        in the industry. 
                    </p>
                </div>
                <div class="shadow"></div>
                <a class="find_out_more" href="#">Find out more</a>
            </div>

            <div class="item">
                <div class="img-area">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/icon_security.png" alt="" />
                </div>
                <div class="text">
                    <h3 class="title">Security</h3>
                    <p>
                        By combining industry 
                        leading security hardware 
                        with end-user customizable 
                        software, BEC oﬀers a total 
                        solution proven to 
                        revolutionize the way 
                        companies operate.
                    </p>
                </div>
                <div class="shadow"></div>
                <a class="find_out_more" href="#">Find out more</a>
            </div>

            <div class="item">
                <div class="img-area">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/icon_data.png" alt="" />
                </div>
                <div class="text">
                    <h3 class="title">Data</h3>
                    <p>
                        By bringing our decades of 
                        experience in the Fire Life 
                        Safety Industry to 
                        Telecommunications we have 
                        brought the low voltage 
                        industries most stringent 
                        standards and codes.
                    </p>
                </div>
                <div class="shadow"></div>
                <a class="find_out_more" href="#">Find out more</a>
            </div>

            <div class="item last">
                <div class="img-area">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/icon_sound.png" alt="" />
                </div>
                <div class="text">
                    <h3 class="title">Sound and COMMUNICATION</h3>
                    <p>
                        From PA, to intercom, to 
                        enhanced sound, we can 
                        provide you with all your 
                        sound and communication 
                        needs.
                    </p>
                </div>
                <div class="shadow"></div>
                <a class="find_out_more" href="#">Find out more</a>
            </div>
            <div class="clear"></div>
        </div>

        <div class="clear"></div>
    </section>
</div>-->

<div class="white_bg">
    <section class="coll_1200">
        <img class="left" src="<?php echo get_template_directory_uri(); ?>/images/testimo_photo.png" alt="phone_button" />
        <div class="testimonials">
            <h3>CUSTOMER TESTIMONIAL</h3>
            <p>
                Vestibulum nunc justo, luctus ut malesuada accumsan, pharetra sit amet enim. Vivamus ullamcorper velit vel ipsum lobortis, eget sollicitudin massa interdum. In a sem tincidunt nisl sodales ornare. Donec rutrum vel risus id ornare. Aenean convallis felis eget nisl rhoncus elementum. Nunc eget elit molestie turpis condimentum aliquet vel ut erat. 
            </p>
            <p class="author">
                JOHN From AWESOME INC.
            </p>
        </div>
    </section>
    <div class="clear"></div>
</div>

<?php
get_footer();
