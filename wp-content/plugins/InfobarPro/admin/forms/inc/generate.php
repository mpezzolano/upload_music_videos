<?php

function nb_createinput($type, $options) {
    $index = 0;
    if (isset($options['mand']) == true) {
        $mandatory = '<span> *</span>';
    } else {
        $mandatory = '';
    }
    switch ($type) {
        case 'radio':
            $html = '<label class="radio" for="' . $options['name'] . '">' . $options['label'] . ': </label>';
            foreach ($options['values'] as $value) {
                $html .= '<input class="radio" type="radio" id="' . $options['id'] . '" name="' . $options['name'] . '" value="' . $value . '"' . checked($options['sel'], $value, false) . '> ' . $options['labels'][$index] . $options['after'];
                $index++;
            }
            break;
        case 'select':
            $html = '<label class="select" for="' . $options['name'] . '">' . $options['label'] . ': </label>
			<select class="select" id="' . $options['id'] . '" name="' . $options['name'] . '">
			<option value=""' . selected($options['sel'], '', false) . '></option>';
            foreach ($options['values'] as $value) {
                $html .= '<option' . selected($options['sel'], $value->id, false) . ' value="' . $value->id . '">' . $value->name . ' (bgcolor: ' . $value->bgcolor . ' - fontcolor: ' . $value->fontcolor . ')</option>' . chr(13);
            }
            $html .= '</select>';
            break;
        case 'text':
            $html = '<label class="textinput" for="' . $options['name'] . '">' . $options['label'] . $mandatory . ': </label>
			<input id="' . $options['id'] . '" type="text" class="textinput" size="' . $options['size'] . '" name="' . $options['name'] . '" value="' . $options['sel'] . '" />';
            break;
        case 'smalltext':
            $html = '<label class="textinput" for="' . $options['name'] . '">' . $options['label'] . $mandatory . ': </label>
			<input id="' . $options['id'] . '" type="text" class="input" size="' . $options['size'] . '" name="' . $options['name'] . '" value="' . $options['sel'] . '" />';
            break;
        case 'multitext':
            $html = '<label class="textinput" for="' . $options['name'] . '">' . $options['label'] . $mandatory . ': </label>
			<textarea id="' . $options['id'] . '" name="' . $options['name'] . '" rows="' . $options['rows'] . '" cols="' . $options['cols'] . '">' . $options['sel'] . '</textarea>';
            break;
        case 'color':
            $html = '<label class="textinput" for="' . $options['name'] . '">' . $options['label'] . $mandatory . ': </label>
			<input id="' . $options['id'] . '" type="text" class="color {hash:true,caps:false,required:false}" size="' . $options['size'] . '" name="' . $options['name'] . '" value="' . $options['sel'] . '" />';
            break;
        case 'notusedyet':
            $html = '<label class="textinput" for="' . $options['name'] . '">' . $options['label'] . $mandatory . ': </label>
			<input id="' . $options['id'] . '-link-color" type="text" class="colorinput" size="' . $options['size'] . '" name="' . $options['name'] . '" value="' . $options['sel'] . '" />
			<!--<a href="#" class="' . $options['id'] . '-pickcolor link-color-example hide-if-no-js" id="' . $options['id'] . '-color-example"></a>-->	
			<input type="button" class="' . $options['id'] . '-pickcolor button hide-if-no-js" value="' . __('Select a Color', 'infobar') . '" />
			<div id="' . $options['id'] . '-colorpicker" style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;"></div>
			<!--<span>' . __('Default color:', 'infobar') . ' <span id="' . $options['id'] . '-default-color"><a href="#">#ffffff</a></span></span>-->';
            $html = nb_colorpicker($options['id']) . $html;
            break;
    }
    if (!empty($options['desc'])) {
        $html .= ' <small>(' . $options['desc'] . ')</small>';
    }
    echo $html;
}

?>