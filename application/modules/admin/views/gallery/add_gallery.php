
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, maximum-scale=1">
<!--        <link rel="stylesheet" type="text/css" href="--><?//=base_url()?><!--application/css/style.css">-->
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>application/css/bootstrap.css">
        <link href='http://fonts.googleapis.com/css?family=Bitter' rel='stylesheet' type='text/css'>

    </head>
	<body>

    <div class="container">
        <div class="row">
<!--            <div class="col-md-6 col-md-offset-3 well">-->
                <h3 class="text-center">Add Gallery!</h3>
	

		<?=form_open('', array('class' => 'form float-left'))?>

                <div class="col-xs-12">
                    <div class="form-group">
                        <input type="text" name="title" value="" class="form-control" placeholder="Title" />
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <input id="files"  type="file" name="image[]" multiple />
                    </div>
                </div>
            <ul id="list1" class="list-inline border float-left" data-listidx="1"></ul>
            <!-- save sort order here which can be retrieved on server on postback -->
            <input name="list1SortOrder" type="hidden" />

		</form >
                <br>
                <br>

                <div class="text-center col-xs-12 ml-3">
			        <input  id="submit" class="btn btn-default" type="submit" name="submit" value="Submit">
		        </div>
<!--            </div>-->
        </div>
    </div>

    <script type="text/javascript" src="<?=base_url()?>application/jquery/jquery.dragsort-0.5.2.min.js"></script>

    <script>

        $(document).ready(function() {

            if(window.File && window.FileList && window.FileReader) {
                $("#files").on("change",function(e) {
                    var files = e.target.files ,
                        filesLength = files.length ;

                    for (var i = 0; i < filesLength ; i++) {
                        var f = files[i];
                        console.log(f);
                        var fileReader = new FileReader();
                        n = 0;
                        fileReader.onload = (function(e) {
                            var file = e.target;
                           //  console.log(e);
                            n++;

                            $('#list1').append(
                                '<li data-id="'+n+'" class="float-left border m-2" >' +
                                '<div>' +
                                '<div class="float-left">' +
                                '<img width="150px" height="100px" class="imageThumb m-2 " src="'+file.result+'">' +
                                '</div>' +
                                '<div class="float-left">' +
                                '<span>'+f.name+'</span>' +
                                '</div>' +
                                '</div>' +
                                '</li>'
                            );

                        });

                        fileReader.readAsDataURL(f);
                    }
                });
            } else {
                alert("Your browser doesn't support to File API");
            }

        });


        $("#list1").dragsort({ dragSelector: "div",  dragBetween: true, dragEnd: saveOrder, placeHolderTemplate: "<li class='placeHolder'><div></div></li>" });

        function saveOrder() {
            var data = $("#list1 li").map(function() { return $(this).data('id'); }).get();
            $("input[name=list1SortOrder]").val(data.join());
        };


//        function handleFileSelect() {
//            //Check File API support
//            if (window.File && window.FileList && window.FileReader) {
//
//                var files = event.target.files; //FileList object
//                var output = document.getElementById("result");
//
//                for (var i = 0; i < files.length; i++) {
//                    var file = files[i];
//                    //Only pics
//                    if (!file.type.match('image')) continue;
//
//                    var picReader = new FileReader();
//                    picReader.addEventListener("load", function (event) {
//                        var picFile = event.target;
//                        var div = document.createElement("div");
//                        div.setAttribute("class", "float_l margin_2");
//                        div.innerHTML = "<img style='width: 300px; height: 200px;' class='thumbnail' src='" + picFile.result + "'" + "title='" + picFile.name + "'/>";
//                        output.insertBefore(div, null);
//                    });
//                    //Read the image
//                    picReader.readAsDataURL(file);
//                }
//            } else {
//                console.log("Your browser does not support File API");
//            }
//        }
//
//        document.getElementById('files').addEventListener('change', handleFileSelect, false);

    </script>
	</body>
</html>