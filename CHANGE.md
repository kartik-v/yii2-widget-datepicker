Change Log: `yii2-widget-datepicker`
====================================

## Version 1.4.7

**Date:** 09-Oct-2018

- Bump composer dependencies.

## Version 1.4.6

**Date:** 29-Aug-2018

- Correct Asset Bundle registration to validate `bsVersion`.
- (enh #170): Add Bootstrap 4.x support.
- Reorganize source code in `src` directory.

## Version 1.4.5

- (no changes) - bump up version

## version 1.4.4

**Date:** 13-Jul-2018

- (enh #168): Add Kazakh translations.
- (enh #166, #165): Simplify INLINE editor behavior.
- (enh #164, #161, #160): Remove interim z-index fix for BS modal dialog.
- (enh #154): Add support for jQuery 3.x - update source plugin to v1.8.0.
- (enh #150): Enhance to make `form-control` CSS class the default and yet optional.
- (enh #149): Add Finnish translations.

## version 1.4.3

**Date:** 04-Sep-2017

- Add github contribution and issue/PR logging templates.
- (enh #131): Add Romanian translations.
- (enh #128): Update bootstrap-datepicker to 1.7.1.
- (enh #127): Allow overriding the `form-control` input CSS class.
- (enh #120): Add Estonian translations.
- (enh #117): Add Dutch (NL) translations.
- (enh #116): Add Gujarati and Hindi language translations.
- (enh #115): Add Indonesian translations.

## version 1.4.2

**Date:** 02-Sep-2016

- Enhance PHP Documentation for all classes in the extension
- (enh #108): Correct bootstrap datepicker CSS for source map url.
- (enh #107): Add Italian translations.

## version 1.4.1

**Date:** 17-Aug-2016

- (enh #102): Add Lithuanian translations.
- (enh #98): Add Japanese translations.
- (enh #96): Update locale files for plugin.

## version 1.4.0

**Date:** 28-Jun-2016

- (enh #95): Update to latest release v1.7 of bootstrap datepicker plugin.
- (enh #86): Add Thai translations.

## version 1.3.9

**Date:** 29-Mar-2016

- (bug #85): Correct locale files to use `kvDatepicker` modified plugin instance.

## version 1.3.8

**Date:** 25-Mar-2016

- (enh #84): Update to latest version 1.6.x of `bootstrap-datepicker` plugin.
- (enh #78): Add Slovak translations.
- Add branch alias for dev-master latest release.
- (bug #75): Enhance clear button method to trigger input change correctly.

## version 1.3.7

**Date:** 10-Jan-2016

- Update year.
- (enh #68): Add Czech translations

## version 1.3.6

**Date:** 29-Dec-2015

- (bug #67): Correct init of locale dates for `$.fn.kvDatepicker`.

## version 1.3.5

**Date:** 28-Dec-2015

- (enh #64): Enhance and improve language & locale validation.
- (bug #63): Fix extra brace bug in plugin JS code.

## version 1.3.4

**Date:** 27-Dec-2015

- Refactor code and code formatting improvements.
- Update to latest stable release (v1.5.0) of bootstrap-datepicker plugin.
- (enh #62): Add Turkish Translations.
- (enh #61): Add Swedish Translations.
- (enh #59): Clean up Greek translations
- (enh #56): Enhance widget to focus the input on opening datepicker via addon icon.
- (enh #55): Enhance plugin to validate `enableOnReadonly` correctly for all layout types.
- (enh #52): Fixed class name in DatePicker.
- (enh #50): Add French Translations.
- (enh #47): Enhancement for managing layout - **BC Breaking**.
    - New property `layout` to control rendering of picker and remove buttons and add your own input group addons if necessary.
    - The `addon` property will be removed as the `layout` property will allow better control for adding custom bootstrap input group addons.
    - Will be applicable for `TYPE_COMPONENT_PREPEND`, `TYPE_COMPONENT_APPEND`, and `TYPE_RANGE`.
- (enh #46): Add Polish translations.
- (enh #45): Add Greek translations.

## version 1.3.3

**Date:** 19-Jul-2015

- (enh #44): Fix markup for `DatePicker::TYPE_INLINE`.
- (enh #43): Correct triggering of `changeDate` event for `DatePicker::TYPE_INLINE`.
- (enh #41): Add Chinese translations.
- (enh #40): Add Latvian translations.
- (enh #36): Configure addon for prepend, append, and range.
- (bug #35): Parse `title` correctly for calendar/remove button addon.
- (enh #39): Add Spanish translations.
- (enh #30): Add Ukranian translations.
- (enh #29): Fix locale js files to use the new noconflict `kvDatepicker` function.
- (enh #28): Update to latest ## version of bootstrap-datepicker.
- (enh #27): Enhance plugin to use no conflict approach.

## version 1.3.2

**Date:** 25-Feb-2015

- (enh #25): Improve validation to retrieve the right translation messages folder.
- (bug #24): Removes BOM charecters from the messages/ru/kvdate.php.
- (enh #22): Ability to configure picker button options. Applicable only for following `DatePicker` types:
    - `DatePicker::TYPE_COMPONENT_PREPEND` and 
    - `DatePicker::TYPE_COMPONENT_APPEND` 
- (enh #21): Add new remove button to clear dates. Applicable only for following `DatePicker` types:
    - `DatePicker::TYPE_COMPONENT_PREPEND` and 
    - `DatePicker::TYPE_COMPONENT_APPEND` 

## version 1.3.1

**Date:** 13-Feb-2015

- Set copyright year to current.
- Use minified js files for locales.
- Update datepicker plugin to the latest release.
- (enh #19): Store date picker widget type as data attribute

## version 1.3.0

**Date:** 25-Jan-2015

- (bug #16): Fix directory separator for assets path in setLanguage.
- (enh #8): Create Tajikistan translations.
- Update to latest release of datepicker plugin.

## version 1.2.0

**Date:** 04-Dec-2014

- (enh #5): Include styling of markup rightly based on type for `disabled` and `readonly`
- (enh #4): Auto validate disability using new `disabled` and `readonly` properties in InputWidget
- (bug #3): Fix setLanguage asset locales registration.
- (enh #1): Add a new markup TYPE_BUTTON with hidden input.

## version 1.1.0

**Date:** 29-Nov-2014

- Set release to stable
- (enh #2): Enhance language locale file parsing and registering

## version 1.0.0

**Date:** 08-Nov-2014

- Initial release 
- Sub repo split from [yii2-widgets](https://github.com/kartik-v/yii2-widgets)