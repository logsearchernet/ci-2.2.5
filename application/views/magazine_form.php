<?php echo validation_errors(); ?>
<?php
$formAttributes = array('class' => 'form-horizontal');
$labelAttributes = array(
'class' => 'col-md-6',
);
$inputAttributes = 'class="form-control"';
?>
<?php echo form_open('magazine/magazine_form', $formAttributes); ?>

    <div class="form-group">
        <?php echo form_label('Issue Number', 'issue_number', $labelAttributes); ?>
        <div class="col-md-6">
        <?php echo form_input('issue_number', $issue->issue_number, $inputAttributes); ?>
        </div>
    </div>
    <div class="form-group">
        <?php echo form_label('Date Published', 'issue_date_publication', $labelAttributes); ?>
        <div class="col-md-6">
        <?php echo form_input('issue_date_publication', $issue->issue_date_publication, $inputAttributes); ?>
        </div>
    </div>
    <div class="form-group">
        <?php echo form_label('', '', $labelAttributes); ?>
        <div class="col-md-6">
        <?php echo form_hidden("issue_id", $issue->issue_id); ?>
        <?php echo form_submit('save', 'Save'); ?>
        </div>
    </div>
<?php echo form_close(); ?>