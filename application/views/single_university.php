<style>
    .row {
        min-height: 422px;
        overflow: hidden;
    }
</style>
<div style='background-image: url("<?= base_url('application/uploads/universities/' . $result['background_image']) ?>");'
     class="container">
    <div class="center">
        <h2 class="about_us"> <?= $result['name'] ?></h2>
    </div>

    <div class="center" style="/*overflow: hidden;*/">
        <h2 class="about_us" style="font-size: 36px;font-weight: normal;">Overview</h2>
    </div>


    <div class="center" style="padding-bottom: 50px;">
        <div class="content">
            <?=$result['overview']?>
        </div>
        <div style="width: 90%;text-align: center;margin: 0 auto;">
            <div class="row">
                <h2 class="about_us" style="font-size: 36px;font-weight: normal;">Top Subjects</h2>
                <? if ($result['subject1']) : ?>
                    <div class="content "
                         style="text-align: center;margin-bottom: 0;"><?= $result['subject1'] ?></div><? endif; ?>
                <? if ($result['subject2']) : ?>
                    <div class="content "
                         style="text-align: center;margin-bottom: 0;"><?= $result['subject2'] ?></div><? endif; ?>
                <? if ($result['subject3']) : ?>
                    <div class="content "
                         style="text-align: center;margin-bottom: 0;"><?= $result['subject3'] ?></div><? endif; ?>
            </div>

            <div class="row">
                <h2 class="about_us" style="font-size: 36px;font-weight: normal;">Requirements</h2>
                <? if ($result['requirement1']) : ?>
                    <div class="content "
                         style="text-align: center;margin-bottom: 0;"><?= $result['requirement1'] ?></div><? endif; ?>
                <? if ($result['requirement2']) : ?>
                    <div class="content "
                         style="text-align: center;margin-bottom: 0;"><?= $result['requirement2'] ?></div><? endif; ?>
                <? if ($result['requirement3']) : ?>
                    <div class="content "
                         style="text-align: center;margin-bottom: 0;"><?= $result['requirement3'] ?></div><? endif; ?>
            </div>


        </div>

        <div class="center" style="overflow: hidden;">
            <h2 class="about_us" style="font-size: 36px;font-weight: normal;">Wont to Apply ?</h2>
        </div>

        <div class="center" style="padding-bottom: 10px;">
            <a href="<?= base_url($lng . '/register') ?>">
                <button class="register_btn" style="margin-bottom: 10px;"><?= lang('Register') ?></button>
            </a>
        </div>

        <div class="center" style="padding-bottom: 50px;">
            <a href="<?= base_url($lng . '/page/'.$result['grade_converter']) ?>">
                <button class="register_btn" style="margin-top: 10px;">Grade Converter</button>
        </div>
    </div>
</div>
