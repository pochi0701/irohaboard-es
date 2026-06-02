$(function (event)
{
	/*
	$('.btn').click(function(event)
	{
		event.preventDefault();
		return false;
	});
	*/
	
	$('.btn-primary').prop('disabled', true);
	$('.btn-score').prop('disabled', false);
	$('.btn-danger').attr("onclick", 'alert("' + ((window.IB_MESSAGES && window.IB_MESSAGES.deleteDisabledDemo) || 'Deletion is disabled in demo mode') + '");');
	$('.admin-users-edit .btn-default').attr("onclick", 'alert("' + ((window.IB_MESSAGES && window.IB_MESSAGES.deleteDisabledDemo) || 'Deletion is disabled in demo mode') + '");');
	$('.admin-contents-index .btn-info').attr("onclick", 'alert("' + ((window.IB_MESSAGES && window.IB_MESSAGES.duplicateDisabledDemo) || 'Duplication is disabled in demo mode') + '");');
	
	$('.admin-users-index .btn-import').prop('disabled', false); // ユーザインポートボタン
	
	$('.btn-add').prop('disabled', false);
	$('.btn[value="' + (((window.IB_MESSAGES && window.IB_MESSAGES.login) || 'Login')) + '"]').prop('disabled', false);
	
	if(location.href.indexOf('demoib.irohasoft.com') > 0)
	{
		if(location.href.indexOf('admin') > 0)
		{
			$("#UserUsername").val("root");
			$("#UserPassword").val("irohaboard");
		}
		else
		{
			var day = ((new Date()).getDay()+1);
			
			$("#UserUsername").val("demo00" + day);
			$("#UserPassword").val("pass");
		}
	}
});
