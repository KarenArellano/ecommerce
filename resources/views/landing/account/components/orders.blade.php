<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>{{ __('Fecha de compra') }}</th>
                <th>{{ __('Nº transacción') }}</th>
                <th>{{ __('Referencia') }}</th>
                <th>{{ __('Total') }}</th>
                <th>{{ __('Forma') }}</th>
                <th>{{ __('Estado') }}</th>
                <th>{{ __('Envío') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($user->orders as $order)
            <tr>
                <td class="text-capitalize">{{ $order->paid_at->isoFormat('D MMMM YYYY') }}</td>
                <td>{{ $order->transaction_id }}</td>
                <td>{{ $order->reference ? $order->reference : 'Sin referencia' }}</td>
                <td>
                    <strong>
                        {{ format_price($order->total, $order->currency) }}
                    </strong>
                </td>
                <td>
                    @switch($order->paid_with)
                    @case('cash') @php $class = 'info'; @endphp @break
                    @case('paypal') @php $class = 'primary'; @endphp @break
                    @case('card') @php $class = 'info'; @endphp @break
                    @case('Stripe') @php $class = 'info'; @endphp @break
                    @endswitch
                    <span class="badge badge-{{ $class }}" style="font-size: 11px;">{{ __($order->paid_with) }}</span>
                </td>
                <td>
                    @if ($order->paid_at)

                    @if ($order->cancelled_at)
                    <span class="badge badge-danger" style="font-size: 11px;">{{ __('Cancelada') }}</span>
                    @elseif($order->refund_at)
                    <span class="badge badge-secondary" style="font-size: 11px;">{{ __('Reembolsada') }}</span>

                    @elseif($order->shipped_at)
                    <span class="badge badge-info" style="font-size: 11px;">{{ __('Enviada') }}</span>
                    @else
                    <span class="badge badge-success" style="font-size: 11px;">{{ __('Pagada') }}</span>
                    @endif
                    @endif
                </td>
                <td>
                    @if($order->shipment)
                    <span class="badge badge-info">
                        <a href="{{ $order->shipment->label_url }}" target="blank" style="color: #ffffff;">
                            <i class="far fa-file-pdf"></i>
                            {{__('Guia de envio')}}
                        </a>
                    </span>

                    <br>
                    <span class="badge badge-primary">
                        <a href="{{ $order->shipment->tracking_url_provider }}" target="blank" style="color: #ffffff;">
                            <i class="fas fa-truck"></i>
                            {{__('Seguimiento')}}
                        </a>
                    </span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td></td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>