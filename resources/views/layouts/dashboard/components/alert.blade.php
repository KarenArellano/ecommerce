@if (session('message'))
<div class="alert alert-{{ session('message.type') }} alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <strong>
        {{ session('message.title') }}
    </strong>
    <p class="mb-0">
        {{ session('message.content') }}
    </p>
</div>
{{ session()->forget('message') }}
@endif


@if (session('messages'))
@foreach (session('messages') as $message)
<div class="alert alert-{{ $message['type'] }} alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <strong>
        {{ $message['title'] }}
    </strong>
    <p class="mb-0">
        {{ $message['content'] }}
    </p>
</div>
{{ session()->forget('messages') }}
@endforeach
@endif
