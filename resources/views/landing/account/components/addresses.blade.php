<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <!-- <th class="hidden-xs">{{ __('Alias') }}</th> -->
                <th width="300">{{ __('Dirección') }}</th>
                <th class="hidden-xs">{{ __('Ciudad') }}</th>
                <th class="hidden-xs">{{ __('Estado') }}</th>
                <th width="200" class="hidden-xs">{{ __('Titular') }}</th>
                <th class="hidden-xs"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($user->addresses as $address)
            <tr style="border-bottom: 1px solid #77777721;">
                <!-- <td class="hidden-xs text-capitalize">{{ $address->alias }}</td> -->
                <td class="text-capitalize">
                    {{ $address->line }}, {{ $address->zipcode }} <br>
                    <small>({{ $address->secondary_line }})</small>
                    @if ($address->is_default) <br><br> <span class="label label-default">{{ __('Dirección principal') }}</span>@endif
                </td>
                <td class="hidden-xs text-capitalize">{{ $address->city }}</td>
                <td class="hidden-xs text-capitalize">{{ $address->state }}</td>
                <td class="hidden-xs text-capitalize">
                    {{ $address->user_in_charge }} <br>
                    <small>
                        <abbr title="{{ __('Teléfono') }}">{{ __('Tel:') }}</abbr>
                        <a href="tel:{{ $address->phone }}">{{ $address->phone }}</a>
                    </small>
                </td>
                <td>
                    <a href="{{ route('landing.account.addresses.edit', $address->id) }}">
                     <span class="badge badge-success" style="font-size: 11px;">{{ __('Editar') }}</span>
                    </a>
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
