<!-- MENU OPTIONS -->
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" data-toggle="tab" href="#CHOOSE_ADDRESS" role="tab" aria-selected="true">Elegir dirección</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" data-toggle="tab" href="#NO_CHOOSE_ADDRESS" role="tab" aria-selected="false">Enviar a otra direccíon</a>
    </li>
</ul>
<!-- END MENU OPTIONS -->

 <input type="hidden" name="addres_option" id="addres_option" value="CHOOSE_ADDRESS">  

<div class="tab-content">
    <!--NO CAMBIAR LOS ID DE CADA TAG, AYUDAN A VALIDAR EN SERVIDOR-->
    <div class="tab-pane active" id="CHOOSE_ADDRESS" role="tabpanel" aria-labelledby="home-tab"> 
        <div class="form-group col-md-4 @error('state') has-error @enderror" style="top: 20px;">
      
            <select name="address_stored_id" id="address_stored" class="form-control input-lg">
                <option value="" disabled selected>{{ __('Seleccionar dirección...') }}</option>

                @foreach (auth()->user()->addresses as $address)
                <option value="{{ $address->id }}">{{ $address->line }}</option>
                @endforeach
            </select>

            @error('state')
            <span class="help-block">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <!--NO CAMBIAR LOS ID DE CADA TAG, AYUDAN A VALIDAR EN SERVIDOR-->
    <div class="tab-pane" id="NO_CHOOSE_ADDRESS" role="tabpanel" aria-labelledby="profile-tab" style="padding-top: 20px;">
        <div class="row">
            <div class="form-group col-md-8 @error('line') has-error @enderror">
                <label for="line">
                    {{ __('Dirección') }}<sup class="text-danger">*</sup>
                </label>

                <input type="text" class="form-control input-lg" id="line" name="line" placeholder="{{ __('Calle(s), número, colonia, avenida, bulevar, etc.') }}" value="{{ old('line') }}">

                @error('line')
                <span class="help-block">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group col-md-4 @error('secondary_line') has-error @enderror">
                <label for="secondary-line" style="visibility: hidden;">{{ __('Dirección complementaria') }}</label>

                <input type="text" class="form-control input-lg" id="secondary-line" name="secondary_line" placeholder="{{ __('Apartamento, edificio, oficina, etc.') }}" value="{{ old('secondary_line') }}">

                @error('secondary_line')
                <span class="help-block">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group col-md-4 @error('zipcode') has-error @enderror">
                <label for="zipcode">
                    {{ __('Código Postal (zip code)') }}<sup class="text-danger">*</sup>
                </label>

                <input type="text" class="form-control input-lg" id="zipcode" name="zipcode" placeholder="{{ __('Código Postal (zip code)') }}" value="{{ old('zipcode') }}">

                <!-- Gets the name country hidden -->
                <input type="hidden" value="United States" name="country">

                @error('zipcode')
                <span class="help-block">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group col-md-4 @error('city') has-error @enderror">
                <label for="city">
                    {{ __('Ciudad') }}<sup class="text-danger">*</sup>
                </label>

                <input type="text" class="form-control input-lg" id="city" name="city" placeholder="{{ __('Ciudad') }}" value="{{ old('city') }}">

                @error('city')
                <span class="help-block">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group col-md-4 @error('state') has-error @enderror">
                <label for="state">
                    {{ __('Estado') }}<sup class="text-danger">*</sup>
                </label>
                <select name="state" id="state" class="form-control input-lg">
                    <option value="" disabled selected>{{ __('Seleccionar estado...') }}</option>
                    @foreach (config('shipping.states') as $key => $state)
                    <option value="{{ $key }}">{{ $state }}</option>
                    @endforeach
                </select>

                @error('state')
                <span class="help-block">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

        </div>
    </div>
</div>