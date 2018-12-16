<div class="container" style="background-image: url('<?= base_url('application/uploads/courses/' . $result['background_image']) ?>')">
    <div class="center" style="/*overflow: hidden;*/">
        <h2 class="about_us"><?=$result['title']?></h2>
    </div>

    <div  style="width: 90%;text-align: center;margin: 0 auto;">
        <div class="row" style="width: 45%;">
            <h2 style="font-size: 28px;" class="about_us">What does the course entail?</h2>
            <div class="content container_cube" style="text-align: center;min-height: 10px;margin-bottom: 0;">
                <a style="padding-top: 0;" href="#"><?=$result['why1']?></a>
            </div>
            <div class="content container_cube" style="text-align: center;min-height: 10px;margin-bottom: 0;">
                <a style="padding-top: 0;" href="#"><?=$result['why2']?></a>
            </div>
            <div class="content container_cube" style="text-align: center;min-height: 10px;margin-bottom: 0;">
                <a style="padding-top: 0;" href="#"><?=$result['why3']?></a>
            </div>
        </div>

        <div class="row" style="width: 45%;">
            <h2 style="font-size: 28px;" class="about_us">Career Opporunities</h2>
            <div class="content container_cube" style="text-align: center;min-height: 10px;margin-bottom: 0;">
                <a style="padding-top: 0;" href="#"><?=$result['career1']?></a>
            </div>
            <div class="content container_cube" style="text-align: center;min-height: 10px;margin-bottom: 0;">
                <a style="padding-top: 0;" href="#"><?=$result['career2']?></a>
            </div>
            <div class="content container_cube" style="text-align: center;min-height: 10px;margin-bottom: 0;">
                <a style="padding-top: 0;" href="#"><?=$result['career3']?></a>
            </div>
        </div>
    </div>

    <div class="center" style="overflow: hidden;">
        <h2 class="about_us" style="font-size: 30px;">Specialist Partners</h2>
    </div>

    <div  style="width: 90%;text-align: center;margin: 0 auto;"><?
        foreach ($result_child AS $row) :
            if($row['title'] != '') :
        ?>

        <div class="row" style="vertical-align: middle">
            <div class="content container_cube" style="text-align: center;">
                <a style="padding: 5% !important;" href="<?=($row['alias'] != '' ?  base_url($language . '/university/'.$row['alias']) : '#')?>"><?=$row['title']?></a>
            </div>
        </div>

       <?
       endif;
       endforeach;?>
    </div>
</div>