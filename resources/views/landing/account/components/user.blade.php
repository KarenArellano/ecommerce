<form action="{{ route('landing.account.update') }}" method="POST" autocomplete="off">
    @csrf

    <div class="row">
        @if(Session::has('userStatus'))
            <div class="alert alert-success col-8 offset-md-2 text-center">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>{{ Session::get('userStatus')  }}</strong>
            </div>
        @endif

        <div class="form-group col-6 @error('first_name') text-danger @enderror">
            <label for="first-name">{{ __('Nombre(s)') }}</label>
            <input type="text" id="first-name" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name', $user->first_name) }}" placeholder="{{ __('Nombre(s)') }}" maxlength="255" required>

            @error('first_name')
            <span class="invalid-feedback text-danger" role="alert">
                {{ $message }}
            </span>
            @enderror
        </div>

        <div class="form-group col-6 @error('last_name') text-danger @enderror">
            <label for="last-name">{{ __('Apellido(s)') }}</label>
            <input type="text" id="last-name" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', $user->last_name) }}" placeholder="{{ __('Apellido(s)') }}" maxlength="255" required>

            @error('last_name')
            <span class="invalid-feedback text-danger" role="alert">
                {{ $message }}
            </span>
            @enderror
        </div>

        <div class="form-group col-12 @error('email') text-danger @enderror">
            <label for="email">{{ __('E-Mail Address') }}</label>
            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" placeholder="{{ __('E-Mail Address') }}" maxlength="255" required>

            @error('email')
            <span class="invalid-feedback text-danger" role="alert">
                {{ $message }}
            </span>
            @enderror
        </div>

        <div class="border-bottom col-12 mb-3 mt-2"></div>

        <div class="form-group col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="updates-password" name="updates_password" value="{{ true }}" {{ old('updates_password') ? 'checked' : '' }}
                onclick="document.querySelector('.passwords').classList.toggle('d-none', !this.checked);">
                <label class="form-check-label" for="updates-password">{{ __('Actualizar contraseña') }}</label>
            </div>
        </div>

        <div class="passwords col-12 {{ old('updates_password') ? 'd-block' : 'd-none' }}">
            <div class="row">
                <div class="form-group col-6 @error('password') is-invalid @enderror">
                    <label for="password">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  placeholder="{{ __('Password') }}">

                    @error('password')
                    <span class="invalid-feedback text-danger" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <div class="form-group col-6">
                    <label for="password-confirm">{{ __('Confirm Password') }}</label>
                    <input class="form-control" id="password-confirm" type="password" name="password_confirmation" placeholder="{{ __('Confirm Password') }}">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-12 text-right">
            <button type="submit" class="btn btn-primary">{{ __('Actualizar') }}</button>
        </div>
    </div>
</form>
