<?//todo select in database?>
<div class="wh_100">
    <div class="container">
        <? if ($this->authorisation('sysadmin', 'user', 1)) { ?>
            <div class="user">
                <div class="content">
                    <a href="<?= base_url() . 'admin/sysadmin/user?lng='.($this->input->get('lng') != '' ? $this->input->get('lng') : 'hy') ?>">
                        <img width="100%" src="<?=base_url().'icons/big/user_list.png'?>">
                        <div class="cnt"><b>User</b></div>
                    </a>
                </div>
            </div>
        <? } ?>

        <? if ($this->authorisation('sysadmin', 'permission', 1)) { ?>
            <div class="user">
                <div class="content">
                    <a href="<?= base_url() . 'admin/sysadmin/permission?lng=' .($this->input->get('lng') != '' ? $this->input->get('lng') : 'hy') ?>">
                        <img width="100%" src="<?=base_url().'icons/big/permission.png'?>">
                        <div class="cnt"><b>Permission</b></div>
                    </a>
                </div>
            </div>
        <? } ?>


        <? if ($this->authorisation('sysadmin', 'role', 1)) { ?>
            <div class="user">
                <div class="content">
                    <a href="<?= base_url() . 'admin/sysadmin/role?lng=' .($this->input->get('lng') != '' ? $this->input->get('lng') : 'hy') ?>">
                        <img width="100%" src="<?=base_url().'icons/big/role.png'?>">
                        <div class="cnt"><b>Role</b></div>
                    </a>
                </div>
            </div>
        <? } ?>


        <? if ($this->authorisation('sysadmin', 'video', 1)) { ?>
            <div class="user">
                <div class="content">
                    <a href="<?= base_url() . 'admin/sysadmin/video?lng=' .($this->input->get('lng') != '' ? $this->input->get('lng') : 'hy') ?>">
                        <img width="100%" src="<?=base_url().'icons/big/video.png'?>">
                        <div class="cnt"><b>Video</b></div>
                    </a>
                </div>
            </div>
        <? } ?>

        <? if ($this->authorisation('sysadmin', 'video_list', 1)) { ?>
            <div class="user">
                <div class="content">
                    <a href="<?= base_url() . 'admin/sysadmin/video_list?lng=' .($this->input->get('lng') != '' ? $this->input->get('lng') : 'hy') ?>">
                        <img width="100%" src="<?=base_url().'icons/big/video_list.png'?>">
                        <div class="cnt"><b>Video category</b></div>
                    </a>
                </div>
            </div>
        <? } ?>

        <? if ($this->authorisation('sysadmin', 'news', 1)) { ?>
            <div class="user">
                <div class="content">
                    <a href="<?= base_url() . 'admin/sysadmin/news?lng=' .($this->input->get('lng') != '' ? $this->input->get('lng') : 'hy') ?>">
                        <img width="100%" src="<?=base_url().'icons/big/news.png'?>">
                        <div class="cnt"><b>News</b></div>
                    </a>
                </div>
            </div>
        <? } ?>


        <? if ($this->authorisation('sysadmin', 'edit_menu', 1)) { ?>
            <div class="user">
                <div class="content">
                    <a href="<?= base_url() . 'admin/sysadmin/edit_menu?lng=' .($this->input->get('lng') != '' ? $this->input->get('lng') : 'hy') ?>">
                        <img width="100%" src="<?=base_url().'icons/big/menu.png'?>">
                        <div class="cnt"><b>Menu</b></div>
                    </a>
                </div>
            </div>
        <? } ?>
        
        
        <? if ($this->authorisation('sysadmin', 'upload_video', 1)) { ?>
            <div class="user">
                <div class="content">
                    <a href="<?= base_url() . 'admin/sysadmin/upload_video?lng=' .($this->input->get('lng') != '' ? $this->input->get('lng') : 'hy') ?>">
                        <img width="100%" src="<?=base_url().'icons/big/upload_video.png'?>">
                        <div class="cnt"><b>Upload video</b></div>
                    </a>
                </div>
            </div>
        <? } ?>
        
        
        <div class="user">
            <div class="content">
                <script type="text/javascript">!function(e,t,r){e.PrcyCounterObject=r,e[r]=e[r]||function(){(e[r].q=e[r].q||[]).push(arguments)};var c=document.createElement("script");c.type="text/javascript",c.async=1,c.src=t;var n=document.getElementsByTagName("script")[0];n.parentNode.insertBefore(c,n)}(window,"//a.pr-cy.ru/assets/js/counter.min.js","prcyCounter"),prcyCounter("dilemmatik.ru","prcyru-counter",0);</script><div id="prcyru-counter"></div><noscript><a href="//a.pr-cy.ru/dilemmatik.ru" target="_blank"><img src="//a.pr-cy.ru/assets/img/analysis-counter.png" width="88" height="31" alt="Analysis"></a></noscript>
            </div>
        </div>
        
        <div class="user">
            <div class="content">
                <p style="font-size: 35px; text-align: center; color: #000;"><b><?=$total?></b></p>
                <div class="cnt"><b>Video view total time in minutes</b></div>
            </div>
        </div>
        
        
        <div id="containers" style="width:100%; height:400px;"></div>
        
        <div id="container" style="width:100%; height:400px;"></div>



    </div>
</div>








