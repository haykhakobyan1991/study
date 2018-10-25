
<?
$controller = $this->router->fetch_class();
$page =  $this->router->fetch_method();
$url=base_url().'admin/'.$controller.'/'.substr($this->uri->segment(3), 5);
?>


<script src="<?=base_url()?>application/jquery/jquery.min.js"></script>
<script src="<?=base_url()?>application/jquery/choosen/chosen.jquery.js" type="text/javascript"></script>
<script src="<?=base_url()?>application/jquery/choosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=base_url()?>application/jquery/choosen/docsupport/init.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="<?=base_url()?>application/jquery/jquery.dragsort-0.5.2.min.js"></script>
<script src="<?=base_url()?>application/js/base.js"></script>
<script src="<?=base_url()?>assets/ckeditor/ckeditor.js"></script>
<script src="<?=base_url()?>assets/ckfinder/ckfinder.js"></script>
<script src="<?=base_url()?>assets/jquery-ui/jquery-ui.min.js"></script>

<!--todo-->
<script type="text/javascript"
        src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js">
</script>
<!--end-->

<script src="<?=base_url()?>assets/bootstrap_datetimepicker/js/bootstrap-datetimepicker.min.js"></script>


<script>
    $(document).ready(function(){
        var editor = CKEDITOR.replace('text');
        CKFinder.setupCKEditor( editor );
        // datapicker
        $("#datepicker").datepicker({
            buttonImage:"<?=base_url()?>icons/datePicker.gif",
            showOn:"button",
            dateFormat:"yy-mm-dd",
            buttonImageOnly:true,
            changeMonth: true,
            changeYear: true
        });

        $('#dell').on('click', function () {

            $('label.photo').html('<input type="file" name="photo" value="" size="50" />');
        });


        $(function() {
            $('#datetimepicker1').datetimepicker({
                language: 'pt-BR'
            });
        });

    });

</script>


<script type="text/javascript">
    $(document).ready(function() {

        $(".chosen-select").chosen({allow_single_deselect: true});
    });

    // Function for alias
    function alias() {

        var alias = $('input[name="alias"]');
        if (alias.val() == false) {
            var title = $('input[name="title"]').val();
            var name = $('input[name="name"]').val();

            if(title !== undefined) {
                $(alias).val(convert(title));

            }else if(name !== undefined) {
                $(alias).val(convert(name));
            }
        }
    }


    function convert(unsafe) {
        var unsafe = unsafe.toLowerCase();
        return unsafe
        // Rus
            .replace(/а/g, "a")
            .replace(/б/g, "b")
            .replace(/в/g, "v")
            .replace(/г/g, "g")
            .replace(/д/g, "d")
            .replace(/е/g, "e")
            .replace(/ё/g, "yo")
            .replace(/ж/g, "zh")
            .replace(/з/g, "z")
            .replace(/и/g, "i")
            .replace(/й/g, "i")
            .replace(/к/g, "k")
            .replace(/л/g, "l")
            .replace(/м/g, "m")
            .replace(/н/g, "n")
            .replace(/о/g, "o")
            .replace(/п/g, "p")
            .replace(/р/g, "r")
            .replace(/с/g, "s")
            .replace(/т/g, "t")
            .replace(/у/g, "u")
            .replace(/ф/g, "f")
            .replace(/х/g, "kh")
            .replace(/ц/g, "tc")
            .replace(/ч/g, "ch")
            .replace(/ш/g, "sh")
            .replace(/щ/g, "shch")
            .replace(/ы/g, "y")
            .replace(/э/g, "e")
            .replace(/ю/g, "yu")
            .replace(/я/g, "ya")
            // Hy
            .replace(/ա/g, "a")
            .replace(/բ/g, "b")
            .replace(/գ/g, "g")
            .replace(/դ/g, "d")
            .replace(/ե/g, "e")
            .replace(/զ/g, "z")
            .replace(/է/g, "e")
            .replace(/ը/g, "y")
            .replace(/թ/g, "t")
            .replace(/ժ/g, "zh")
            .replace(/ի/g, "i")
            .replace(/լ/g, "l")
            .replace(/խ/g, "kh")
            .replace(/ծ/g, "ts")
            .replace(/կ/g, "k")
            .replace(/հ/g, "h")
            .replace(/ձ/g, "dz")
            .replace(/ղ/g, "gh")
            .replace(/ճ/g, "ch")
            .replace(/մ/g, "m")
            .replace(/յ/g, "y")
            .replace(/ն/g, "n")
            .replace(/շ/g, "sh")
            .replace(/չ/g, "ch")
            .replace(/պ/g, "p")
            .replace(/ջ/g, "j")
            .replace(/ռ/g, "r")
            .replace(/ս/g, "s")
            .replace(/վ/g, "v")
            .replace(/տ/g, "t")
            .replace(/ր/g, "r")
            .replace(/ց/g, "c")
            .replace(/ու/g, "u")
            .replace(/ո/g, "o")
            .replace(/փ/g, "p")
            .replace(/ք/g, "q")
            .replace(/և/g, "ev")
            .replace(/օ/g, "o")
            .replace(/ֆ/g, "f")
            //Glob
            .replace(/\s\s+/g, ' ')
            .replace(/ /g, "_")
            .replace(/[^\w.-]+/g, "_")
            .replace(/[^a-z0-9_-]+/g, '')
            .replace(/_+/g, "_")

    }
</script>




		<script type='text/javascript'>
			var n = 0;
			var loadText = 'Loading';
			var interval = null;
			function start_load() {
				if(n!=3) {
					$('#loading').append('.');
					n++;
				} else {
					n=0;
					$('#loading').html(loadText);				
				}
			}
			
			function close_message() {
				setTimeout(function(){ $('.success, .error').addClass('d_none'); }, 3000);
			}
			
			function scroll_top(){
				$('html, body').animate({scrollTop:0},700);
			}
			
			function loading(e='start'){
				if (e=='start') {
					$('#submit').addClass('d_none');
					$('#loading, #head_load').removeClass('d_none');
					interval = setInterval('start_load()',1000);
				} else {
					$('#loading').addClass('d_none');
					$('#loading').html(loadText);
					$('#submit').removeClass('d_none');
					$('#head_load').addClass('d_none');
					clearInterval(interval); 
				}
			}
			
			function progressHandlingFunction(e){
				if(e.lengthComputable){
					var percentComplete = e.loaded/e.total*100;
					$('#head_load').css('width', percentComplete+'%');
				}
			}
			
			function beforeSendHandler(e){
				$('.success, .error').addClass('d_none');
				loading();
			}
			
			function completeHandler(e){
				var error = '';
				$('.fe_err').removeClass('fe_err');

				if ($.isArray(e.error.elements)) {

					scroll_top();
					$.each(e.error.elements, function( index ) {

						$.each(e.error.elements[index], function( index, value  ) {
							if(value != '') {
									
								$("input[name='" + index + "']").addClass('fe_err');
								$("select[name='" + index + "']").parent('label').children('div').addClass('fe_err');
								error += value + ' ';
							}					
						});
					});
				} else {
					scroll_top();
					error = e.error;
				}


				
				
				if (e.success == '1') {
					scroll_top();
					$('.error').addClass('d_none');
					$('.success').removeClass('d_none');
					$('.success').html(e.message);
					var url = "<?=$url?>";
					$(location).attr('href',url);
					loading('stop');
					close_message();					
				} else {
					scroll_top();
					$('.success').addClass('d_none');
					$('.error').removeClass('d_none');
					$('.error').html(error);
					loading('stop');
				}
			}
						
			function errorHandler(e){
				scroll_top();
				$('.error').removeClass('d_none');
				$('.error').html(e);
				loading('stop');
			}
		
			$(document).ready(function() {
				$('#submit').click(function() {

                    <?if($page == 'edit_video' or $page == 'edit_video_list' or $page == 'edit_news') :?>
                        var text = CKEDITOR.instances.text.getData();

                        $('.text').text(text);
                    <?endif;?>

                    // Call alais
                    alias();

					var url = "<?=base_url().'admin/'.$controller?>/<?=$this->uri->segment(3).'_ax'?>";		
					var formData = new FormData($('form')[0]);
						
					$.ajax({
						url: url,  
						type: 'POST',
						dataType: 'json',
						xhr: function() {  
							var myXhr = $.ajaxSettings.xhr();
							if(myXhr.upload){
								myXhr.upload.addEventListener('progress', progressHandlingFunction, false); 						
							}
							return myXhr;
						},
							beforeSend: beforeSendHandler,
							success: completeHandler,					
							error: errorHandler,					
							data: formData,
							cache: false,
							contentType: false,
							processData: false
					});	
				});			
			});
	</script>