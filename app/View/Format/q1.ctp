
<div id="message1">


<?php echo $this->Form->create('Type',array('id'=>'form_type','url' => array('controller' => 'Format', 'action' => 'qdetail'),'type'=>'file','class'=>'','method'=>'POST','autocomplete'=>'off','inputDefaults'=>array(
				
				'label'=>false,'div'=>false,'type'=>'text','required'=>false)))?>
	
<?php echo __("Hi, please choose a type below:")?>
<br><br>

<?php $options_new = array(
 		'Type1' => __('<span class="showDialog" data-id="dialog_1"  data-toggle="tooltip" data-placement="right" style="color:blue"
 			title="Type 1">Type1</span><div id="dialog_1" class="hide dialog" data-toggle="tooltip" data-placement="right" title="Type 1">
 				<span style="display:inline-block"><ul><li>Description .......</li>
 				<li>Description 2</li></ul></span>
 				<span><button class="ui-button ui-widget ui-corner-all">Save</button></span>
 				</div>'),
		'Type2' => __('<span class="showDialog" data-id="dialog_2" data-toggle="tooltip" data-placement="right" style="color:blue" title="Type 2">Type2</span><div id="dialog_2" class="hide dialog" title="Type 2">
 				<span style="display:inline-block"><ul><li>Desc 1 .....</li>
 				<li>Desc 2...</li></ul></span>
 				<span><button class="ui-button ui-widget ui-corner-all">Save</button></span>
 				</div>')
		);?>

<?php echo $this->Form->input('type', array('legend'=>false, 'type' => 'radio', 'options'=>$options_new,'before'=>'<label class="radio line notcheck">','after'=>'</label>' ,'separator'=>'</label><label class="radio line notcheck">'));?>
<?php echo  $this->Form->button('Save', array('type' => 'submit','class'=>'btn_submit'));?>

<?php echo $this->Form->end();?>

</div>

<style>
.showDialog:hover{
	text-decoration: underline;
}

#message1 .radio{
	vertical-align: top;
	font-size: 13px;
}

.control-label{
	font-weight: bold;
}

.wrap {
	white-space: pre-wrap;
}
.btn_submit{
	float: left;
	background: #333;
	color: #fff;
	padding: 6px;
	border: 0px;
	width: 60px;
	margin: 10px 0px 0px -20px;
}
</style>

<?php $this->start('script_own')?>
<script>

$(document).ready(function(){
	$(".dialog").dialog({
		autoOpen: false,
		width: '500px',
		modal: true,
		dialogClass: 'ui-dialog-blue'
	});

    $('[data-toggle="tooltip"]').tooltip();   
	$(".showDialog").click(function(){ var id = $(this).data('id'); $("#"+id).dialog('open'); });

})


</script>
<?php $this->end()?>