




<script>
	var NOTIFY_ENDPOINT = "{{ URL::to('post/concert/notification') }}";

	$(function() {
		$("a[href='#notify']").click(function() {
			$.ajax({
				url: NOTIFY_ENDPOINT,
				data: {"message": "I'm a notification!"}
			});
		});

		$(".notify button").click(handleNotifyButtonClick);

		var pusher = new Pusher('PUSHER_APP_KEY');
		var channel = pusher.subscribe('my_notifications');
		var notifier = new PusherNotifier(channel);
	});

	function handleNotifyButtonClick() {
		var message = $.trim($("#notifyMessage").val());
		if(message) {
			$.ajax({
				url: NOTIFY_ENDPOINT,
				data: {"message": message}
			});
		}
	}
</script>

<script>
	function PusherNotifier(channel, options) {
		options = options || {};

		this.settings = {
			eventName: 'notification',
			title: 'Notification',
	titleEventProperty: null, // if set the 'title' will not be used and the title will be taken from the event
	image: 'images/notify.png',
	eventTextProperty: 'message',
	gritterOptions: {}
};

$.extend(this.settings, options);

var self = this;
channel.bind(this.settings.eventName, function(data){ self._handleNotification(data); });
};
PusherNotifier.prototype._handleNotification = function(data) {
	var gritterOptions = {
		title: (this.settings.titleEventProperty? data[this.settings.titleEventProperty] : this.settings.title),
		text: data[this.settings.eventTextProperty].replace(/\\/g, ''),
		image: this.settings.image
	};

	$.extend(gritterOptions, this.settings.gritterOptions);

	$.gritter.add(gritterOptions);
};
</script>