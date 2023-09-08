<article class="Post">
  <div class="Post__wrapper">
    <section class="Post__header">
      <h2 class="Post__title Title">
        <?php echo $entry->title ?>
      </h2>
      <section class="Post__meta">
        <h3 class="Post__data Meta" rel="author">
          <?php echo $entry->author . " - " . $entry->date ?>
        </h3>
        <a class="Post__link Link Link--dark" href="<?php echo SITE_URI . "category/$entry->cat_slug/" ?>">
          <h3 class="Post__category Meta" rel="author">
            <?php echo $entry->category ?>
          </h3>
        </a>
      </section>
    </section>
    <section class="Post__content">
      <p class="Post__text Text">
        <?php echo $entry->content; ?>
      </p>
    </section>
  </div>
</article>