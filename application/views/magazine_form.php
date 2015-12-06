<?php echo validation_errors(); ?>
<?php echo form_open_multipart(); ?>

    <div>
        <?php echo form_label('Issue Number', 'issue_number'); ?>
        <?php echo form_input('issue_number', $issue->issue_number); ?>
    </div>
    <div>
        <?php echo form_label('Date Published', 'issue_date_publication'); ?>
        <?php echo form_input('issue_date_publication', $issue->issue_date_publication); ?>
    </div>
    <div>
        <?php echo form_hidden("issue_id", $issue->issue_id); ?>
        <?php echo form_submit('save', 'Save'); ?>
    </div>
<?php echo form_close(); ?>