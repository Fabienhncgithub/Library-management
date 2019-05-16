<!DOCTYPE html>
<html>
    <head>        
        <meta charset="UTF-8">
        <base href="<?= $web_root ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
        <title>Books</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="styles.css" rel="stylesheet" type="text/css"/>
        <script src="lib/jquery-3.3.1.min.js" type="text/javascript"></script>
         <script src="lib/fullcalendar-scheduler-4.1.0/packages/moment/main.js" type="text/javascript"></script>
        <script src="lib/fullcalendar-scheduler-4.1.0/packages/core/main.js" type="text/javascript"></script> 
         <script src="lib/fullcalendar-scheduler-4.1.0/packages/interaction/main.js" type="text/javascript"></script>
        <script src="lib/fullcalendar-scheduler-4.1.0/packages/timeline/main.js" type="text/javascript"></script>
         <script src="lib/fullcalendar-scheduler-4.1.0/packages/resource-common/main.js" type="text/javascript"></script>
        <script src="lib/fullcalendar-scheduler-4.1.0/packages/resource-timeline/main.js" type="text/javascript"></script>
    </head>
    <body>
        <script>
            $('#calendar').hide();
            console.log("coucou");
            document.addEventListener('DOMContentLoaded', function () {
                var calendarEl = document.getElementById('calendar');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    plugins: ['interaction', 'resourceTimeline'],
                    timeZone: 'UTC',
                    header: {
                        left: 'today prev,next',
                        center: 'title',
                        right: 'resourceTimelineDay,resourceTimelineTenDay,resourceTimelineMonth,resourceTimelineYear'
                    },
                    defaultView: 'resourceTimelineDay',
                    scrollTime: '08:00',
                    aspectRatio: 1.5,
                    views: {
                        resourceTimelineDay: {
                            buttonText: ':15 slots',
                            slotDuration: '00:15'
                        },
                        resourceTimelineTenDay: {
                            type: 'resourceTimeline',
                            duration: {days: 10},
                            buttonText: '10 days'
                        }
                    },
                    editable: true,
                    resourceLabelText: 'Rooms',
                    resources: 'https://fullcalendar.io/demo-resources.json?with-nesting&with-colors',
                    events: 'https://fullcalendar.io/demo-events.json?single-day&for-resource-timeline'
                });

                calendar.render();
            });
        </script>
        <div class="title"><?php echo $user->fullname; ?>!</div>



        <?php
        if ($user->isAdmin($user->username)) {
            include('menuAdmin.html');
        } else {
            include('menu.html');
        }
        ?>

        <div class="main">
            <form action="rental/filter_return" method="post">
                <input type="hidden" name="book" value="book">
                <table>
                    <thead>
                        <tr>
                            <td>Filters: </td>
                            <td>Member: <input id="member" name="member" type="text" ></td>
                            <td>Book: <input id="book" name="book" type="text"></td>
                            <td>Rental date: <input id="rental_date" name="rental_date" type="date"></td>
                        </tr>

                    <td>State:
                        <input type="radio" name="MyRadio" value="All" checked>All<br>
                        <input type="radio" name="MyRadio" value="Open">Open
                        <input type="radio" name="MyRadio" value="Return">Return
                    </td>

                </table>
                <th><input type="submit" name="search"></th>
                <table id="calendar">
                    <tr>
                        <th>Rental Date/Time</th>
                        <th>User</th>
                        <th>Book</th>
                        <th>To be returned on</th>
                        <th>Actions</th>

                    </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($returns as $return): ?>
                            <tr>
                                <td><?= $return->rentaldate ?></td>
                                <td><?= $return->user ?></td>
                                <td><?= $return->book ?></td>
                                <td><?= $return->returndate ?></td>
                                <td>
                                    <?php if ($user->isAdmin() || $user->isManager()): ?>
                                        <form  action='book/delete' method='post'>
                                            <input type='hidden' name='id_book' value='<?= $return->id ?>'>
                                            <input type='submit' value='delete'>
                                        </form>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if ($user->isAdmin() || $user->isManager()): ?>
                                        <form  action='rental/return_rental' method='post'>
                                            <input type='hidden' name='return' value='<?= $return->id ?>'>
                                            <input type='submit' value='return'>
                                        </form>
                                    <?php endif; ?>
                                </td>

                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>
        </div>
    </body>
</html>
