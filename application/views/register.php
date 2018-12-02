<div class="container">
    <div class="center" style="overflow: hidden;">

        <div class="content" style="text-align: center;width: 55%;"><?=lang('Register_title')?></div>


        <form>
            <div class="form_div">
                <div class="center content" style="text-align: center;">
                    <div class="single_inp">
                        <span><?=lang('first_name')?></span>
                        <input type="text" required value="" name="firts_name" placeholder="First Name"/>
                    </div>

                    <div class="single_inp">
                        <span><?=lang('middle_name')?></span>
                        <input type="text"  value="" name="middle_name" placeholder="Middle Name"/>
                    </div>

                    <div class="single_inp">
                        <span><?=lang('last_name')?></span>
                        <input type="text" required value="" name="last_name" placeholder="Last Name"/>
                    </div>

                    <div class="single_inp">
                        <span><?=lang('date_of_Birth')?></span>
                        <input type="date" required value="" name="date_birth" placeholder="Date of Birth"/>
                    </div>

                    <div class="single_inp">
                        <span><?=lang('City')?></span>
                        <input type="text" required value="" name="city" placeholder="City"/>
                    </div>


                    <div class="single_inp">
                        <span><?=lang('Country')?></span>
                        <select required>
                            <option value=""><?=lang('Country')?></option>
                           <?
                           foreach ($country as $val) {
                               echo '<option value="'.$val['id'].'">'.$val['title'].'</option>';
                           }
                           ?>
                        </select>
                    </div>


                    <div class="single_inp">
                        <span><?=lang('Mobile')?></span>
                        <input type="text" required value="" name="mobile" placeholder="Mobile"/>
                    </div>


                    <div class="single_inp">
                        <span><?=lang('Email')?></span>
                        <input type="email" required value="" name="email" placeholder="Email"/>
                    </div>

                    <div class="single_inp">
                        <span><?=lang('Current_Previous_School_University')?></span>
                        <input type="text" required value="" name="current_school_university"
                               placeholder="Current/Previous School/University"/>
                    </div>

                    <div class="single_inp">
                        <span><?=lang('Course_you_would_like_to_study')?></span>
                        <input type="text" required value="" name="" placeholder="Course you would like to study"/>
                    </div>

                    <div class="single_inp">
                        <span><?=lang('Where_did_you_hear_about_us')?></span>
                        <input type="text" required value="" name="" placeholder="Where did you hear about us?"/>
                    </div>
                    <div class="single_inp" style="text-align: center;">
                        <button id="submit" type="button">Submit</button>
                    </div>
                </div>
            </div>
        </form>


    </div>
</div>

<script>
    $(document).on('click', '#submit', function () {
        var url = '<?=base_url(($this->uri->segment(1) != '' ? $this->uri->segment(1) : 'en').'/Main/register_ax')?>';
        $.post(url, $( "form" ).serialize()).done(function (data) {
            alert(data);
        })
    })
</script>