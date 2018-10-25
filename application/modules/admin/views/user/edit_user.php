
<div class="form-style-10">
    
    <div class="p_head">
        <? if ($this->authorisation('sysadmin', 'user', 1)) { ?>
            <button class="float_r"><a href="<?= base_url() ?>admin/sysadmin/user">User list</a></button>
        <?}?>    
    </div>

    <?php echo form_open(); ?>

    <div class="inner-wrap">
        <label id="message_suc">
            <div class="success d_none"></div>
        </label>
        <label id="message_err">
            <div class="error d_none"></div>
        </label>
        <br>
        <input type="hidden" name="id" value="<?=$id?>" >
        <label>Username <input type="text" name="username" value="<?=$username?>" size="50"/></label>
        <label>First Name <input type="text" name="first_name" value="<?=$first_name?>" size="50"/></label>
        <label>Last Name <input type="text" name="last_name" value="<?=$last_name?>" size="50"/></label>
        <label>Email <input type="email" name="email" value="<?=$email?>" size="50"/></label>
        <label>Role

            <select data-placeholder="Choose ..." class="chosen-select-width" tabindex="15" name="role">
                <option value=""></option>
                <?
                foreach ($result_role as $row) {
                    echo '<option '.($role_id == $row['id'] ? 'selected' : '').' value= "'.$row['id'].'" >'.$row['title'].'</option >';
                }
                ?>
            </select>
        </label>
        <label>Status <div class="switch" data-name="status" data-yes="Active" data-y="1" data-n="-1" data-no="Passive" 
        <?=($status==1 ? 'checked' : '')?>	 ></div></label>

    </div>


    </form>
    <div class="button-section" id="submit">
        <input type="submit" name="submit" value="Submit">
    </div>
</div>

