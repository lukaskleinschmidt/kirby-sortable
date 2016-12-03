<?php

class OptionsField extends CheckboxesField {

  public function input() {

    $value = func_get_arg(0);
    $data  = func_get_arg(1);

    $input = parent::input($value);

    if(!$this->error) {
      $input->attr('checked', v::accepted($this->value()) || v::accepted($data->checked()));
    }

    if($data->readonly()) {
      $input->attr('disabled', true);
      $input->attr('readonly', true);
      $input->addClass('input-is-readonly');
    }

    return $input;

  }

  public function item($value, $data) {

    $data  = new Obj($data);
    $input = $this->input($value, $data);

    $label = new Brick('label', '<span>' . $this->i18n($data->label()) . '</span>');
    $label->addClass('input input-with-checkbox');
    $label->attr('data-focus', 'true');
    $label->prepend($input);

    if($data->readonly()) {
      $label->addClass('input-is-readonly');
    }

    return $label;

  }

}
