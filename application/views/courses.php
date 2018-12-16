<style>
    .contain .row:last-child {
        width: 100%;
    }
</style>
<div class="container">
    <div class="center" style="overflow: hidden;">

        <div class="center container_cube" style="/*overflow: hidden;*/">
            <h2 class="about_us"><?=lang('Courses')?></h2>
        </div>

        <div class="content" style="text-align: center;"><?=lang('select_a_course_to_find_out_more')?></div>

        <div class="contain"  style="width: 90%;text-align: center;margin: 0 auto;">
            <div class="row"><?
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
                    <a href="<?= base_url($lng . '/course/' . $value['alias']) ?>"><?= $value['title'] ?></a>
                </div><?
                if ($i >= $count && $i % $count == 0) :
                ?>
            </div>
            <div class="row" ><?
                endif;
                endforeach;
                ?>
               </div>
            <div class="row">
                <div class="content" style="text-align: center;"><?=lang('more_courses_available')?></div>
            </div>

        </div>

    </div>
</div>