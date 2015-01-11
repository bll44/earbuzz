@extends('layouts/master')

@section('content')

{{ Auth::user()->getId(); }}

<form name="ajaxform" id="ajaxform" action="/chatter" method="POST">
	message: <input type="text" name="message" value =""/> <br/>
	<input type="hidden" name="channel" value ="{{ Auth::user()->getId(); }}"/> <br/>
</form>

@stop

@section('scripts')
<script>
	//callback handler for form submit
	$("#ajaxform").submit(function(e)
	{
		var postData = $(this).serializeArray();
		var formURL = $(this).attr("action");
		$.ajax(
		{
			url : formURL,
			type: "POST",
			data : postData,
			success:function(data, textStatus, jqXHR) 
			{
				//
			},
			error: function(jqXHR, textStatus, errorThrown) 
			{
				//
			}
		});
	e.preventDefault(); //STOP default action
	e.unbind(); //unbind. to stop multiple form submit.
});

// $("#ajaxform").submit(); //Submit  the FORM
</script>
@stop