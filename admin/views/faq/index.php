<div class="group-faqs browse">
    <p>
        <?=lang('faqs_index_intro')?>
    </p>
    <?php

        echo adminHelper('loadSearch', $search);
        echo adminHelper('loadPagination', $pagination);

    ?>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th class="label"><?=lang('faqs_index_th_label')?></th>
                    <th class="label"><?=lang('faqs_index_th_group')?></th>
                    <th class="order text-center"><?=lang('faqs_index_th_order')?></th>
                    <th class="actions"><?=lang('faqs_index_th_actions')?></th>
                </tr>
            </thead>
            <tbody>
                <?php

                if ($faqs) {

                    foreach ($faqs as $faq) {

                        echo '<tr>';
                            echo '<td class="label">';
                                echo $faq->label;
                            echo '</td>';
                            echo '<td class="group">';
                                echo $faq->group ? $faq->group : 'No Group';
                            echo '</td>';
                            echo '<td class="order text-center">';
                                echo $faq->order;
                            echo '</td>';
                            echo '<td class="actions">';

                                if (userHasPermission('admin:faq:faq:edit')) :

                                    echo anchor('admin/faq/faq/edit/' . $faq->id, lang('action_edit'), 'class="awesome small"');

                                endif;

                                if (userHasPermission('admin:faq:faq:delete')) :

                                    echo anchor('admin/faq/faq/delete/' . $faq->id, lang('action_delete'), 'class="awesome red small confirm" data-body="You cannot undo this action"');

                                endif;

                            echo '</td>';
                        echo '<tr>';
                    }

                } else {

                    ?>
                    <tr>
                        <td colspan="4" class="no-data"><?=lang('faqs_index_no_faqs')?></td>
                    </tr>
                    <?php
                }

                ?>
            </tbody>
        </table>
    </div>
    <?php

        echo adminHelper('loadPagination', $pagination);

    ?>
</div>