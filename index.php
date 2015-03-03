<?php 
session_start();
$sessid=session_id();?>
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
			<div class="pull-left">
				<h5 id="uname" class="text-center">未登陆RTX</h5>
			</div>
			<div id="menuTopRight" class="pull-right hide">
				<div class="btn-group">
					<a href="#" id="offMsg" class="btn btn-info">离线消息
						<span id="offMsgNum" class="badge badge-info">0</span>
					</a>
					<div id="offMsgBox" class="popover bottom" style="top: 30px; right: 0; max-width:500px;width:500px;left:auto;">
						<div class="arrow"></div>
						<h3 class="popover-title">离线消息(RTX必须离线才能读取消息，附件只能登录RTX才能下载)</h3>
						<div class="popover-content">
							<ul id="offMsgUl"class="unstyled"></ul>
						</div>
					</div>
			    </div>
			    <div class="btn-group">
					<a href="exit.php" class="btn btn-danger">退出</a>
				</div>
			</div>
		</div>
		
	</div>
	<ul id="naver" class="hide">
	  <li><a href="#" id="notice" class="btn btn-large btn-primary">通知公告 <span class="badge badge-important">1</span></a></li>
	  <li><a href="#" id="attendance" class="btn btn-large btn-info">考勤单</a></li>
	  <li><a href="#" id="mywork" class="btn btn-large btn-success">我的工作</a></li>
	  <li><a href="#" id="getuser" class="btn btn-large btn-warning">获取用户</a></li>
	  <li><a href="#" id="getSign" class="btn btn-large btn-inverse">获取Sign</a></li>
	  <li><a href="#" id="msg" class="btn btn-large btn-danger">消息通知测试</a></li>
	</ul>

<div id="userAgent"></div>

<div id="loginModal" class="modal hide fade" data-backdrop="static">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>登陆</h3>
  </div>
  <div class="modal-body">
    <div id="loginform" class="form-horizontal">
    	<div class="control-group">
    		<label class="control-label" for="inputUname">RTX用户名：</label>
    		<div class="controls">
    			<input type="text" id="inputUname" value="<?php echo $_COOKIE['uname'];?>" />
    		</div>
    	</div>
    	<div class="control-group">
    		<label class="control-label" for="inputPassword">密码：</label>
    		<div class="controls">
    			<input type="password" id="inputPassword" value="" />
    		</div>
    	</div>

    </div>
  </div>
  <div class="modal-footer">
    <a href="javascript:login()" class="btn btn-primary">登陆</a>
    <a href="#" class="btn" data-dismiss="modal" aria-hidden="true">关闭</a>
    
  </div>
</div>




<script type="text/javascript">
var obj_api,obj_root,sessid='<?php echo $sessid;?>';

init();

function init(){
	try{
		obj_api = new ActiveXObject("RTXClient.RTXAPI");
	}catch(e){
		
		//alert('未安装RTX控件：'+e);
		manualLogin();
		return;
	}
	obj_root=obj_api.GetObject('KernalRoot');
	if(obj_root['Account']==""){
		//alert("未登陆rtx");
		manualLogin();
		return;
	}

	$.post('signlogin.php',getUserSign(),function(data){
		if(data!=='success!'){
			alert(data);
			return;
		}
		navInit();

	});


}


function getUserSign(){
	if(!obj_root){
 		return;
 	}
	var sign=obj_root.Sign.GetString("Sign");

	return {
		user:obj_root.Account,
		sign:sign
	};
}

function openwindow(url,name,iWidth,iHeight)
 {

  var iTop = (window.screen.availHeight-30-iHeight)/2;       //获得窗口的垂直位置;
  var iLeft = (window.screen.availWidth-10-iWidth)/2;           //获得窗口的水平位置;
  var win=window.open(url,name,'height='+iHeight+',,innerHeight='+iHeight+',width='+iWidth+',innerWidth='+iWidth+',top='+iTop+',left='+iLeft+',toolbar=no,menubar=no,scrollbars=auto,resizeable=no,location=no,status=no');
  win.focus();

 }

 function navInit(){
 	if(!obj_root){
 		return;
 	}
 	
	$('#uname').html('欢迎<span class="label label-success">'+obj_root.Account+'</span>进入OA!开发中');
	
	$('#getSign').click(function(){
		alert(getUserSign().sign);
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
		openwindow("notice.php?sessid="+sessid,"notice",800,500);
	});

	$("#mywork").click(function(){
		openwindow("mywork.php?sessid="+sessid,"mywork",800,500);
	});

	$("#attendance").click(function(){
		openwindow("attendance.php?sessid="+sessid,"attendance",800,500);
	});

	$('#naver').show();

 }


function send(account){
	account=account||obj_root.Account;
	$.post('sendnotice.php',{
			receiver:account,
			msg:'测试通知消息，[点击打开链接>>|http://baidu.com]',
			title:'测试通知消息，[点击打开链接>>|http://baidu.com]',
			delaytime:0
		},function(data){
			alert(data);
	});

}

function login(){
	var user=$('#inputUname').val();
	var pwd=$('#inputPassword').val();

	if(user==''||pwd==''){
		return;
	}

	$.post('userpwdlogin.php',{user:user,pwd:pwd},function(json){
		if(!json||json.error){
			alert(json.error);
			return;
		}
		$('#loginModal').modal('hide');
		manualInit(json.uname);
	},'json');

}


function manualLogin(){
	var sessUser="<?php echo $_SESSION['uname']?>";
	if(sessUser){
		manualInit(sessUser);
	}else{
		$('#loginModal').modal('show');
	}
}

function manualInit(user){
	obj_root={Account:user};
	$('#menuTopRight').show();
	navInit();
	getNoReadMsg();

	$('#offMsg').click(function(){
		$('#offMsgBox').fadeToggle();
	})
}
var OffMsgList={};
function getNoReadMsg(){

	$.post('getnoreadmsg.php',function(json){
		if(!json||json.length==0){
			return;
		}
		//console.log(json);
		$('#offMsgNum').text(json.length);
		var ul=$('#offMsgUl');
		//ul.empty();
		$.each(json,function(i,row){
			if(!OffMsgList[row.MsgID+row.Addr]){
				OffMsgList[row.MsgID+row.Addr]=row;
				var send=row.Sender;
				if(row.Type=='Tencent.RTX.Alert'){
					send='系统消息';
				}
				ul.prepend('<li><p><span class="label label-info">'+send+'</span>：'+row.Title+'</p> <p class="text-right"><small>('+row.CreateDateTime+')</small> <a href="#">回复</a> <a href="javascript:delOffMsg(\''+row.MsgID+'\',\''+row.Addr+'\')">删除</a></p></li>');

				webImChromeNotify(send+'：'+row.Title,function(){
					$('#offMsgBox').show();
				});
			}
		});

	},'json');

	setTimeout(getNoReadMsg,10000);
}


//$('#userAgent').text(navigator.userAgent);


window.webImChromeNotify = function (body, func, first) {

    body = body || '浏览器有新消息将弹出该信息!';
    var icon = location.origin+location.pathname+'public/images/avatar32_on.png';
    var winname='OARTX';
    function winclick() {
	    if (typeof(func) == 'function') {
	        func();
	    }
	    window.focus();
	    //this.cancel();
	}

    if (window['webkitNotifications']) {
        if (window.webkitNotifications.checkPermission() == 0) {
            if (first) {
                return;
            }
            var wn = window.webkitNotifications.createNotification(icon, '办公通讯', body);
            wn.onclick = winclick;
            wn.replaceId = winname;
            wn.show();
        } else {
            if (!first) {
                return;
            }
            $.messager.confirm('开启桌面通知功能', '点击确定后上方将出现允许或拒绝' +
                '<br/>请点击<span class="blue">允许</span>' +
                '<br/>下次收到消息后将弹出消息提示!', function (r) {
                if (r) {
                    window.webkitNotifications.requestPermission(webImChromeNotify);
                }
            });
        }
    } else if (window['Notification']) {
        var option = {
            icon: icon,
            tag: winname
        };
        if (Notification.permission === 'granted') {
            if (first) {
                return;
            }
            var notification = new Notification(body, option);
            notification.onclick=winclick;

        } else if (Notification.permission !== 'denied') {
            if (!first) {
                return;
            }
            Notification.requestPermission(function (permission) {
                if (!'permission' in Notification) {
                    Notification.permission = permission;
                }

                if (permission === "granted") {
                    var notification = new Notification(body, option);
                }

            });
        }
    }

};
webImChromeNotify('', false, true);

</script> 
</body> 
</html> 