<style>
    .row {
        display: inline-block;
        width: 100%;
    }
    .row .container_cube {
        width: 30%;
        display: inline-block;
        min-height: 100px;
        vertical-align: middle;
    }
</style>
<div class="container">
    <div class="center" style="overflow: hidden;">

        <div class="center container_cube" style="">
            <h2 class="about_us"><?= lang('PartnerUniversity') ?></h2>
        </div>

        <div class="content" style="text-align: center;"><?=lang('select_a_university_to_find_out_more')?></div>

        <div style="width: 90%;text-align: center;margin: 0 auto;">
            <div class="row">
                <?
                $i = 0;
                $count = 2;
                if(count($result) >= 3) {
                    $count = 3;
                } elseif(count($result) >= 4) {
                    $count = 4;
                } else if(count($result) >= 5) {
                    $count = 5;
                } //todo
                foreach ($result as $value) :
                  $i++;
                  ?>
                <div class="content container_cube" style="text-align: center;">
                    <a href="<?= base_url($lng . '/university/' . $value['alias']) ?>">
                        <?= $value['short_name'] ?>
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

    </div>
</div>