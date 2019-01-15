<div class="content-right">
    <div class="project-hl">
        <div class="hl-title">
            <h3 class="title_vip">Dự án nổi bật</h3>
        </div>

        <div class="wr_project">
            <div class="wr_slide">
                <div class="slideproject">
                    <div id="sliderA" class="slider">
                        <?php
                        $args = array(
                            'post_type' => 'project',
                            'tag' => 'vip',
                            'posts_per_page' => 3
                        );
                        $projects = new WP_Query($args);
                        $project_status_list = project_status();
                        while ($projects->have_posts()) : $projects->the_post();
                            $project_status = get_post_meta(get_the_ID(), "status", true);
                            $project_status_html = "";
                            if(!empty($project_status)){
                                $project_status_html = '<span class="status status-'.$project_status.'">'.$project_status_list[$project_status].'</span>';
                            }
                        ?>
                            <div>
                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="thumb">
                                    <img src="<?php the_post_thumbnail_url('400x250') ?>" alt="<?php the_title(); ?>" />
                                    <?php echo $project_status_html ?>
                                </a>
                                <h4><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
                                <?php
                                if(function_exists('the_ratings_results')) {
                                    echo '<div class="ratings">'. the_ratings_results(get_the_ID()) . '</div>';
                                }
                                ?>
                                <div><?php echo get_post_meta(get_the_ID(), "khu_vuc", true); ?></div>
                            </div>
                            <?php
                        endwhile;
                        wp_reset_query();
                        ?>

                    </div>
                </div>
            </div>
            <div class="thumbSlide">
                <div class="listproject">
                    <?php
                    $count = 0;
                    while ($projects->have_posts()) : $projects->the_post();
                    ?>
                        <div rel="<?php echo $count; ?>" class="item">
                            <a class="tt_project" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                <img class="avatar" src="<?php the_post_thumbnail_url('104x69') ?>" alt="<?php the_title(); ?>" /></a>
                            <div class="info_project">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                                <p><?php echo get_post_meta(get_the_ID(), "khu_vuc", true); ?></p>
                            </div>
                        </div>
                        <?php
                        $count++;
                    endwhile;
                    wp_reset_query();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>