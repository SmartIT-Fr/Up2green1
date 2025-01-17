<div class="colRight">
  <?php
    if($type == 'article')
      include_component('up2gBlogDefault', 'programmesBloc');
    else
      include_component('up2gBlogDefault', 'articlesBloc');
    include_component('up2gBlogDefault', 'partenairesBloc');
  ?>
</div>

<?php if(!count($pager)) :?>
<p><?php echo __("Aucuns éléments a afficher.") ?></p>
<?php else :?>
<?php foreach($elements as $element) : ?>
<?php $ref = (method_exists($element, 'getSlug') ? $element->getSlug() : $element->getId()); ?>
<div class="module module2col">
  <div class="content" style="min-height: 130px;">
    <div class="cartouche">
      <div class="content">
        <p class="title_blog">
          <?php echo link_to($element->getTitle(), '@blog_'.$type.'?slug='.$ref); ?>
        </p>
      </div>
      <?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
    </div>
    <p class="first_article">
			<div class="accroche">
        <?php if (in_array($type, array('programme', 'organisme', 'article')) && $element->getLogo() != '') : ?>
          <img class="article-miniature" src="/uploads/<?php echo $type ?>/<?php echo $element->getLogo(); ?>" alt="Image">
        <?php elseif ($type === 'partenaire') : ?>
          <?php foreach ($element->getLogos() as $logo) : ?>
            <img class="article-miniature" src="/uploads/<?php echo $type ?>/<?php echo $element->getId(); ?>/<?php echo $logo->getSrc(); ?>" alt="Image">
          <?php endforeach; ?>
        <?php endif ?>
        <?php echo $element->getAccroche() ?>
      </div>
      <?php echo link_to(__("Lire la suite"), '@blog_'.$type.'?slug='.$ref, array('class' => 'read_more')); ?>
		</p>
  </div>
  <?php include(sfConfig::get('sf_app_template_dir').'/module/border_and_corner.php') ?>
</div>
<?php endforeach; ?>

<div class="module2col">
    <div style="text-align:center;">
        <?php if ($pager->haveToPaginate()): ?>
        <div class="pagination">
            <?php include_partial('up2gCommonDefault/pager', array(
                'pager' => $pager,
                'url_for' => $route,
            )); ?>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

