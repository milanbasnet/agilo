<?php

return [
    'title.required' => 'Geben Sie einen Titel ein.',
    'workout_title.required' => 'Geben Sie den Namen der Übung an.',
    'title_in_app.required' => 'Geben Sie den Namen der Übung, welcher in der App angezeigt wird, an.',
    'workout_title.max' => 'Der Name der Übung darf maximal :max Zeichen lang sein.',
    'title_in_app.max' => 'Der Name der Übung (App) darf maximal :max Zeichen lang sein.',
    'starting_position.required' => 'Geben Sie die Startposition ein.',
    'execution.required' => 'Geben Sie Hinweise zur Auswührung ein.',
    'passwords_match' => 'Das eingegebene Passwort stimmt nicht mit dem gespeicherten Passwort überein.',
    'video' => 'Das hochgeladene Video entspricht nicht den Anforderungen.',
    'custom' => [
        'workout_id' => [
            'required' => 'Wählen Sie eine Übung aus',
        ],
        'email' => [
            'required' => 'Bitte geben Sie eine E-Mail-Adresse an.',
            'email' => 'Bitte geben Sie eine gültige E-Mail-Adress an.',
            'max' => 'Bitte geben Sie eine gültige E-Mail-Adress an.',
            'unique' => 'Die angegebene E-Mail-Adresse ist bereits vergeben.',
            'exists'=>'Soori! Emailadresse wurde nicht gefunden.'
        ],
        'code'=>[
            'required' =>'Das Feld Code ist erforderlich.'
        ],
        'password' => [
            'required' => 'Bitte geben Sie ein Passwort an.',
            'confirmed' => 'Die eingegebenen Passwörter stimmen nicht überein.',
            'min'       => 'Passwort muss mindestens 6 Zeichen lang sein',
        ],
        'sport' => [
            'required' => 'Wählen Sie eine Sportart aus.',
            'integer' => 'Wählen Sie eine gültige Sportart aus.',
            'exists' => 'Wählen Sie eine gültige Sportart aus.',
        ],
        'level' => [
            'required' => 'Wählen Sie ein Niveau aus.',
            'integer' => 'Wählen Sie ein gültiges Niveau aus.',
            'exists' => 'Wählen Sie ein gültiges Niveau aus.',
        ],
        'workouts_per_week' => [
            'required' => 'Geben Sie die Trainingseinheiten pro Woche an.',
            'integer' => 'Geben Sie einen gültigen Wert für Trainingseinheiten pro Woche an',
            'between' => 'Die Trainingseinheiten pro Woche müssen zwischen :min und :max liegen'
        ],
        'users' => [
            'required' => 'Ordnen Sie mindestens einen Betreuer zu.',
            'max' => 'Sie können maximal :max Betreuer zuordnen.',
            'therapists' => 'Ordnen Sie mindestens einen Betreuer zu.',
        ],
        'first_name' => [
            'required' => 'Geben Sie einen Vornamen an.',
        ],
        'last_name' => [
            'required' => 'Geben Sie einen Nachnamen an.',
        ],
        'birth' => [
            'required' => 'Geben Sie ein Geburtsdatum ein.',
            'date' => 'Geben Sie gültiges ein Geburtsdatum ein.',
        ],
        'title' => [
            'required' => 'Geben Sie einen Titel ein.',
            'max' => 'Der Titel darf maximal :max Zeichen lang sein.',
        ],
        'content' => [
            'required' => 'Geben Sie einen Inhalt ein.',
        ],
        'name' => [
            'required' => 'Geben Sie einen Namen ein.',
        ],
        'contact' => [
            'required' => 'Geben Sie den Namen der Kontaktperson ein.',
        ],
        'street' => [
            'required' => 'Geben Sie eine Straße mit Hausnummer ein.',
        ],
        'zip_code' => [
            'required' => 'Geben Sie eine Postleitzahl ein.',
        ],
        'city' => [
            'required' => 'Geben Sie eine Stadt ein.',
        ],
        'country' => [
            'required' => 'Geben Sie ein Land ein.',
        ],
        'phone' => [
            'required' => 'Geben Sie eine Telefonnummer ein.',
        ],
        'image' => [
            'required' => 'Geben Sie ein Bild an.',
            'image' => 'Wählen Sie ein gültiges Bild aus. Bilder sind nur im Format JPEG und PNG erlaubt und dürfen 2 MB nicht überschreiten.',
            'mimes' => 'Wählen Sie ein gültiges Bild aus. Bilder sind nur im Format JPEG und PNG erlaubt und dürfen 2 MB nicht überschreiten',
            'max' => 'Wählen Sie ein gültiges Bild aus. Bilder sind nur im Format JPEG und PNG erlaubt und dürfen 2 MB nicht überschreiten',
            'uploaded'=>'Bitte wählen Sie eine gültige Bilddatei',
        ],
        'type' => [
            'required' => 'Geben Sie einen Typ an.',
            'integer' => 'Geben Sie einen gültigen Typ an.',
            'exists' => 'Geben Sie einen gültigen Typ an.',
        ],
        'sports' => [
            'sports' => 'Wählen Sie Sportarten aus.',
        ],
        'has_billing_address' => [
            'boolean' => 'Prüfen Sie Ihre Eingaben.',
        ],
        'billing_name' => [
            'required_if' => 'Geben Sie einen Namen für die Rechnungsadresse ein.',
        ],
        'billing_street' => [
            'required_if' => 'Geben Sie die Straße und Hausnummer der Rechnungsadresse ein.',
        ],
        'billing_zip_code' => [
            'required_if' => 'Geben Sie die Postleitzahl der Rechnungsadresse ein.',
        ],
        'billing_city' => [
            'required_if' => 'Geben Sie die Stadt der Rechnungsadresse ein.',
        ],
        'billing_country' => [
            'required_if' => 'Geben Sie das Land und Hausnummer der Rechnungsadresse ein.',
        ],
        'old_password' => [
            'required_with' => 'Geben Sie Ihr altes und neues Passwort ein und bestätigen Sie das neue Passwort.',
            'passwords_match' => 'Das angegebene Passwort stimmt nicht mit Ihrem Passwort überein.',
        ],
        'new_password' => [
            'required_with' => 'Geben Sie Ihr altes und neues Passwort ein und bestätigen Sie das neue Passwort.',
            'same' => 'Das neue Passwort und die Passwort-Bestästigung stimmen nicht überein.',
        ],
        'role' => [
            'required' => 'Wählen Sie eine Rolle aus.',
            'integer' => 'Wählen Sie eine gültige Rolle aus.',
            'exists' => 'Wählen Sie eine gültige Rolle aus.',
        ],
        'measure' => [
            'required' => 'Wählen Sie eine Maßnahme aus.',
            'integer' => 'Wählen Sie eine gültige Maßnahme aus.',
            'exists' => 'Wählen Sie eine gültige Maßnahme aus.',
        ],
        'regions' => [
            'required' => 'Wählen Sie mindestens eine Region aus.',
            'regions' => 'Wählen Sie eine gültige Region aus.',
        ],
        'objective' => [
            'required' => 'Wählen Sie ein Trainingsziel aus.',
            'integer' => 'Wählen Sie ein gültiges Trainingsziel aus.',
            'exists' => 'Wählen Sie ein gültiges Trainingsziel aus.',
        ],
        'gender' => [
            'required' => 'Wählen Sie ein Geschlecht aus.',
            'integer' => 'Wählen Sie ein gültiges Geschlecht aus.',
            'exists' => 'Wählen Sie ein gültiges Geschlecht aus.',
        ],
        'age' => [
            'required' => 'Wählen Sie einen Altersbereich aus.',
            'integer' => 'Wählen Sie einen gültige Altersbereich aus.',
            'exists' => 'Wählen Sie einen gültige Altersbereich aus.',
        ],
        'frequence_default' => [
            'required' => 'Wählen Sie eine Frequenz aus.',
            'integer' => 'Wählen Sie eine gültige Frequenz aus.',
            'min' => 'Wählen Sie eine gültige Frequenz aus.',
            'max' => 'Wählen Sie eine gültige Frequenz aus.',
        ],
        'duration_default' => [
            'required' => 'Wählen Sie eine Dauer aus.',
            'integer' => 'Wählen Sie eine gültige Dauer aus.',
            'min' => 'Wählen Sie eine Dauer von mindestens :min aus.',
            'max' => 'Wählen Sie eine Dauer von maximal :max aus.',
        ],
        'pubmed_link' => [
            'url' => 'Geben Sie einen gültigen Link zu PubMed an.',
        ],
        'video' => [
            'required' => 'Geben Sie ein Video an.',
            'file' => 'Geben Sie ein Video an.',
            'mimetypes' => 'Wählen Sie ein gültiges Video aus. Das Video muss vom Typ video/mp4 sein.',
            'max' => 'Das Video darf maximal 50 MB groß sein.',
            'uploaded'=>'Bitte wählen Sie eine gültige Videodatei Das Video muss im MP4-Format sein und als Dateiendung .mp4 haben.
            Erlaubte Codecs: h264,
            Maximale Auflösung: 1920x1080,
            Maximale Länge: 30 Sekunden',

        ],
        'pace_tag_id'=>[
            'required'=> 'Das Tempofeld ist erforderlich',
        ],
        'level_tag_id'=>[
            'required'=> 'Das Level-Feld ist erforderlich',
        ],


        'token' => [
            'required' => 'Ihr Link ist ungültig.',
        ],
    ],
];
