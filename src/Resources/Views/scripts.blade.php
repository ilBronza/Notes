<script type="text/javascript">
jQuery(document).ready(function($)
{
    @foreach(Session::pull('UiKitNotifications') ?? [] as $type => $messages)
        @foreach($messages as $message)
        add{{ ucfirst($type) }}Notification('{!! str_replace("'", "&#039;", $message) !!}', {{ $loop->index + 1 }});
        @endforeach
    @endforeach
});

window.addUiKitNotification = function(status, message, delay, timeout = 5000)
{
    UIkit.notification({
        message: message,
        status: status,
        pos: 'top-right',
        timeout: timeout * delay
    });    
}

window.addSuccessNotification = function(message, delay = 1, timeout = null)
{
    addUiKitNotification('success', message, delay, timeout);
}

window.addDangerNotification = function(message, delay = 1, timeout = null)
{
    addUiKitNotification('danger', message, delay * 2, timeout);
}

window.addWarningNotification = function(message, delay = 1, timeout = null)
{
    addUiKitNotification('warning', message, delay, timeout);
}

window.addPrimaryNotification = function(message, delay = 1, timeout = null)
{
    addUiKitNotification('primary', message, delay, timeout);
}
</script>