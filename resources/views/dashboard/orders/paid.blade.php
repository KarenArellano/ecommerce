<div class="card">
    <div class="card-body">
        <table id="orders-table-noshipped" class="table table-hover" table-layout="fixed">
            <thead>
                <tr>
                    <th class="wd-15p">{{ __('Opciones') }}</th>

                    <th class="wd-15p">{{ __('Transacción') }}</th>

                    <th class="wd-15p">{{ __('Referencia') }}</th>

                    <th class="wd-10p">{{ __('Cliente') }}</th>

                    <th class="wd-15p">{{ __('Envío') }}</th>

                    <th class="wd-15p">{{ __('Productos') }}</th>

                    <th class="wd-15p">{{ __('Total') }}</th>

                    <th class="wd-15p">{{ __('Comprado') }}</th>

                    <th class="wd-15p">{{ __('Estado') }}</th>

                    <th class="wd-15p">{{ __('Precio Envio') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ordersNoShipped as $order)
                <tr>
                    <td>
                        @if(empty($order->cancelled_at) && empty($order->shipped_at))
                        <nav class="nav d-flex justify-content-center">
                            <a class="nav-link tx-bold text-muted" href="#" data-toggle="dropdown">
                                <span class="d-none d-sm-block d-md-none d-block">
                                    Opciónes <i data-feather="chevron-down"></i>
                                </span>
                                <i data-feather="more-horizontal" class="d-sm-none d-md-block"></i>
                            </a>
                            <div class="dropdown-menu tx-13 tx-bold">

                                @if(empty($order->shipped_at))
                                <a href="#orders-delete-{{ $order->id }}-modal" data-toggle="modal" data-animation="effect-scale" class="dropdown-item text-danger">
                                    <i data-feather="x-square" class="wd-15 ht-15"></i>
                                    {{ __('Cancelar') }}
                                </a>
                                
                                <a href="#orders-reprint-label-modal" data-toggle="modal" data-animation="effect-scale" class="dropdown-item text-primary" data-order="{{ $order }}">
                                    <i data-feather="tag" class="wd-15 ht-15"></i>
                                    {{ __('Reimprimir etiqueta') }} 
                                </a>

                                @endif

                                @if(empty($order->cancelled_at))
                                <a href="#orders-update-{{ $order->id }}-modal" data-toggle="modal" data-animation="effect-scale" class="dropdown-item text-primary">
                                    <i data-feather="truck" class="wd-15 ht-15"></i>
                                    {{ __('Enviado') }}
                                </a>
                                @endif
                            </div>

                        </nav>
                        @endif
                    </td>

                    <td>
                        {{$order->transaction_id }}
                    </td>

                    <td>
                        @if($order->paid_with == 'paypal')
                        <a href="https://www.paypal.com/myaccount/transactions/?free_text_search={{ $order->reference }}&account_subscription_type=ALL&currency=ALL&status=&type=&start_date={{ now()->subMonth(1)->format('Y-m-d') }}&end_date={{ now()->format('Y-m-d') }}" target="_blank">{{ $order->reference ?? 'Sin referencia' }}</a>
                        @else
                        <p title="{{ $order->reference ?? __('Sin referencia') }}">{{ $order->reference ?? __('Sin referencia') }}</p>
                        @endif
                    </td>

                    <td>
                        <span class="text-capitalize">{{ $order->user->name }}</span> <br>
                        <a href="mailto:{{ $order->user->email }}">{{ $order->user->email }}</a>
                    </td>

                    <td>
                        @php $address = $order->shipment->address; @endphp
                        <address>
                            {{ $address->line }}<br>
                            @if ($address->secondary_lin)
                            ({{ $address->secondary_line}})<br>
                            @endif
                           
                            {{ $address->city }}, {{ $address->state }}<br>
                            <abbr title="{{ __('Código Postal') }}">C.P.:</abbr> {{ $address->zipcode }}
                            {{ __('Tel: ') . $address->phone }}
                        </address>
                    </td>

                    <td>
                        <a href="javascript:;" data-toggle="modal" data-target="#products-detail-modal" data-order="{{ $order->products }}">
                            {{ __(':count adquirido(s)', ['count' => $order->getTotalProductsQuantity() ]) }}
                        </a>
                    </td>

                    <td>
                        {{ format_price($order->total, 'USD') }}
                    </td>

                    <td>
                        {{ $order->paid_at->isoFormat('LLL') }}
                    </td>

                    <td style="word-break:break-all!important;">
                        @if($order->shipped_at)
                        <p class="alert alert-info" role="alert" style="word-break:keep-all!important;">
                            {{ $order->shipped_at ? 'Enviada el '.$order->shipped_at->isoFormat('LLL') : '' }}
                        </p>
                        @else
                        <span class="badge badge-{{ $order->cancelled_at ? 'danger' : 'success' }} tx-14">
                            {{ $order->cancelled_at ? 'Cancelada' : 'Pagada' }}
                        </span>
                        @endif
                    </td>

                    <td>
                        <p style="word-break:keep-all!important; color: {{ $order->shipment->service_name == 'usps_priority' ? 'brown' : 'green' }} ">
                            {{ $order->shipment->shipper ? $order->shipment->shipper : 'no se encontró el nombre de paquetería' }}
                            {{ format_price($order->shipment->price , $order->shipment->currency ) }}
                        </p>
                    </td>
                    @push('modals') @include('dashboard.orders.delete', compact('order')) @endpush
                    @push('modals') @include('dashboard.orders.shipped', compact('order')) @endpush

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>