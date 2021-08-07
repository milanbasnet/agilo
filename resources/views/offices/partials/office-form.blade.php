<div uk-grid>
    <div class="uk-width-1-2">
        <h1>{{ trans('messages.offices.create') }}</h1>

        <div class="uk-card uk-card-small uk-card-default uk-card-body">

            <form class="uk-form-stacked" method="POST" action="{{ action('App\Http\Controllers\OfficesController@store') }}" enctype="multipart/form-data">
                {!! csrf_field() !!}

                <div class="ag-card-nav uk-margin-bottom">
                    <a href="{{ action('App\Http\Controllers\OfficesController@index') }}" class="ag-icon-fab" title="Zurück">
                        <i class="material-icons">close</i>
                    </a>

                    <button type="submit" class="ag-icon-fab uk-float-right" title="{{ trans('messages.office.update') }}">
                        <i class="material-icons">check</i>
                    </button>
                </div>

                <div class="uk-margin-bottom">
                    <label class="uk-form-label" for="name">Name des Mandanten</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="name" name="name" value="{{ old('name') }}">
                    </div>
                </div>

                <div class="uk-margin-bottom">
                    <label class="uk-form-label" for="contact">Name der Kontaktperson</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="contact" name="contact" value="{{ old('contact') }}">
                    </div>
                </div>

                <div class="uk-margin-bottom">
                    <label class="uk-form-label" for="type">Mandantentyp</label>
                    <div class="uk-form-controls">
                        <select class="uk-select" id="type" name="type">
                            <option value="" disabled {{ old('type') ? '' : 'selected' }}>Mandantentyp auswählen</option>
                            @foreach(\App\Models\OfficeType::all() as $type)
                                <option value="{{ $type->id }}"
                                        {{ $type->id == old('type') ? 'selected' : '' }}>
                                    {{ trans($type->i18n) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="uk-margin-bottom">
                    <label class="uk-form-label" for="email">Email</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="email" name="email" type="email" value="{{ old('email') }}">
                    </div>
                </div>

                <div class="uk-margin-bottom">
                    <label class="uk-form-label" for="phone">Telefon</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="phone" name="phone" type="tel" value="{{ old('phone') }}">
                    </div>
                </div>

                <div class="uk-margin-bottom">
                    <label class="uk-form-label" for="sports">Sportarten</label>
                    <div class="uk-form-controls">
                        <select class="uk-select" id="sports" name="sports[]" multiple size="5">
                            @foreach(\App\Models\AthleteGroupSport::all() as $sport)
                                <option value="{{ $sport->id }}"
                                        {{ collect(old('sports'))->contains($sport->id) ? 'selected' : '' }}>
                                    {{ trans($sport->i18n) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="uk-margin-bottom">
                    <label class="uk-form-label" for="image">{{ trans('messages.logo.label') }}</label>
                    <div class="uk-child-width-1-2" uk-grid>
                        <div class="ag-js-file-preview uk-text-break">
                            @if(old('logo_path'))
                                <img class="ag-image-border" src="{{ asset('/storage/'.old('logo_path')) }}" alt="Logo"/>
                            @endif
                        </div>
                        <div class="ag-js-file-input">
                            <div class="js-upload uk-float-right" uk-form-custom>
                                <input type="file" name="image" id="image">
                                <button class="uk-button uk-button-default ag-special-button" type="button" tabindex="-1">
                                    <span>Upload</span>
                                    <i class="material-icons">file_upload</i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="ag-divider">
                <p class="ag-divider-label">Adresse</p>

                <div class="uk-margin-bottom">
                    <label class="uk-form-label" for="street">Straße</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="street" name="street" value="{{ old('street') }}">
                    </div>
                </div>

                <div class="uk-margin-bottom">
                    <label class="uk-form-label" for="zip_code">Postleitzahl</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="zip_code" name="zip_code" value="{{ old('zip_code') }}">
                    </div>
                </div>

                <div class="uk-margin-bottom">
                    <label class="uk-form-label" for="city">Stadt</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="city" name="city" value="{{ old('city') }}">
                    </div>
                </div>

                <div class="uk-margin-bottom">
                    <label class="uk-form-label" for="country">Land</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="country" name="country" value="{{ old('country') }}">
                    </div>
                </div>

                <div class="uk-margin">
                    <div class="uk-form-controls ag-font-size-form-input">
                        <label for="billing"><input class="uk-checkbox" type="checkbox" id="billing" name="has_billing_address" {!! old('has_billing_address') ? 'checked=checked' : '' !!} value="1"> Separate Rechnungsadresse</label>
                    </div>
                </div>

                <hr class="ag-divider">
                <p class="ag-divider-label">Rechnungsadresse</p>

                <div class="uk-margin-bottom">
                    <label class="uk-form-label" for="billing_name">Geschäftsname</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="billing_name" name="billing_name" value="{{ old('billing_name') }}">
                    </div>
                </div>

                <div class="uk-margin-bottom">
                    <label class="uk-form-label" for="billing_street">Straße</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="billing_street" name="billing_street" value="{{ old('billing_street') }}">
                    </div>
                </div>

                <div class="uk-margin-bottom">
                    <label class="uk-form-label" for="billing_zip_code">Postleitzahl</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="billing_zip_code" name="billing_zip_code" value="{{ old('billing_zip_code') }}">
                    </div>
                </div>

                <div class="uk-margin-bottom">
                    <label class="uk-form-label" for="billing_city">Stadt</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="billing_city" name="billing_city" value="{{ old('billing_city') }}">
                    </div>
                </div>

                <div class="uk-margin-bottom">
                    <label class="uk-form-label" for="billing_country">Land</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="billing_country" name="billing_country" value="{{ old('billing_country') }}">
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>