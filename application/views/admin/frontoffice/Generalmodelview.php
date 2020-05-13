<table class="table table-striped bordergray">     
    <tr>
        <th><?php echo $this->lang->line('name'); ?></th>
        <td><?php print_r($Call_data['name']); ?></td>

        <th><?php echo $this->lang->line('phone'); ?></th>
        <td> <?php print_r($Call_data['contact']); ?></td>
    </tr>
    <tr>
        <th><?php echo $this->lang->line('date'); ?></th>
        <td><?php echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($Call_data['date'])); ?></td>
        <th><?php echo $this->lang->line('next_follow_up_date'); ?></th>
        <td><?php print_r(date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($Call_data['follow_up_date']))); ?></td>
    </tr>
    <tr>
        <th><?php echo $this->lang->line('call_duration'); ?></th>
        <td><?php print_r($Call_data['call_dureation']); ?></td>
        <th><?php echo $this->lang->line('call_type'); ?></th>
        <td><?php print_r($Call_data['call_type']); ?></td>
    </tr>       
    <tr>
        <th><?php echo $this->lang->line('description'); ?></th>
        <td><?php print_r($Call_data['description']); ?></td>
        <th><?php echo $this->lang->line('note'); ?></th>
        <td><?php print_r($Call_data['note']); ?></td>
    </tr>   
</table>