<div class="group-faqs edit">
    <?=form_open()?>
    <fieldset>
        <legend><?=lang('faqs_edit_legend')?></legend>
        <?php

            $field             = array();
            $field['key']      = 'label';
            $field['label']    = lang('faqs_edit_field_label');
            $field['required'] = true;
            $field['default']  = isset($faq->label) ? $faq->label : '';

            echo form_field($field);

            // --------------------------------------------------------------------------

            $field             = array();
            $field['key']      = 'group';
            $field['label']    = lang('faqs_edit_field_group');
            $field['required'] = true;
            $field['default']  = isset($faq->group) ? $faq->group : '';

            echo form_field($field);

            // --------------------------------------------------------------------------

            $field             = array();
            $field['key']      = 'body';
            $field['label']    = lang('faqs_edit_field_body');
            $field['required'] = true;
            $field['default']  = isset($faq->body) ? $faq->body : '';

            echo form_field_wysiwyg($field);

            // --------------------------------------------------------------------------

            $field             = array();
            $field['key']      = 'order';
            $field['label']    = lang('faqs_edit_field_order');
            $field['default']  = isset($faq->order) ? $faq->order : 0;

            echo form_field($field);

        ?>
    </fieldset>
    <p>
        <?=form_submit('submit', lang('action_save_changes'), 'class="awesome"');?>
    </p>
    <?=form_close();?>
</div>