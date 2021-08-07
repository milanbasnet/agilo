@foreach(LaravelLocalization::getSupportedLocales() as $key => $locale)
    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
        <label class="mdl-textfield__label" for="{{ $key }}.language">{{ trans('messages.language.label') }}</label>
        <input id="{{ $key }}.language" class="mdl-textfield__input" type="text" value="{{ $locale['native'] }}" disabled>
    </div>

    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
        <label class="mdl-textfield__label" for="{{ $key }}.title">{{ trans('messages.routines.title.label') }}</label>
        <input id="{{ $key }}.title" class="mdl-textfield__input" type="text"
               name="translation[{{ $key }}][title]" value="{{ old('translation.'. $key .'.title') }}">
    </div>

    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
        <label class="mdl-textfield__label" for="{{ $key }}.description">
            {{ trans('messages.routines.description.label') }}
        </label>
            <input type="text" name="translation[{{ $key }}][description]" id="{{ $key }}.description"
                   class="mdl-textfield__input" value="{{ trim(old('translation.'. $key .'.description')) }}"/>
    </div>

    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
        <label class="mdl-textfield__label" for="{{ $key }}.injuries">{{ trans('messages.routines.injuries.label') }}</label>
            <input type="text" name="translation[{{ $key }}][injuries]" id="{{ $key }}.injuries"
                   class="mdl-textfield__input" value="{{ trim(old('translation.'. $key .'.injuries')) }}"/>

    </div>
@endforeach