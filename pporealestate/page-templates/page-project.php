<?php 
/*
  Template Name: Project
 */
get_header();
$categories = get_terms(array(
    'hide_empty' => 0,
    'post_type' => 'project',
    'taxonomy' => 'project_category',
));
$levels = get_terms(array(
    'hide_empty' => 0,
    'post_type' => 'project',
    'taxonomy' => 'project_level',
));
?>
<div class="container main_content">
    <div class="ppo_breadcrumb">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div class="breadcrumbs">','</div>'); } ?>
    </div>
    <div class="banner_logo mt10 mb30">
        <?php get_template_part('template', 'logo_banner'); ?>
    </div>
    <div class="products">
        <div class="section-header">
            <div class="list-header">
                <h1 class="span-title">Dự án bất động sản</h1>
            </div>
        </div>
        <div class="project-filter">
            <div class="label-toggle">Tìm kiếm nâng cao <span class="glyphicon glyphicon-triangle-bottom"></span></div>
            <form action="" method="get" class="form-inline open">
                <div class="form-group">
                    <?php
                    wp_dropdown_categories(array(
                        'show_option_all' => __('- Loại dự án -', SHORT_NAME),
                        'name' => 'project_category', 
                        'taxonomy' => 'project_category', 
                        'selected' => getRequest('project_category'),
                        'hierarchical' => true,
                        'value_field' => 'slug',
                        'class' => 'form-control',
                    ));
                    ?>
                </div>
                <div class="form-group">
                    <?php
                    wp_dropdown_categories(array(
                        'show_option_all' => __('- Hạng dự án -', SHORT_NAME),
                        'name' => 'project_level', 
                        'taxonomy' => 'project_level', 
                        'selected' => getRequest('project_level'),
                        'hierarchical' => true,
                        'value_field' => 'slug',
                        'class' => 'form-control',
                    ));
                    ?>
                </div>
                <div class="form-group">
                    <select name="status" class="form-control">
                        <option value="">- Trạng thái dự án -</option>
                        <?php foreach (project_status() as $key => $value): ?>
                        <option value="<?php echo $key ?>"><?php echo $value ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <select name="city" id="ddlCity" class="form-control">
                        <option value="">- Thành phố -</option>
                        <?php
                        $list_city = get_province();
                        foreach ($list_city as $c) {
                            echo '<option value="' . $c->provinceid . '">' . $c->name . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <select name="district" id="ddlDistrict" class="form-control">
                        <option value="">- Quận/ Huyện -</option>
                    </select>
                </div>
                <div class="form-group">
                    <select name="ward" id="ddlWard" class="form-control">
                        <option value="">- Phường/ Xã -</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" name="khu_vuc" value="" placeholder="Khu vực" class="form-control" />
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-submit">Xem</button>
                </div>
            </form>
        </div>
        <div class="carousel-products-widget product-grid-container">
            <div class="row">
            <?php 
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $products_per_page = intval(get_option(SHORT_NAME . "_product_pager"));
            $args = array(
                'post_type' => 'project',
                'paged' => $paged,
                'posts_per_page' => $products_per_page,
            );
            $tax_query = array();
            $meta_query = array();
            if(getRequest('status')){
                $meta_query[] = array(
                    'key' => 'status',
                    'value' => getRequest('status'),
                );
            }
            if(getRequest('city')){
                $meta_query[] = array(
                    'key' => 'city',
                    'value' => getRequest('city'),
                );
            }
            if(getRequest('district')){
                $meta_query[] = array(
                    'key' => 'district',
                    'value' => getRequest('district'),
                );
            }
            if(getRequest('ward')){
                $meta_query[] = array(
                    'key' => 'ward',
                    'value' => getRequest('ward'),
                );
            }
            if(getRequest('khu_vuc')){
                $meta_query[] = array(
                    'key' => 'khu_vuc',
                    'value' => getRequest('khu_vuc'),
                    'compare' => 'LIKE'
                );
            }
            if(!empty($meta_query)){
                $meta_query['relation'] = 'AND';
                $args['meta_query'] = $meta_query;
            }
            if(getRequest('project_category')){
                $tax_query[] = array(
                    'taxonomy' => 'project_category',
                    'field'    => 'slug',
                    'terms'    => array(getRequest('project_category') ),
                );
            }
            if(getRequest('project_level')){
                $tax_query[] = array(
                    'taxonomy' => 'project_level',
                    'field'    => 'slug',
                    'terms'    => array(getRequest('project_level') ),
                );
            }
            if(!empty($tax_query)){
                $tax_query['relation'] = 'AND';
                $args['tax_query'] = $tax_query;
            }
            $query = new WP_Query($args);
            while ($query->have_posts()) : $query->the_post();
                echo '<div class="col-sm-4 col-xs-6">';
                get_template_part('template', 'project_item2');
                echo '</div>';
            endwhile;
            wp_reset_query();
            getpagenavi(array('query' => $query));
            ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
