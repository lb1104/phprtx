<!DOCTYPE html>
<html>
<head>
  <title>OA</title>
<!--  
  <style type="text/css">@import '/fauxconsole/fauxconsole.css';</style>
  <script type="text/javascript" src="/fauxconsole/fauxconsole.js"></script>
-->
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="public/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="public/css/init.css" rel="stylesheet" />

<script type="text/javascript" src="public/lib/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="public/bootstrap/js/bootstrap.min.js"></script>

</head> 
<body> 
	<div class="navbar navbar-inverse">
		<div class="navbar-inner">

				<h4 id="uname" class="text-center">未登陆RTX</h4>

		</div>
		
	</div>
	<ul id="naver">
	  <li><a href="#" id="notice" class="btn btn-large btn-primary">通知公告 <span class="badge badge-important">1</span></a></li>
	  <li><a href="#" id="attendance" class="btn btn-large btn-info">考勤单</a></li>
	  <li><a href="#" id="checklogin" class="btn btn-large btn-success">验证登陆</a></li>
	  <li><a href="#" id="getuser" class="btn btn-large btn-warning">获取用户</a></li>
	  <li><a href="#" id="getSign" class="btn btn-large btn-inverse">获取Sign</a></li>
	  <li><a href="#" id="msg" class="btn btn-large btn-danger">消息通知测试</a></li>
	</ul>

<script type="text/javascript">
var obj_api,obj_root;
init();
function init(){
	try{
		obj_api = new ActiveXObject("RTXClient.RTXAPI");
	}catch(e){
		// $('#naver').hide();
		alert('未安装RTX控件：'+e);
		return;
	}
	obj_root=obj_api.GetObject('KernalRoot');
	if(obj_root['Account']&&obj_root.Account!=""){

		function getUserSign(){
			var sign=obj_root.Sign.GetString("Sign");

			return {
				user:obj_root.Account,
				sign:sign
			};
		}
		

		$.post('login.php',getUserSign(),function(data){});

		$('#uname').text('欢迎进入OA!');
		
		$('#getSign').click(function(){
			alert(getUserSign().sign);
		});

		$('#checklogin').click(function(){

			$.post('login.php',getUserSign(),function(data){
					alert(data);
			});
		});

		$('#getuser').click(function(){

			$.post('b.php',function(data){
					alert(data);
			});
		});
		$('#msg').click(function(){

			send(obj_root.Account);
		});

		$("#notice").click(function(){
			openwindow("notice.php?"+$.param(getUserSign()),"notice",800,500);
		});
		$("#attendance").click(function(){
			openwindow("attendance.php?"+$.param(getUserSign()),"attendance",800,500);
		});



	}else{
		// $('#naver').hide();
		alert("未登陆rtx");
	}
}

function openwindow(url,name,iWidth,iHeight)
 {

  var iTop = (window.screen.availHeight-30-iHeight)/2;       //获得窗口的垂直位置;
  var iLeft = (window.screen.availWidth-10-iWidth)/2;           //获得窗口的水平位置;
  var win=window.open(url,name,'height='+iHeight+',,innerHeight='+iHeight+',width='+iWidth+',innerWidth='+iWidth+',top='+iTop+',left='+iLeft+',toolbar=no,menubar=no,scrollbars=auto,resizeable=no,location=no,status=no');
  win.focus();

 }


function send(account){
	account=account||'罗荣斌';
	$.post('msg.php',{
			receiver:account,
			msg:'测试通知消息，[点击打开链接>>|http://baidu.com]',
			title:'通知',
			delaytime:0
		},function(data){
			alert(data);
	});

}
</script> 
</body> 
</html> 