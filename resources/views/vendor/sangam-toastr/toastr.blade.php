@php
    $notificationTypes = ['success', 'error', 'info', 'warning'];
@endphp

@foreach($notificationTypes as $type)
    @if(Session($type) === true)
        @if(is_array(Session::get('message')))
            @foreach(Session::get('message') as $item)
                <script>
                    toastr.{{ $type }}("{{ $item }}");
                </script>
            @endforeach
        @else
            <script>
                console.log('test')
                toastr.{{ $type }}("{{ Session('message') }}");
            </script>
        @endif
    @endif
@endforeach

<script>
    function ajax_response(response) {
        const notificationTypes = ['success', 'error', 'info', 'warning'];

        notificationTypes.forEach(function(type) {
            if (response[type]) {
                if (Array.isArray(response.message)) {
                    response.message.forEach(function(msg) {
                        toastr[type](msg);
                    });
                } else {
                    toastr[type](response.message);
                }
            }
        });
    }
</script>