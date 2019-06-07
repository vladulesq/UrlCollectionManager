<?php
session_start();
if (!isset($_SESSION) || empty($_SESSION['u_id'])){
	header("Location: ./login.php");
}

if (isset($_POST['logout'])) {
	session_destroy();
	header("Location: ./login.php");
}

?>
<html>
<head>
	<title>URL Collection</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<script type="text/javascript">
    var rowperpage = 4;
	
    $(document).ready(function(){
        getData();

        $("#but_prev").click(function(){
            var rowid = Number($("#txt_rowid").val());
            var allcount = Number($("#txt_allcount").val());
            rowid -= rowperpage;
            if(rowid < 0){
                rowid = 0;
            }
            $("#txt_rowid").val(rowid);
            getData();
        });

        $("#but_next").click(function(){
            var rowid = Number($("#txt_rowid").val());
            var allcount = Number($("#txt_allcount").val());
            rowid += rowperpage;
            if(rowid <= allcount){
                $("#txt_rowid").val(rowid);
                getData();
            }

        });
    });
   
    function getData(){
        var rowid = $("#txt_rowid").val();
        var allcount = $("#txt_allcount").val();
		var selectedCategory = $("#selectedCategory").val();
        $.ajax({
            url:'url_api.php',
            type:'post',
            data:{rowid:rowid,rowperpage:rowperpage,selectedCategory:selectedCategory},
            dataType:'json',
            success:function(response){
                createTablerow(response);
            },
			error: function(xhr, status, error) {
				console.log(xhr);
			}
        });

    }
    
    function createTablerow(data){

        var dataLen = data.length;

        $("#url_table tr:not(:first)").remove();

        for(var i=0; i<dataLen; i++){
            if(i == 0){
                var allcount = data[i]['allcount'];
                $("#txt_allcount").val(allcount);
            }else{
                var url_id = data[i]['url_id'];
                var url_link = data[i]['url_link'];
                var url_description = data[i]['url_description'];
				var url_category = data[i]['url_category'];
				
                $("#url_table").append("<tr id='tr_"+i+"'></tr>");
                $("#tr_"+i).append("<td align='center'>"+url_id+"</td>");
                $("#tr_"+i).append("<td align='left'><a href=\"edit.php?url_id="+url_id+"\" style=\"text-decoration: none; color: black;\">"+url_link+"</a></td>");
                $("#tr_"+i).append("<td align='center'>"+url_description+"</td>");
				$("#tr_"+i).append("<td align='center'><a href=\"#\" style=\"text-decoration: none; color: black;\" onclick=\"setCategory('"+url_category+"')\">"+url_category+"</a></td>");
            }
        }
    }
	
	function setCategory(category){
		//alert($("#selectedCategory").val());
		$("#selectedCategory").val(category);
		getData();
	}
</script>
</head>
<body>
	Logged as user ID: <?php echo $_SESSION['u_id']; ?> <form action="#" method="POST"><input type="submit" name="logout" value="Logout"></form>
	<br><br>
	<h3>Personal URL Collection</h3>
	<?php
		echo "<table id=\"url_table\"><tr class=\"tr_header\"><th>#</th><th>URL</th><th>Description</th><th>Category</th></tr>";
		//foreach ($urls as $url)
			//echo "<tr><td>$url['url_id']</td><td>$url['url_link']</td><td>$url['url_description']</td><td><a href=\"#\">$url['url_category']</a></td></tr>";
		echo "</table>";
		echo "<div id=\"div_pagination\"><input type=\"hidden\" id=\"txt_rowid\" value=\"0\"><input type=\"hidden\" id=\"txt_allcount\" value=\"0\"><input type=\"hidden\" id=\"selectedCategory\" value=\"none\"><input type=\"button\" class=\"button\" value=\"Previous\" id=\"but_prev\" /><input type=\"button\" class=\"button\" value=\"Next\" id=\"but_next\"/></div>";
	?>
	<br><br><a href="add.php"><input type="button" value="Add Link"></a>
</body>
</html>