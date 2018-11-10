<div class="container">
    <div class="center" style="overflow: hidden;">

        <div class="center container_cube" style="overflow: hidden;">
            <h2 class="about_us"><?= lang('PartnerUniversity') ?></h2>
        </div>

        <div class="content" style="text-align: center;">
            Select a university to find out more.
        </div>

        <div style="width: 90%;text-align: center;margin: 0 auto;">
            <div class="row">
                <?
                foreach ($result as $value) :
                    ?>
                    <div class="content container_cube" style="text-align: center;">
                        <a href="<?= base_url($lng . '/university/' . $value['alias']) ?>">
                            <?= $value['short_name'] ?>
                        </a>
                    </div>
                <?
                endforeach;
                ?>
            </div>


            <div class="row">
                <div class="content container_cube" style="text-align: center;">
                    <a href="--><?= base_url($lng . '/university/brunel_university_london') ?>">Brunel University
                        London</a>
                </div>
                <div class="content container_cube" style="text-align: center;">
                    <a href="--><?= base_url($lng . '/university/brunel_university_london') ?>">Brunel University
                        London</a>
                </div>
            </div>

            <div class="row">
                <div class="content container_cube" style="text-align: center;">
                    <a href="--><?= base_url($lng . '/university/brunel_university_london') ?>">Brunel University
                        London</a>
                </div>
                <div class="content container_cube" style="text-align: center;">
                    <a href="--><?= base_url($lng . '/university/brunel_university_london') ?>">Brunel University
                        London</a>
                </div>
            </div>


        </div>

    </div>
</div>