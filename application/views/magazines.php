<h2>My magazines</h2>
<a href="/ci-2.2.5/magazine/magazine_form">Add Issue</a>
<br/>
<a href="/ci-2.2.5/magazine/print_screen">Print</a>
<br/>
<button id="call_ajax">Call Ajax</button>
<script>
    var basePath = "/ci-2.2.5/magazine/";
    var timeoutSetting = 70000;
    $(document).ready(function(){
        $('#call_ajax').click(function( event ) {
            var obj = new Object();
            obj.id = 123456;
            var url = basePath+"ajax_post";
            var callbackName = "message";
            callAjax(obj, url, callbackName)
        });
    });

    function callAjax(obj, url, callbackName) {
	var input = JSON.stringify(obj);
	$.ajax({
        type: "POST",
        url: url,
        data: input,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        timeout: timeoutSetting,
        success: function(data){
        	callback(callbackName, data);
        },
        failure: function(errMsg) {
            //alert("Falure:"+errMsg);
        },
        error: function (xhr, textStatus, errorThrown){
        	//alert("Error:"+textStatus);
        }
    });
    
    function callback(callbackName, data){
        if (callbackName == 'message'){
            alert(data.str+' '+data.ajaxSuccess);
        }
    }
  }
</script>
<?php
$this->table->set_heading('Publication', 'Issue', 'Date', 'Action');
$tmpl = array ( 'table_open'  => '<table class="table table-striped table-bordered">' );
$this->table->set_template($tmpl);
echo $this->table->generate($magazines);

echo $this->pagination->create_links();
