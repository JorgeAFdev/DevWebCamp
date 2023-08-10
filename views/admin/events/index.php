<h2 class="dashboard__heading"><?php echo $title; ?></h2>

<div class="dashboard__container-button">
    <a class="dashboard__button" href="/admin/events/create">
        <i class="fa-solid fa-circle-plus"></i>
        Add Event
    </a>
</div>

<div class="dashboard__container">
    <?php if(!empty($events)) { ?>
        <div class="table-wrapper">
            <table class="table">
                <thead class="table__thead">
                    <tr>
                        <th scope="col" class="table__th">Name</th>
                        <th scope="col" class="table__th">Category</th>
                        <th scope="col" class="table__th">Day and Time</th>
                        <th scope="col" class="table__th">Speaker</th>
                        <th scope="col" class="table__th"></th>
                    </tr>
                </thead>

                <tbody class="table__tbody">
                    <?php foreach($events as $event) { ?>
                        <tr class="table__tr">
                            <td class="table__td">
                                <?php echo $event->name; ?>
                            </td>
                            <td class="table__td">
                                <?php echo $event->category->name; ?>
                            </td>
                            <td class="table__td">
                                <?php echo $event->day->name . ", " . $event->time->time; ?>
                            </td>
                            <td class="table__td">
                                <?php echo $event->speaker->name . " " . $event->speaker->surname; ?>
                            </td>
                            <td class="table__td--actions">
                                <a class="table__action table__action--edit" href="/admin/events/edit?id=<?php echo $event->id; ?>">
                                    <i class="fa-solid fa-pencil"></i>
                                    Edit
                                </a>

                                <form method="POST" class="table__form" action="/admin/events/delete">
                                    <input type="hidden" name="id" value="<?php echo sanitizeHTML($event->id); ?>">
                                    <button class="table__action table__action--delete" type="submit">
                                        <i class="fa-solid fa-circle-xmark"></i>
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    <?php } else { ?>
        <p class="text-center">No Events Yet</p>        
    <?php } ?>
</div>

<?php  
    echo $pagination;
?>