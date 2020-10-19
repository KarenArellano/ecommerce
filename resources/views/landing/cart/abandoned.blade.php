{!! trans('abandoned.message', ['user' => $cart->user->name]) !!}
<br><br>
{!! trans('abandoned.recover') !!}
<hr><br>

<h3>{!! trans('abandoned.link') !!} </h3>

<a href="{{ url('/') }}">{!! trans('abandoned.cart') !!}</a>

{!! trans('abandoned.footer') !!}
