<h2>My magazines</h2>

<?php
$this->table->set_heading('Publication', 'Issue', 'Date', 'Action');
$tmpl = array ( 'table_open'  => '<table class="table table-striped table-bordered">' );
$this->table->set_template($tmpl);
echo $this->table->generate($magazines);

