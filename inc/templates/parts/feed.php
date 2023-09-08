<section class="Feed">

  <?php
  foreach ($entries as $entry): ?>

    <article class="Entry">
      <div class="Entry__wrapper">
        <section class="Entry__header">
          <a class="Entry__link Link" href="#">
            <h2 class="Entry__title Subtitle">
              <?php echo $entry->title ?>
            </h2>
          </a>
        </section>
        <section class="Entry__content">
          <p class="Entry__text Text">
            <?php echo substr($entry->content, 0, 80) . "..." ?>
          </p>
        </section>
        <section class="Entry__bottom">
          <a class="Entry__link Link Link--dark" href="<?php echo SITE_URI . "category/$entry->slug/" ?>">
            <h3 class="Entry__category Meta" rel="author">
              <?php echo $entry->category ?>
            </h3>
          </a>
          <a class="Entry__link Link Link--dark" href="#">
            <h3 class="Entry__author Meta" rel="author">
              <?php echo $entry->author ?>
            </h3>
          </a>
          <a class="Entry__link Link Link--dark" href="#">
            <time class="Entry_date Meta">
              <?php echo $entry->date ?>
            </time>
          </a>
        </section>
      </div>
    </article>

  <?php endforeach; ?>

</section>