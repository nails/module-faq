<div class="group-faqs edit">
    <?=form_open()?>
    <fieldset>
        <legend><?=lang('faqs_edit_legend')?></legend>
        <?php


            $field             = array();
            $field['key']      = 'quote';
            $field['label']    = lang('faqs_edit_field_quote');
            $field['required'] = true;
            $field['default']  = isset($faq->quote) ? $faq->quote : '';

            echo form_field_wysiwyg($field);

            // --------------------------------------------------------------------------

            $field             = array();
            $field['key']      = 'quote_by';
            $field['label']    = lang('faqs_edit_field_quote_by');
            $field['required'] = true;
            $field['default']  = isset($faq->quote_by) ? $faq->quote_by : '';

            echo form_field($field);

            // --------------------------------------------------------------------------

            $field             = array();
            $field['key']      = 'quote_dated';
            $field['label']    = lang('faqs_edit_field_quote_dated');
            $field['default']  = isset($faq->quote_dated) ? $faq->quote_dated : '';

            echo form_field_date($field);

        ?>
    </fieldset>
    <p>
        <?=form_submit('submit', lang('action_save_changes'), 'class="awesome"');?>
    </p>
    <?=form_close();?>
</div>