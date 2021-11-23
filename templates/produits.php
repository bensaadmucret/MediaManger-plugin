<?php

use Inc\Base\CustomProduitsController;

$produits = CustomProduitsController::get_produits();

?>
<?php foreach ($produits as $produit) : ?>
    <?php //dump($produit)?>
    <div class="col-md-4">
        <div class="card mb-4 shadow-sm">           
           <?php foreach ($produit as $post) : ?>
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal"><?php echo $post->post_title; ?></h4>
                </div>
                <div class="card-body">
                    <img src="<?php echo get_the_post_thumbnail_url($post->ID); ?>" class="img-fluid" alt="<?php echo $post->post_title; ?>">
                    <div class="card-text">
                        <p><?php //echo $post->post_excerpt;?></p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            <a href="<?php echo get_permalink($post->ID); ?>" class="btn btn-sm btn-outline-secondary">Voir</a>
                        </div>
                        <small class="text-muted"><?php echo $post->post_date; ?></small>
                    </div>
                </div>
            <?php endforeach; ?>
            <div id="notification"></div>

        

                 
        </div>
    </div>

<?php endforeach; ?>

    
