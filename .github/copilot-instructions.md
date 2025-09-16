# Copilot Instructions für mod_wbcbasicslider

Diese Anleitung richtet sich an AI Coding Agents, die in diesem Joomla-Modul arbeiten. Sie beschreibt die wichtigsten Architekturprinzipien, Workflows und Konventionen, um produktiv zu sein.

## Architektur & Komponenten
- **Joomla Modulstruktur**: Das Modul besteht aus `mod_wbcbasicslider.php` (Einstiegspunkt), `helper.php` (Logik), `tmpl/default.php` (Template), sowie statischen Assets unter `media/css` und `media/js`.
- **Datenfluss**: Bilder und Sliderdaten werden über das Joomla-Modul-Parameter-Formular (`mod_wbcbasicslider.xml`) konfiguriert und per `$params` an die Helper-Klasse und das Template übergeben.
- **Helper-Klasse**: Die zentrale Logik zur Bildauswahl liegt in `WbcBasicSliderHelper::getImages($params)`.
- **Template**: Das Rendering erfolgt in `tmpl/default.php`, wo die Slider-Buttons, die Bildliste und die Barrierefreiheit umgesetzt werden.
- **Assets**: CSS und JS werden im Template über Joomla WebAssetManager eingebunden (`registerAndUseStyle`, `registerAndUseScript`).

## Workflows
- **Build/Deploy**: Es gibt keinen Build-Prozess; Änderungen an PHP-, XML-, CSS- oder JS-Dateien sind direkt wirksam. Modul wird als ZIP installiert.
- **Debugging**: Fehler werden meist über Joomla-Fehlermeldungen oder Browser-DevTools (für JS/CSS) gefunden. PHP-Fehler erscheinen im Joomla-Log.
- **Konfiguration**: Die Bilddaten werden im Backend über das Modul-Formular gepflegt (`sliderimages` Subform).

## Konventionen & Patterns
- **Barrierefreiheit**: Slider verwendet ARIA-Attribute, `role`, `aria-label`, `aria-live` und Tastatursteuerung (Arrow-Keys).
- **Links**: Bilder können interne (`slide_link_intern`) oder externe (`slide_link_extern`) Links haben. Fallback ist `#`.
- **Asset-Pfade**: Assets werden relativ zu `media/mod_wbcbasicslider/` eingebunden.
- **Keine externen Abhängigkeiten**: Nur Joomla-Core und Vanilla JS/CSS werden verwendet.
- **Namensgebung**: Klassen und IDs sind nach dem Schema `wbc-basic_slider`, `slides`, `ls-status` benannt.

## Beispiele
- **Bilder abrufen**: `WbcBasicSliderHelper::getImages($params)` gibt ein Array von Bildobjekten zurück.
- **Asset-Einbindung**:
  ```php
  $wa->registerAndUseStyle('mod_logoslider.style', 'media/mod_wbcbasicslider/css/style.css');
  $wa->registerAndUseScript('mod_logoslider.script', 'media/mod_wbcbasicslider/js/script.js');
  ```
- **Slider-HTML**:
  ```html
  <div class="wbc-basic_slider" role="region" aria-label="Partner-Logos" tabindex="0"> ... </div>
  ```

## Wichtige Dateien
- `mod_wbcbasicslider.php`: Modul-Einstieg
- `helper.php`: Logik für Bilddaten
- `tmpl/default.php`: HTML-Template
- `media/css/style.css`: Slider-Styles
- `media/js/script.js`: Slider-Logik
- `mod_wbcbasicslider.xml`: Modul-Definition & Parameter

---

Bitte Feedback geben, falls wichtige Workflows, Konventionen oder Integrationspunkte fehlen oder unklar sind.