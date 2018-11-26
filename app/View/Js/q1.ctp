<div class="alert  ">
<button class="close" data-dismiss="alert"></button>
<style type="text/css">
	.desc{
		width:500px;
		height: 70px;
	}
	.desc textarea{
		width: 400px;
		height: 50px;
		border:1px solid #333;
	}
	input{
		width: 200px;
		height: 25px;
		border: 1px solid #333;
	}
</style>
<script type="text/javascript">
  function AllowNumbersOnly(e) {
    var code = (e.which) ? e.which : e.keyCode;
    if (code > 31 && (code < 48 || code > 57)) {
      e.preventDefault();
    }
  }
</script>
Question: Advanced Input Field</div>

<p>
1. Make the Description, Quantity, Unit price field as text at first. When user clicks the text, it changes to input field for use to edit. Refer to the following video.

</p>


<p>
2. When user clicks the add button at left top of table, it wil auto insert a new row into the table with empty value. Pay attention to the input field name. For example the quantity field

<?php echo htmlentities('<input name="data[1][quantity]" class="">')?> ,  you have to change the data[1][quantity] to other name such as data[2][quantity] or data["any other not used number"][quantity]

</p>



<div class="alert alert-success">
<button class="close" data-dismiss="alert"></button>
The table you start with</div>

<table class="table table-striped table-bordered table-hover">
<thead>
<th><span id="add_item_button" class="btn mini green addbutton" onclick="addToObj=false">
											<i class="icon-plus"></i></span></th>
<th>Description</th>
<th>Quantity</th>
<th>Unit Price</th>
</thead>

<tbody id="all_data">
	<?php if(count($alldata) == 0){?>
	<tr class="add_row" id="add_row_1">
	<td></td>
	<td for1="description" class="desc"><span id="description_1_content"></span><textarea name="data[1][description]" id= "description_1" class="m-wrap  description required" rows="2" ></textarea></td>
	<td for1="quantity"><span id="quantity_1_content"></span><input name="data[1][quantity]" onkeypress = "return AllowNumbersOnly(event)" class="" id="quantity_1"></td>
	<td for1="price"><span id="price_1_content"></span><input name="data[1][unit_price]"  onkeypress = "return AllowNumbersOnly(event)" id="price_1" class=""></td>
	
</tr>
 <?php
}
else{
foreach ($alldata as $key => $value) {
 ?>
	<tr class="add_row" id="add_row_<?php echo $value['User']['ID'];?>">
	<td></td>
	<td for1="description" class="desc"><span id="description_<?php echo $value['User']['ID'];?>_content"><?php echo $value['User']['description'];?></span><textarea name="data[1][description]" id= "description_<?php echo $value['User']['ID'];?>" class="m-wrap  description required " rows="2" style="display: none;" ></textarea></td>
	<td for1="quantity"><span id="quantity_<?php echo $value['User']['ID'];?>_content"><?php echo $value['User']['quantity'];?></span><input name="data[1][quantity]" class="" onkeypress = "return AllowNumbersOnly(event)" id="quantity_<?php echo $value['User']['ID'];?>" style="display: none;"></td>
	<td for1="price"><span id="price_<?php echo $value['User']['ID'];?>_content"><?php echo $value['User']['price'];?></span><input name="data[1][unit_price]" style="display: none;"onkeypress = "return AllowNumbersOnly(event)" id="price_<?php echo $value['User']['ID'];?>" class=""></td>
	
</tr>

 <?php
}
} ?>
</tbody>

</table>
<?php echo $this->Form->input('group_id', ['type' => 'hidden','value' =>count($alldata)+1]);
?>

<p></p>
<div class="alert alert-info ">
<button class="close" data-dismiss="alert"></button>
Video Instruction</div>

<p style="text-align:left;">
<video width="78%"   controls>
  <source src="/video/q3_2.mov">
Your browser does not support the video tag.
</video>
</p>





<?php $this->start('script_own');?>
<script>
$(document).ready(function(){

	$("#add_item_button").click(function(){
		let groups=parseInt($("#group_id").val());
		groups=groups+1;
		$("#group_id").val(groups);
		var addhtml='<tr class="add_row" id="add_row_'+groups+'"><td></td><td for1="description" class="desc"><span id="description_'+groups+'_content"></span><textarea name="data[1][description]" id="description_'+groups+'" class="m-wrap  description required" rows="2" ></textarea></td><td for1="quantity"><span id="quantity_'+groups+'_content"></span><input name="data[1][quantity]" class="" id="quantity_'+groups+'" onkeypress = "return AllowNumbersOnly(event)"></td><td for1="price"><span id="price_'+groups+'_content"></span><input onkeypress = "return AllowNumbersOnly(event)" name="data[1][unit_price]"  class="" id="price_'+groups+'"></td></tr>';
		$("#all_data").append(addhtml);
		});
	  $(document).on('focus',"input,textarea", function() {
        console.log('in');
    }).on('blur',"input,textarea", function() {
        let selectedId=$(this).attr("id");
        let thisVal=$("#"+selectedId).val();        
        var resArray=selectedId.split("_");
        let description=$("#description_"+resArray[1]).val();
        let price=$("#price_"+resArray[1]).val();
        let quantity=$("#quantity_"+resArray[1]).val();
        $("#"+selectedId).css("display","none");
        $("#"+selectedId+"_content").text(thisVal);
        $.ajax({
  		url: "update",
 		data:{"description":description,"price":price,"quantity":quantity,"id":resArray[1]},
 		method:"POST",
  success: function(data){
  		let results=JSON.parse(data);
  		if(results.mode == 'insert'){
  			if($("#group_id").val() <= results.id){
  			$("#group_id").val(results.id);
  			}
  		}
  }
});
    });
    $(document).on('click',"#all_data td", function() {
    	let selectedTd=$(this).attr("for1");
    	let selectedrow=$(this).parent("tr").attr("id");
    	var res=selectedrow.split("_");
    	console.log($("#"+selectedTd+"_"+res[2]+"_content").text());
    	if($("#"+selectedTd+"_"+res[2]+":visible").length == 0){
    	$("#"+selectedTd+"_"+res[2]).css("display","block");
    	$("#"+selectedTd+"_"+res[2]).val($("#"+selectedTd+"_"+res[2]+"_content").text());
    	$("#"+selectedTd+"_"+res[2]+"_content").text("");
}
    });
});
</script>
<?php $this->end();?>

