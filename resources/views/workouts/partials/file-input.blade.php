<div class="agilo-upload-file__container">
    <div class="agilo-upload-file__button-wrapper mdl-button mdl-button--raised mdl-button--colored mdl-js-button mdl-js-ripple-effect">
        <span class="agilo-upload-file__button-label">{{ trans($label) }}</span>
        <input class="agilo-upload-file__button" type="file" name="{{ $name }}">
    </div>
    <div class="agilo-upload-file__path-wrapper">
        <input class="agilo-upload-file__path mdl-textfield__input" type="text" readonly>
    </div>
</div>
