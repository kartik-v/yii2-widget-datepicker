<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2018
 * @package yii2-widgets
 * @subpackage yii2-widget-datepicker
 * @version 1.4.6
 */

namespace kartik\date;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;
use yii\widgets\ActiveForm;
use kartik\base\InputWidget;
use kartik\field\FieldRangeAsset;

/**
 * DatePicker widget is a Yii2 wrapper for the Bootstrap DatePicker plugin by @eternicode and provides a flexible
 * datepicker widget in Bootstrap style.This DatePicker widget by Krajee also includes additional features and
 * enhancements to the core plugin like better useful bootstrap addons. It includes an enhanced date clear addon button
 * to clear dates easily. It also adds ability to configure and render the datepicker INLINE, or as a BUTTON, or as a
 * date RANGE by integrating with the [[\kartik\field\FieldRange]] widget.
 *
 * Usage example:
 *
 * ~~~
 * use kartik\date\DatePicker;
 * // usage without model
 * echo '<label>Check Issue Date</label>';
 * echo DatePicker::widget([
 *     'name' => 'check_issue_date',
 *     'value' => date('d-M-Y', strtotime('+2 days')),
 *     'options' => ['placeholder' => 'Select issue date ...'],
 *     'pluginOptions' => [
 *         'format' => 'dd-M-yyyy',
 *         'todayHighlight' => true
 *     ]
 * ]);
 * ~~~
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 * @see http://eternicode.github.io/bootstrap-datepicker/
 */
class DatePicker extends InputWidget
{
    /**
     * Datepicker rendered as a plain input.
     */
    const TYPE_INPUT = 1;
    /**
     * Datepicker with the date picker button rendered as a prepended bootstrap addon component
     */
    const TYPE_COMPONENT_PREPEND = 2;
    /**
     * Datepicker with the date picker button rendered as a appended bootstrap addon component
     */
    const TYPE_COMPONENT_APPEND = 3;
    /**
     * Datepicker calendar directly rendered inline
     */
    const TYPE_INLINE = 4;
    /**
     * Datepicker range with from and to date inputs
     */
    const TYPE_RANGE = 5;
    /**
     * Datepicker rendered as a picker button without any input
     */
    const TYPE_BUTTON = 6;

    /**
     * @var string the markup type of widget markup must be one of the TYPE constants. Defaults to
     * [[TYPE_COMPONENT_PREPEND]]
     */
    public $type = self::TYPE_COMPONENT_PREPEND;

    /**
     * @var string the markup for the calendar picker icon. If not set this will default to:
     * - `<i class="glyphicon glyphicon-calendar kv-dp-icon"></i>` if [[bsVersion]] is set to `3.x`
     * - `<i class="fas fa-calendar-alt kv-dp-icon"></i>` if [[bsVersion]] is set to `4.x`
     */
    public $pickerIcon;

    /**
     * @var string the markup for the remove icon (which will clear the datepicker data). If not set this will default to:
     * - `<i class="glyphicon glyphicon-remove kv-dp-icon"></i>` if [[bsVersion]] is set to `3.x`
     * - `<i class="fas fa-times kv-dp-icon"></i>` if [[bsVersion]] is set to `4.x`
     */
    public $removeIcon;

    /**
     * @var string the size of the input - 'lg', 'md', 'sm', 'xs'
     */
    public $size;

    /**
     * @var ActiveForm the ActiveForm object which you can pass for seamless usage with ActiveForm. This property is
     * especially useful for client validation of [[attribute2]] for [[TYPE_RANGE]] validation.
     */
    public $form;

    /**
     * @var array the HTML attributes for the button that is rendered for [[TYPE_BUTTON]]. Defaults to
     * - `['class'=>'btn btn-default']` for [[bsVersion]] = '3.x', and
     * - `['class'=>'btn btn-secondary']` for [[bsVersion]] = '4.x'
     * The following special options are recognized:
     * - 'label': string the button label. Defaults to the [[pickerIcon]] setting.
     */
    public $buttonOptions = [];

    /**
     * @var string additional CSS class that will be appended to the date input `class` within [[options]] and
     * [[options2]]. Defaults to `form-control`. This value can be changed for custom (non Bootstrap) CSS styling.
     */
    public $addInputCss = 'form-control';

    /**
     * @var array the HTML attributes for the input tag.
     */
    public $options = [];

    /**
     * @var string the layout template to display the buttons (applicable only  when [[type]] is set to one of
     * [[TYPE_COMPONENT_PREPEND]] or [[TYPE_COMPONENT_APPEND]] or [[TYPE_RANGE]]). The following tokens will be
     * parsed and replaced when [[type]] is set to one of [[TYPE_COMPONENT_PREPEND]] or [[TYPE_COMPONENT_APPEND]]:
     * - `{picker}`: will be replaced with the date picker button (rendered as a bootstrap input group addon).
     * - `{remove}`: will be replaced with the date clear/remove button (rendered as a bootstrap input group addon).
     * - `{input}`: will be replaced with the HTML input markup that stores the date.
     *
     * When [[type]] is set to [[TYPE_RANGE]] the following tokens will be parsed and replaced:
     *
     * - `{input1}`: will be replaced with the HTML input markup that stores the date for attribute1.
     * - `{separator}`: will be replaced with the input group addon for field range separator. The text for the
     *    separator is set via the `separator` property.
     * - `{input2}`: will be replaced with the HTML input markup that stores the date for attribute2.
     *
     * The [[layout]] property defaults to the following value if not set:
     *
     * - `{picker}{remove}{input}` for [[TYPE_COMPONENT_PREPEND]]
     * - `{input}{remove}{picker}` for [[TYPE_COMPONENT_APPEND]]
     * - `{input1}{separator}{input2}` for [[TYPE_RANGE]]
     */
    public $layout;

    /**
     * @var array|string|boolean the calendar picker button configuration.
     * - if this is passed as a _string_, it will be displayed as is (will not be HTML encoded).
     * - if this is set to `false`, the picker button will not be displayed.
     * - if this is passed as an _array_ (which is the default) it will be parsed as HTML attributes for the button (to
     *   be displayed as a Bootstrap addon). The following special keys are recognized;
     *   - `label`: _string_, the label for the button. Defaults to [[pickerIcon]].
     *   - `title`: _string|_boolean_, the title to be displayed on hover. Defaults to 'Select date & time'. To disable,
     *     set it to `false`.
     */
    public $pickerButton = [];

    /**
     * @var array|string|boolean the calendar remove button configuration - applicable only for type set to
     * [[TYPE_COMPONENT_PREPEND]] or [[TYPE_COMPONENT_APPEND]].
     * - if this is passed as a _string_, it will be displayed as is (will not be HTML encoded).
     * - if this is set to `false`, the remove button will not be displayed.
     * - if this is passed as an _array_ (this is the DEFAULT) it will treat this as HTML attributes for the button (to
     *   be displayed as a Bootstrap addon). The following special keys are recognized;
     *   - `label`: _string_, the label for the button. Defaults to [[removeIcon]].
     *   - `title`: _string|_boolean_, the title to be displayed on hover. Defaults to 'Clear field'. To disable,
     *     set it to `false`.
     */
    public $removeButton = [];

    /**
     * @var string the model attribute 2 if you are setting [[type]] to [[TYPE_RANGE]] for markup.
     */
    public $attribute2;

    /**
     * @var string the name of input number 2 if you are setting [[type]] to [[TYPE_RANGE]] for markup.
     */
    public $name2;

    /**
     * @var string the name of value for input number 2 if you are setting [[type]] to [[TYPE_RANGE]] for markup.
     */
    public $value2 = null;

    /**
     * @var array the HTML attributes for the input number 2 if you are setting [[type]] to [[TYPE_RANGE]] for markup.
     */
    public $options2 = [];

    /**
     * @var string the range input separator if you are setting [[type]] to [[TYPE_RANGE]] for markup. Defaults to 'to'.
     */
    public $separator = 'to';

    /**
     * @var array the HTML options for the DatePicker container.
     */
    private $_container = [];

    /**
     * @var boolean whether a prepend or append addon exists.
     */
    protected $_hasAddon = false;

    /**
     * @inheritdoc
     */
    protected $_msgCat = 'kvdate';

    /**
     * @inheritdoc
     */
    public $pluginName = 'kvDatepicker';

    /**
     * @inheritdoc
     *
     * @throws InvalidConfigException
     */
    public function run()
    {
        parent::run();
        $this->renderDatePicker();
    }

    /**
     * Initializes picker icon and remove icon
     * @param string $type the icon type 'picker' or 'remove'
     * @param string $bs3Icon the icon suffix name for Bootstrap 3 version
     * @param string $bs4Icon the icon suffix name for Bootstrap 4 version
     */
    protected function initIcon($type, $bs3Icon, $bs4Icon)
    {
        $css = $this->isBs4() ? "fas fa-{$bs4Icon}" : "glyphicon glyphicon-{$bs3Icon}";
        $icon = $type . 'Icon';
        if (!isset($this->$icon)) {
            $this->$icon = Html::tag('i', '', ['class' => $css . ' kv-dp-icon']);
        }
    }

    /**
     * Renders the date picker widget.
     * @throws InvalidConfigException
     */
    protected function renderDatePicker()
    {
        $this->validateConfig();
        $this->initIcon('picker', 'calendar', 'calendar-alt');
        $this->initIcon('remove', 'remove', 'times');
        $this->_hasAddon = $this->type == self::TYPE_COMPONENT_PREPEND || $this->type == self::TYPE_COMPONENT_APPEND;
        $s = DIRECTORY_SEPARATOR;
        $this->initI18N(__DIR__);
        $this->setLanguage('bootstrap-datepicker.', __DIR__ . "{$s}assets{$s}", null, '.min.js');
        $this->parseDateFormat('date');
        $this->_container['id'] = $this->options['id'] . '-' . $this->_msgCat;
        if ($this->type == self::TYPE_INLINE) {
            $this->_container['data-date'] = $this->value;
        }
        if (empty($this->layout)) {
            if ($this->type === self::TYPE_COMPONENT_PREPEND) {
                $this->layout = '{picker}{remove}{input}';
            } elseif ($this->type === self::TYPE_COMPONENT_APPEND) {
                $this->layout = '{input}{remove}{picker}';
            } elseif ($this->type === self::TYPE_RANGE) {
                $this->layout = '{input1}{separator}{input2}';
            }
        }
        Html::addCssClass($this->options, [$this->addInputCss, 'krajee-datepicker']);
        $this->options['data-datepicker-source'] = $this->type === self::TYPE_INPUT ? $this->options['id'] :
            $this->_container['id'];
        $this->options['data-datepicker-type'] = $this->type;
        $this->registerAssets();
        echo $this->renderInput();
    }

    /**
     * Raise an invalid configuration exception.
     *
     * @param string $msg the exception message
     *
     * @throws InvalidConfigException
     */
    protected static function err($msg = '')
    {
        throw new InvalidConfigException($msg);
    }

    /**
     * Validates widget configuration.
     *
     * @throws InvalidConfigException
     */
    protected function validateConfig()
    {
        if ($this->type < 1 || $this->type > 6 || !is_int($this->type)) {
            static::err("Invalid value for the property 'type'. Must be an integer between 1 and 6.");
        }
        if ($this->type === self::TYPE_RANGE) {
            if ($this->attribute2 === null && $this->name2 === null) {
                static::err("Either 'name2' or 'attribute2' properties must be specified for a datepicker 'range' markup.");
            }
            if (!class_exists("\\kartik\\field\\FieldRangeAsset")) {
                static::err(
                    "The yii2-field-range extension is not installed and is a pre-requisite for a DatePicker " .
                    "RANGE type. To install this extension run this command on your console: \n\n" .
                    "php composer.phar require kartik-v/yii2-field-range \"*\""
                );
            }
        }
        if (!isset($this->form)) {
            return;
        }
        if (!$this->form instanceof ActiveForm) {
            static::err("The 'form' property must be of type \\yii\\widgets\\ActiveForm");
        }
        if (!$this->hasModel()) {
            static::err("You must set the 'model' and 'attribute' properties when the 'form' property is set.");
        }
        if ($this->type === self::TYPE_RANGE && !isset($this->attribute2)) {
            static::err("The 'attribute2' property must be set for a 'range' type markup and a defined 'form' property.");
        }
    }

    /**
     * Renders the source input for the DatePicker plugin.
     *
     * @return string
     */
    protected function renderInput()
    {
        if ($this->type == self::TYPE_INLINE) {
            if (empty($this->options['readonly'])) {
                $this->options['readonly'] = true;
            }
            Html::addCssClass($this->options, ['input-sm', 'text-center']);
        }
        if (isset($this->form) && ($this->type !== self::TYPE_RANGE)) {
            $vars = call_user_func('get_object_vars', $this);
            unset($vars['form']);
            return $this->form->field($this->model, $this->attribute)->widget(self::class, $vars);
        }
        $input = $this->type == self::TYPE_BUTTON ? 'hiddenInput' : 'textInput';
        return $this->parseMarkup($this->getInput($input));
    }

    /**
     * Returns the addon to render
     *
     * @param array $options the HTML attributes for the addon
     * @param string $type whether the addon is the picker or remove
     *
     * @return string
     */
    protected function renderAddon(&$options, $type = 'picker')
    {
        $isPicker = $type === 'picker';
        if ($options === false || (!$isPicker && $type !== 'remove')) {
            return '';
        }
        if (is_string($options)) {
            return $options;
        }
        $css = $this->isBs4() ? 'input-group-text' : 'input-group-addon';
        Html::addCssClass($options, [$css, "kv-date-{$type}"]);
        $iconType = "{$type}Icon";
        $icon = ArrayHelper::remove($options, 'label', $this->$iconType);
        $title = ArrayHelper::getValue($options, 'title', '');
        if ($title !== false && empty($title)) {
            $options['title'] = $isPicker ? Yii::t('kvdate', 'Select date') : Yii::t('kvdate', 'Clear field');
        }
        return Html::tag('span', $icon, $options);
    }

    /**
     * Parses the input to render based on markup type.
     *
     * @param string $input
     *
     * @return string
     */
    protected function parseMarkup($input)
    {
        $disabled = $this->disabled ? 'disabled' : '';
        $size = isset($this->size) ? "input-{$this->size}" : '';
        $isBs4 = $this->isBs4();
        switch ($this->type) {
            case self::TYPE_INPUT:
                Html::addCssClass($this->options, [$size, $disabled]);
                return $input;
            case self::TYPE_COMPONENT_PREPEND:
            case self::TYPE_COMPONENT_APPEND:
                $size = isset($this->size) ? "input-group-{$this->size}" : '';
                Html::addCssClass($this->_container, ['input-group', $size, 'date']);
                $picker = $this->renderAddon($this->pickerButton);
                $remove = $this->renderAddon($this->removeButton, 'remove');
                if ($isBs4) {
                    $css = $this->type === self::TYPE_COMPONENT_APPEND ? 'append' : 'prepend';
                    $options = ['class' => 'input-group-' . $css];
                    $picker = Html::tag('div', $picker, $options);
                    $remove = Html::tag('div', $remove, $options);
                }
                $out = strtr($this->layout, [
                    '{picker}' => $picker,
                    '{remove}' => $remove,
                    '{input}' => $input,
                ]);
                return Html::tag('div', $out, $this->_container);
            case self::TYPE_BUTTON:
                Html::addCssClass($this->_container, ['date', $disabled]);
                $label = ArrayHelper::remove($this->buttonOptions, 'label', $this->pickerIcon);
                if (!isset($this->buttonOptions['disabled'])) {
                    $this->buttonOptions['disabled'] = $this->disabled;
                }
                if (empty($this->buttonOptions['class'])) {
                    $this->buttonOptions['class'] = 'btn btn-' . ($isBs4 ? 'secondary' : 'default');
                }
                $button = Html::button($label, $this->buttonOptions);
                Html::addCssStyle($this->_container, 'display:block');
                return Html::tag('span', "{$input}{$button}", $this->_container);
            case self::TYPE_RANGE:
                $size = isset($this->size) ? "input-group-{$this->size}" : '';
                Html::addCssClass($this->_container, ['input-group', $size, 'input-daterange']);
                $this->initDisability($this->options2);
                if (isset($this->form)) {
                    Html::addCssClass($this->options, [$this->addInputCss, 'kv-field-from']);
                    Html::addCssClass($this->options2, [$this->addInputCss, 'kv-field-to']);
                    $input = $this->form->field($this->model, $this->attribute, [
                        'template' => '{input}{error}',
                        'options' => ['class' => "kv-container-from {$this->addInputCss}"],
                    ])->textInput($this->options);
                    $input2 = $this->form->field($this->model, $this->attribute2, [
                        'template' => '{input}{error}',
                        'options' => ['class' => "kv-container-to {$this->addInputCss}"],
                    ])->textInput($this->options2);
                } else {
                    if (empty($this->options2['id'])) {
                        $this->options2['id'] = $this->hasModel() ? Html::getInputId($this->model, $this->attribute2) :
                            $this->getId() . '-2';
                    }
                    Html::addCssClass($this->options2, $this->addInputCss);
                    $input2 = $this->hasModel() ?
                        Html::activeTextInput($this->model, $this->attribute2, $this->options2) :
                        Html::textInput($this->name2, $this->value2, $this->options2);
                }
                $css = $isBs4 ? 'input-group-text' : 'input-group-addon';
                $sep = Html::tag('span', $this->separator, ['class' => $css . ' kv-field-seperator']);
                if ($isBs4) {
                    $sep = Html::tag('div', $sep, ['class' => 'input-group-append']);
                }
                $out = strtr($this->layout, [
                    '{input1}' => $input,
                    '{separator}' => $sep,
                    '{input2}' => $input2,
                ]);
                return Html::tag('div', $out, $this->_container);
            case self::TYPE_INLINE:
                Html::addCssClass($this->options, [$size, $disabled]);
                return Html::tag('div', $input, $this->_container);
            default:
                return '';
        }
    }

    /**
     * Registers the [[DatePicker]] widget client assets.
     */
    public function registerAssets()
    {
        if ($this->disabled) {
            return;
        }
        $view = $this->getView();
        $view->registerJs('jQuery.fn.kvDatepicker.dates={};');
        if (!empty($this->_langFile)) {
            DatePickerAsset::registerBundle($view, $this->bsVersion)->js[] = $this->_langFile;
        } else {
            DatePickerAsset::register($view, $this->bsVersion);
        }
        $id = $this->options['id'];
        $el = "jQuery('#" . $this->options['data-datepicker-source'] . "')";
        $this->registerPlugin($this->pluginName, $el);
        if ($this->_hasAddon && $this->removeButton !== false) {
            $view->registerJs("initDPRemove('{$id}');");
        }
        if ($this->_hasAddon) {
            $view->registerJs("initDPAddon('{$id}');");
        }
        if ($this->type === self::TYPE_RANGE) {
            FieldRangeAsset::register($view);
            $view->registerJs("initDPRemove('{$id}', true);");
        }
    }
}
