<h2 class="dashboard__heading"><?php echo $title; ?></h2>

<div class="dashboard__container">
    <?php if(!empty($registeredData)) { ?>
        <div class="table-wrapper">
            <table class="table">
                <thead class="table__thead">
                    <tr>
                        <th scope="col" class="table__th">Name</th>
                        <th scope="col" class="table__th">Email</th>
                        <th scope="col" class="table__th">Package</th>
                        <th scope="col" class="table__th">Payment ID</th>
                    </tr>
                </thead>

                <tbody class="table__tbody">
                    <?php foreach($registeredData as $data) { ?>
                        <tr class="table__tr">
                            <td class="table__td">
                                <?php echo $data['user']->name . " " . $data['user']->surname; ?>
                            </td>
                            <td class="table__td">
                                <?php echo $data['user']->email; ?>
                            </td>
                            <td class="table__td">
                                <?php echo $data['package']->name; ?>
                            </td>
                            <td class="table__td">
                                <?php echo $data['pay']->pay_id; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    <?php } else { ?>
        <p class="text-center">No Records Yet</p>        
    <?php } ?>
</div>

<?php  
    echo $pagination;
?>