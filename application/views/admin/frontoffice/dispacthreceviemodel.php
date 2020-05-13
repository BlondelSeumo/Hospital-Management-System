<table class="table table-striped bordergray">      
    <tr>
        <th><?php echo $this->lang->line('to_title'); ?></th>
        <td><?php print_r($data['to_title']); ?></td>
        <th><?php echo $this->lang->line('reference_no'); ?></th>
        <td><?php print_r($data['reference_no']); ?></td>
    </tr>
    <tr>
        <th><?php echo $this->lang->line('address'); ?></th>
        <td><?php print_r($data['address']); ?></td>
        <th><?php echo $this->lang->line('note'); ?></th>
        <td><?php print_r($data['note']); ?></td>
    </tr>
    <tr>
        <th><?php echo $this->lang->line('from_title'); ?></th>
        <td><?php print_r($data['from_title']); ?></td>
        <th><?php echo $this->lang->line('date'); ?></th>
        <td><?php print_r(date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($data['date']))); ?></td>
    </tr> 
</table>