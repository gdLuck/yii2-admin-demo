<?php
/* @var $this yii\web\View */
?>
<h1>jq-test/index</h1>
<p class="ppp">
    the file <code><?= __FILE__; ?></code>.
</p>
<div>
    <div>
        <div id="notMe"><p>id="notMe"</p></div>
        <div id="myDiv" style="background:red;width:100px;">id="myDiv"</div>
        <input type="button" id="fd" value="放大">
    </div>
    <div data-test="123123" data-src="img src" id="ddd">
    	test data
    </div>
    <form>
      <label>Name:</label>
      <input name="name" value='123'/>
      <fieldset>
          <label>Newsletter:</label>
          <input name="newsletter" />
          <input name="newsletter" />
     </fieldset>
     <fieldset>
     	<label>password:</label>
     	<input type="password" value='123456'/>
     </fieldset>
    </form>
</div>

<hr/>
<div>
    <ul id="ul-li-1">
        <li>list item 1</li>
        <li>list item 2</li>
        <li>list item 3</li>
    </ul>
    <ul id="ul-li-2">
        <li>list item 6</li>
        <li>list item 7</li>
    </ul>
    <table border='1'>
      <tr><td colspan=2>Header 1</td></tr>
      <tr><td>Value 1</td><td>Value 2</td></tr>
      <tr><td>Value 3</td><td>Value 4</td></tr>
    </table>
    
    <select>
      <option value="1">Flowers</option>
      <option value="2" selected="selected">Gardens</option>
      <option value="3">Trees</option>
    </select>
    <hr/>
    <input name="apple" />
    <input name="flower" checked="checked" />
</div>
<hr/>
<div id="cktest">
    1:<input type="checkbox" name="newsletter" value="Hot Fuzz" />
    2:<input type="checkbox" name="newsletter" value="Cold Fusion" />
    3:<input type="checkbox" name="accept" value="Evil Plans" />
    <br/>
    	狼人杀<input type="radio" name="game" value="1" />
    	三国杀<input type="radio" name="game" value="2" />
</div>

<br/>
<input type="button" name="test" class="test" value="test" />
<input type="button" name="submit" id="test-submit" value="测试" />
<input type="button" name="submit" id="ajax-submit" value="ajax" />
<script>

var t = new Date().getTime();
var i=1;
var text='';
$(document).ready(function(){
	 $("p .ppp").click(function(){
	   	$(this).hide();
	 });

	 <!-- 单击事件测试、取值测试 -->
	 $(".test").click(function(event){
// 		 var temp = $("#myDiv").html() ;
// 		 alert(temp);
// 		 for(i in temp ){
// 			  alert(i);
// 			  console.log(test[i].toSource());
// 			}

// 		var temp = $("form input").val();
// 		for(i in temp ){
// 			  alert(i);
// 		}
		 
// 		 var temp = $('#ul-li-2 li:first');//获取第一个元素    //$('li:last')取得最后一个
// 		 alert(Object.getOwnPropertyNames(temp).length); //取得对象属性数量
// 		 alert(temp.html());

		var temp = $("input:not(:checked)").val();
		alert(temp);
	})

	$("#test-submit").on('click',function(){
		//$("#notMe:has(p)").addClass("adcls");// $("div:has(p)").addClass("adcls"); 查看DIV下有P的

		//var temp = $("div[id]:first").html();alert(temp);
		//var temp = $("input[name='newsletter']").attr("checked", true);
		//var temp = $(':password').val(); //类似有 :input :text :radio ...
		
// 		var temp = $("#cktest > input:checked"); var str = '';
// 		if(typeof Object.prototype.clone ==="undefined"){
// 	        Object.prototype.clone = function(){};    
// 	    }
// 		for (var i in temp) {
// 			if (temp.hasOwnProperty(i)) { //filter,只输出man的私有属性
// 	            console.log(i,":",temp[i].value);
// 	        };
// 		}
		
		//var temp = $("select option:selected"); console.log(temp); alert(temp.val());

// 		var temp = $("div form input[name='newsletter']").each(function(i){
// 			console.log(i + ":" + $(this).size());
// 			if(1 == i) return false;//结束循环
// 			$(this).val('123');
// 		});

		$("#ddd").data("vvv", {first: 16, last: "pizza!" });
		var temp = $("#ddd").data('vvv');
		console.log(temp );
	})
	
	$("#ajax-submit").on('click',function(){
		$.ajax({
		       type: "POST",
		       url: "http://yii2.blog.com/jq-test/ajax-callback",
		       data: "name=John&location=Boston",
		       dataType: "json",
		       success: function(msg){
		         alert( "Data Saved: " + msg.data );
		         console.log(msg);
		       }
		    });
	})

	$("#fd").click(function() {
	    $("#myDiv").css({
	      width: function(index, value) {
	        return parseFloat(value) * 1.2;
	      }, 
	      height: function(index, value) {
	        return parseFloat(value) * 1.2;
	      }
	    });
	  });
	
});

</script>
