<?php
$taxonomy = 'product_category';
$terms = get_the_terms(get_the_ID(), $taxonomy);
$first_term = null;
$second_term = null;
foreach ($terms as $term) {
    if($first_term && $second_term){
        break;
    }
    if($term->parent == 0){
        $first_term = $term;
    } else {
        $second_term = $term;
    }
}
$district = get_post_meta(get_the_ID(), 'district', true);
$vitri = get_post_meta(get_the_ID(), "vi_tri", true);
$direction = get_post_meta(get_the_ID(), 'direction', true);
$currency = get_post_meta(get_the_ID(), "currency", true);
$price = get_post_meta(get_the_ID(), "unitPrice", true);
$com = get_post_meta(get_the_ID(), "com", true);
?>
<div class="row item_product <?php echo (get_post_meta(get_the_ID(), 'not_in_vip', true) == 1)?'vip':''; ?>">
    <a class="col-sm-4 thumbnail" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
        <img alt="<?php the_title(); ?>" src="<?php the_post_thumbnail_url('170x115'); ?>" />
        <?php if(!empty($com)): ?>
        <div class="com"><?php echo $com; ?></div>
        <?php endif; ?>
    </a>
    <div class="row-pro col-sm-8">
        <div class="tag-pro">
            <?php if(!empty($first_term)): ?>
            [<a href="<?php echo get_term_link($first_term, $taxonomy) ?>"><?php echo $first_term->name ?></a>]
            <?php endif; ?>
            <?php if(!empty($second_term)): ?>
            [<a href="<?php echo get_term_link($second_term, $taxonomy) ?>"><?php echo $second_term->name ?></a>]
            <?php endif; ?>
            <?php if(!empty($district)): ?>
            [<?php echo get_district_by_id($district)->name ?>]
            <?php endif; ?>
        </div>
        <h4><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
        <div class="date"><span class="glyphicon glyphicon-calendar"></span> <?php the_time('d/m/Y'); ?> </div>
        <?php if(!empty($vitri)): ?>
        <div class="location">
            <?php echo $vitri; ?>
        </div>
        <?php endif; ?>
        <div class="info-pro">
            <span>
                <i class="fa fa-bed"></i> P.Ngủ: <?php echo get_post_meta(get_the_ID(), 'so_phong', true) ?>
            </span>
            <span>
                <i class="fa fa-bath"></i> P.Tắm: <?php echo get_post_meta(get_the_ID(), 'toilet', true) ?>
            </span>
            <span class="area">
                Diện tích: <?php echo get_post_meta(get_the_ID(), "dt", true); ?> m²
            </span>
            <span>
                <i class="fa fa-arrow-up"></i> Hướng: <?php echo get_direction($direction) ?>
            </span>
        </div>
        <div class="share-pro">
            <div class="pull-right">
                <span class="price">
                    <?php echo get_post_meta(get_the_ID(), "price", true); ?> 
                    <?php echo get_unitCurrency($currency);?>
                    <?php echo get_unitPrice($price);?>
                </span>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="manage-tools">
            <span class="glyphicon glyphicon-option-vertical icon-toggle"></span>
            <div class="tools-wrap" style="display: none">
                <div class="act-del" data-id="<?php the_ID() ?>"><span class="glyphicon glyphicon-remove"></span> Xóa bài này</div>
                <?php if(get_post_meta(get_the_ID(), 'not_in_vip', true) == 1): ?>
                <div class="act-downvip" data-id="<?php the_ID() ?>"><span class="glyphicon glyphicon-download"></span> Xóa VIP bài này</div>
                <?php else: ?>
                <div class="act-upvip" data-id="<?php the_ID() ?>"><span class="glyphicon glyphicon-upload"></span> Nâng VIP bài này</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>