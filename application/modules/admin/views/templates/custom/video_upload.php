 
 <?
 $controller = $this->router->fetch_class();
 $page =  $this->router->fetch_method();
 $url=base_url().'admin/'.$controller.'/'.substr($this->uri->segment(3), 4);
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





<script type="text/javascript">
	function _(element) {
		return document.getElementById(element);
	} 

	function uploadFile(){

		var url = "<?=base_url().'admin/'.$controller.'/'.$this->uri->segment(3).'_ax'?>";
		var file = _("video").files[0];
		// alert(file.name+" | "+file.size+" | "+file.type);
		var formdata = new FormData();
		formdata.append("video", file);
		var ajax = new XMLHttpRequest();
		ajax.upload.addEventListener("progress", progressHandler, false);
		ajax.addEventListener("load", completeHandler, false);
		ajax.addEventListener("error", errorHandler, false);
		ajax.addEventListener("abort", abortHandler, false);
		ajax.open("POST", url);
		ajax.send(formdata);
	}

	function progressHandler(event){
		_("loaded_n_total").innerHTML = "Uploaded "+event.loaded+" bytes of "+event.total;
		var percent = (event.loaded / event.total) * 100;
		_("progress").value = Math.round(percent);
		_("status").innerHTML = Math.round(percent)+"% uploaded... please wait";
	}

	function completeHandler(event){
		_("status").innerHTML = event.target.responseText;
		_("progress").value = 0;
	}

	function errorHandler(event){
		_("status").innerHTML = "Upload Failed";
	}

	function abortHandler(event){
		_("status").innerHTML = "Upload Aborted";
	}
</script>
	
	
</body>