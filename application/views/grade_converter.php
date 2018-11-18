<div class="container">
    <div class="center" style="overflow: hidden;">
        <h2 class="about_us"><?= $result['title'] ?></h2>
    </div>

    <div class="content"><?= $result['text'] ?></div>

    <div class="center" style="padding-bottom: 10px;">
        <button class="register_btn" style="margin-bottom: 10px;">Register</button>
    </div>

    <div style="width: 90%;text-align: center;margin: 0 auto;">
        <div class="row">
    <?
    $i = 0;
    $count = 2;

    foreach ($children['title'] as $key => $title) :
        $i++;
        ?>
        <div class="content container_cube" style="text-align: center;">
            <a href="<?=($children['text'][$key] != '' ? base_url($lng . '/page/' . $children['alias'][$key]) : '#')?>">
                <?= $title ?>
            </a>
        </div>
        <?
        if ($i >= $count && $i % $count == 0) :
          ?>
          </div>
          <div class="row">
          <?
        endif;
    endforeach;
              ?>
        </div>
        </div>
</div>

