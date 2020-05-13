<table class="table table-striped bordergray">    
    <tr>
        <th><?php echo $this->lang->line('purpose'); ?></th>
        <td><?php print_r($data['purpose']); ?></td>
        <th><?php echo $this->lang->line('name'); ?></th>
        <td><?php print_r($data['name']); ?></td>
    </tr>
    <tr>
        <th><?php echo $this->lang->line('phone'); ?></th>
        <td><?php print_r($data['contact']); ?></td>
        <th><?php echo $this->lang->line('number_of_person'); ?></th>
        <td><?php print_r($data['no_of_pepple']); ?></td>
    </tr>
    <tr>
        <th><?php echo $this->lang->line('date'); ?></th>
        <td><?php print_r(date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($data['date']))); ?></td>
        <th><?php echo $this->lang->line('in_time'); ?></th>
        <td><?php print_r($data['in_time']); ?></td>
    </tr>
    <tr>
        <th><?php echo $this->lang->line('out_time'); ?></th>
        <td><?php print_r($data['out_time']); ?></td>
        <th><?php echo $this->lang->line('note'); ?></th>
        <td><?php print_r($data['note']); ?></td>
    </tr>
</table>